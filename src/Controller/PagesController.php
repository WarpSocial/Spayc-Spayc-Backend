<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    public function importCategory() {
        $file = WWW_ROOT . 'catlist.xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();
// Get the highest row and column numbers referenced in the worksheet
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
        $catArray = [];
        
        echo '<table>' . "\n";
        for ($row = 2; $row <= $highestRow; ++$row) {
            echo '<tr>' . PHP_EOL;
            $parentCat = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $catArray[$parentCat][] = [
                'name'=>$worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                'description'=>$worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                'slug'=>\Cake\Utility\Inflector::slug($worksheet->getCellByColumnAndRow(1, $row)->getValue()),
                'code'=>$worksheet->getCellByColumnAndRow(5, $row)->getValue()
            ];
            echo '<td>' . ($row-1) . '</td>' . PHP_EOL;
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                
                $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                
                echo '<td>' . $value . '</td>' . PHP_EOL;
            }
            echo '</tr>' . PHP_EOL;
        }
        echo '</table>' . PHP_EOL;
         $catEntity = \Cake\ORM\TableRegistry::get('Api.SpaycCategories');
         $catEntity->connection()->query('TRUNCATE TABLE spayc_categories RESTART IDENTITY;')->execute();
        foreach($catArray as $cat=>$subcats){
            $pcat = $catEntity->newEntity([
                'name'=>$cat,
                'slug'=> \Cake\Utility\Inflector::slug(strtolower($cat)),
                'description'=>$cat,
                'code'=>$subcats[0]['code']
            ]);
            $pEntity = $catEntity->save($pcat);
            if($pEntity){
                foreach($subcats as $key=>$child){
                    $child['parent_id'] = $pcat->id;
                    $childCat = $catEntity->newEntity($child);
                    $catEntity->save($childCat);
                }
            }
        }
        pr($catArray);
        die("END");
    }

    public function apiList() {
        $this->render('api_list', false);
    }

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display(...$path) {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

}
