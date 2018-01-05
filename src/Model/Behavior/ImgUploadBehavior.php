<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


/**
 * CakePHP ImgUploadBehavior
 * @author kiwitech
 */
class ImgUploadBehavior extends Behavior {

    protected $_defaultConfig = [
        'field' => 'image',
        'uploadPath' => 'assets/upload/'
    ];
    private $_virtualField = [];
    
    private $_aws3 = [];
    
    private $aws3Obj = null;

    public function initialize(array $config) {
        $this->_aws3 = \Cake\Core\Configure::read('AWS3');
        $this->aws3Obj = S3Client::factory(['base_url' => $this->_aws3['url'],'key' => $this->_aws3['key'],'secret' => $this->_aws3['secret']]);
    }
    
    /**
     * beforeMarshal method
     * Prepare the requested data
     */
    
    public function beforeMarshal(Event $event, \ArrayObject $data, \ArrayObject $options) {
        if(is_array($this->_config['field'])){
            foreach($this->_config['field'] as $field){
                if (!empty($data[$field])) {
                    $this->_virtualField[$field] = $data[$field];
                }
            }            
        }else{
            if (!empty($data[$this->_config['field']])) {
                $this->_virtualField[$this->_config['field']] = $data[$this->_config['field']];
            }
        }
    }
    
    /**
     * beforeSave method
     * upload image before save the record
     */
    
    public function beforeSave(Event $event, $entity, \ArrayObject $options) {        
        if($this->_config['where']=='s3'){
            $this->uploadToAWS($entity);            
        }else{
            $this->uploadLocal($entity);
        }
        
    }
    
    public function beforeDelete(Event $event, $entity, \ArrayObject $options) {
    //public function beforeDelete(Event $event, Entity $entity) {
        if($this->_config['where']=='s3'){
            if(is_array($this->_config['field'])){
                foreach($this->_config['field'] as $field){
                    $filename = $entity->get($field);
                    if(!empty($filename)){
                        $this->_deleteFromASW($entity,$filename);
                    }
                }            
            }else{
                $filename = $entity->get($this->_config['field']);
                $this->_deleteFromASW($entity,$filename);
            }
        }else{
            $this->deleteLocalFile($entity);
        }
    }

    /**
     * get appropriate fields with files
     * move uploaded file and set path to entity field, but only if a file was selected
     *
     * @param Entity $entity
     */
    public function uploadLocal($entity) {
        $config = $this->config();
        if (empty($this->_virtualField)) {
            return;
        }
        if (!is_array($config['field'])) {
            $field = $this->_virtualField[$config['field']];
            if (empty($field['tmp_name'])) {
                $entity->unsetProperty($config['field']);
            } else {
                if (($entity->get($config['field']) != $entity->getOriginal($config['field']))) {
                    $originalFilePath = $entity->getOriginal($config['field']);
                    $this->_delete($originalFilePath);
                }
                $filePath = $this->_moveToLocal($field);
                
                $entity->set($config['field'], $filePath);                
            }
        }
    }

    private function _moveToLocal($uploadField) {
        $uploadPath = $this->config('uploadPath');
        $uploadFolder = new Folder(ROOT . DS . 'webroot' . DS . $uploadPath, true, 0755);
        $tmp_file = new File($uploadField['tmp_name'], true);
        if (!$tmp_file->exists()) {
            return false;
        }
        $file = new File($uploadFolder->path . DS . $uploadField['name']);
        if (!$tmp_file->copy($uploadFolder->pwd() . $uploadField['name'])) {
            return false;
        }
        $file->close();
        $tmp_file->delete();
        return $uploadField['name'];
    }
    
    /**
     * Method to upload file to S3.
     * This method also deletes the old files from S3.
     *     
     * @return boolean
     */
    public function uploadToAWS($entity) {
        $config = $this->config();
        if (empty($this->_virtualField)) {
            return;
        }
        if (!is_array($config['field'])) {            
            $requestField  =$this->_virtualField[$config['field']];
            if (!empty($requestField['tmp_name'])) {
                if (($entity->get($config['field']) != $entity->getOriginal($config['field']))) {
                    $originalFilePath = $entity->getOriginal($config['field']);
                    $this->_deleteFromASW($entity,$originalFilePath);
                }
                $fileName = $config['uploadPath'].$this->uniqueString($requestField['name']);
                //echo $fileName;die;
                #$fileExt = $this->fileAttrbute($fileName,'extension');
                $filePath = $this->__saveToAWS($requestField,$fileName);                
                $entity->set($config['field'], $filePath);                
            }else{
                $entity->unsetProperty($config['field']);
            }
        }else{
           foreach($config['field'] as $field){
               if (!empty($this->_virtualField[$field]['tmp_name'])) {
                   if (($entity->get($field) != $entity->getOriginal($field))) {
                        $originalFilePath = $entity->getOriginal($field);
                        $this->_deleteFromASW($entity,$originalFilePath);
                    }
                    $fileName = $config['uploadPath'].$this->uniqueString($this->_virtualField[$field]['name']);
                    $filePath = $this->__saveToAWS($this->_virtualField[$field],$fileName);                
                    $entity->set($field, $filePath);                
                }else{
                    $entity->unsetProperty($field);
                }
           } 
        }
        
    }
    
    private function __saveToAWS($requestField,$fileName){        
        try {
            $resource = fopen($requestField['tmp_name'], 'r');
            $AWS3File = $this->aws3Obj->upload($this->_aws3['bucket'], $fileName, $resource, 'public-read');         
        } catch (S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
        return $AWS3File['ObjectURL'];
    }
    
    public function _deleteFromASW($entity,$filename=null){
        if($filename==null){ 
             $filename = $entity->get($this->_config['field']);
        }
        if(empty($filename)){
            return;
        }
        $fileKey = str_replace('https://'.$this->_aws3['bucket'].'.s3.amazonaws.com/', '', $filename);
        //echo $fileKey.'<br>';
        try {
            $result = $this->aws3Obj->deleteObject([
                'Bucket' => $this->_aws3['bucket'],
                'Key'    => $fileKey
            ]);  
        } catch (S3Exception $ex) {
            die('File not found to delete.'.  print_r($ex, true));
        }
    }

    /**
     * try to delete file from local storage
     *
     * @param $file
     * @return bool
     */
    public function deleteLocalFile($entity) {
        $config = $this->config();
        if (!is_array($config['field'])) {
            $filePath = $entity->get($config['field']);
            $this->_removeFileFromLocal($filePath);
        } else {
            foreach ($config['field'] AS $value) {
                $filePath = $entity->get($value);
                $this->_removeFileFromLocal($filePath);
            }
        }
    }

    private function _removeFileFromLocal($filePath) {
        $fileObject = new File($filePath);
        return $fileObject->delete();
    }

    

    
    
    public function uniqueString($name) {
        if(empty($name) || $name == "" ){
            return false;
        }
        $file = $this->fileAttrbute($name);
        $fileName = $this->senitizeString($file['filename']);
        $newFileName = $fileName . '_' . date('YmdHis') . '.' . $file['extension'];
        return $newFileName;
    }

    public function senitizeString($name) {
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", " ", "-", ".");
        $filename = str_replace($special_chars, '_', $name);
        $filename = preg_replace('/[\s-__]+/', '_', $filename);
        $filename = trim($filename, '.-_');
        return $filename;
    }
    
    public function fileAttrbute($file,$field=null){
        $fileAttrbute = pathinfo(strtolower($file));
        if($field != null){
            return $fileAttrbute[$field];
        }else{
            return $fileAttrbute;
        }
    }

    

}
