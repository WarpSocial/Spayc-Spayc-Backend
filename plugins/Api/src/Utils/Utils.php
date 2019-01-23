<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api\Utils;

use Cake\Utility\Text;
use Cake\I18n\Time;
use Cake\Core\Configure;

/**
 * Description of Sanatize
 *
 * @author kiwitech
 */
class Utils {

    /**
     * getVar method to return the value from array
     * 
     * @param string $var key of array
     * @param array $array array of keys
     * 
     * @return string value of key
     */
    public static function getVar($var, $array) {
        if (is_array($array)) {
            if (isset($array[$var])) {
                return $array[$var];
            } else {
                return "";
            }
        }
    }

    /**
     * Removes any non-alphanumeric characters.
     *
     * @param string $string String to sanitize
     * @param array $allowed An array of additional characters that are not to be removed.
     * @return string Sanitized string
     */
    public static function paranoid($string, $allowed = array()) {
        $allow = null;
        if (!empty($allowed)) {
            foreach ($allowed as $value) {
                $allow .= "\\$value";
            }
        }

        if (!is_array($string)) {
            return preg_replace("/[^{$allow}a-zA-Z0-9]/", '', $string);
        }

        $cleaned = array();
        foreach ($string as $key => $clean) {
            $cleaned[$key] = preg_replace("/[^{$allow}a-zA-Z0-9]/", '', $clean);
        }

        return $cleaned;
    }

    /**
     * Returns given string safe for display as HTML. Renders entities.
     *
     * strip_tags() does not validating HTML syntax or structure, so it might strip whole passages
     * with broken HTML.
     *
     * ### Options:
     *
     * - remove (boolean) if true strips all HTML tags before encoding
     * - charset (string) the charset used to encode the string
     * - quotes (int) see http://php.net/manual/en/function.htmlentities.php
     * - double (boolean) double encode html entities
     *
     * @param string $string String from where to strip tags
     * @param array $options Array of options to use.
     * @return string Sanitized string
     */
    public static function html($string, $options = array()) {
        static $defaultCharset = false;
        if ($defaultCharset === false) {
            $defaultCharset = Configure::read('App.encoding');
            if ($defaultCharset === null) {
                $defaultCharset = 'UTF-8';
            }
        }
        $defaults = array(
            'remove' => false,
            'charset' => $defaultCharset,
            'quotes' => ENT_QUOTES,
            'double' => true
        );

        $options += $defaults;

        if ($options['remove']) {
            $string = strip_tags($string);
        }

        return htmlentities($string, $options['quotes'], $options['charset'], $options['double']);
    }

    /**
     * Strips extra whitespace from output
     *
     * @param string $str String to sanitize
     * @return string whitespace sanitized string
     */
    public static function stripWhitespace($str) {
        return preg_replace('/\s{2,}/u', ' ', preg_replace('/[\n\r\t]+/', '', $str));
    }

    /**
     * Strips image tags from output
     *
     * @param string $str String to sanitize
     * @return string Sting with images stripped.
     */
    public static function stripImages($str) {
        $preg = array(
            '/(<a[^>]*>)(<img[^>]+alt=")([^"]*)("[^>]*>)(<\/a>)/i' => '$1$3$5<br />',
            '/(<img[^>]+alt=")([^"]*)("[^>]*>)/i' => '$2<br />',
            '/<img[^>]*>/i' => ''
        );

        return preg_replace(array_keys($preg), array_values($preg), $str);
    }

    /**
     * Strips scripts and stylesheets from output
     *
     * @param string $str String to sanitize
     * @return string String with <link>, <img>, <script>, <style> elements and html comments removed.
     */
    public static function stripScripts($str) {
        $regex = '/(<link[^>]+rel="[^"]*stylesheet"[^>]*>|' .
                '<img[^>]*>|style="[^"]*")|' .
                '<script[^>]*>.*?<\/script>|' .
                '<style[^>]*>.*?<\/style>|' .
                '<!--.*?-->/is';
        return preg_replace($regex, '', $str);
    }
    
    /**
     * validTimestamp to validate the unix timestamp
     * 
     * @param string $timeStamp unix Timestamp value
     * @return Bool return either true or false
     */
    public static function validTimestamp($strTimestamp) {
        return ((string) (int) $strTimestamp === $strTimestamp) && ($strTimestamp <= PHP_INT_MAX) && ($strTimestamp >= ~PHP_INT_MAX);
    }

    /**
     * Strips extra whitespace, images, scripts and stylesheets from output
     *
     * @param string $str String to sanitize
     * @return string sanitized string
     */
    public static function stripAll($str) {
        return self::stripScripts(
                        self::stripImages(
                                self::stripWhitespace($str)
                        )
        );
    }

    /**
     * Strips the specified tags from output. First parameter is string from
     * where to remove tags. All subsequent parameters are tags.
     *
     * Ex.`$clean = Sanitize::stripTags($dirty, 'b', 'p', 'div');`
     *
     * Will remove all `<b>`, `<p>`, and `<div>` tags from the $dirty string.
     *
     * @param string $str String to sanitize.
     * @return string sanitized String
     */
    public static function stripTags($str) {
        $params = func_get_args();

        for ($i = 1, $count = count($params); $i < $count; $i++) {
            $str = preg_replace('/<' . $params[$i] . '\b[^>]*>/i', '', $str);
            $str = preg_replace('/<\/' . $params[$i] . '[^>]*>/i', '', $str);
        }
        return $str;
    }

    /**
     * Sanitizes given array or value for safe input. Use the options to specify
     * the connection to use, and what filters should be applied (with a boolean
     * value). Valid filters:
     *
     * - odd_spaces - removes any non space whitespace characters
     * - encode - Encode any html entities. Encode must be true for the `remove_html` to work.
     * - dollar - Escape `$` with `\$`
     * - carriage - Remove `\r`
     * - unicode -
     * - escape - Should the string be SQL escaped.
     * - backslash -
     * - remove_html - Strip HTML with strip_tags. `encode` must be true for this option to work.
     *
     * @param string|array $data Data to sanitize
     * @param string|array $options If string, DB connection being used, otherwise set of options
     * @return mixed Sanitized data
     */
    public static function clean($data, $options = array()) {
        if (empty($data)) {
            return $data;
        }

        if (!is_array($options)) {
            $options = array('connection' => $options);
        }

        $options += array(
            'connection' => 'default',
            'odd_spaces' => true,
            'remove_html' => false,
            'encode' => true,
            'dollar' => true,
            'carriage' => true,
            'unicode' => true,
            'escape' => true,
            'backslash' => true
        );

        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[$key] = self::clean($val, $options);
            }
            return $data;
        }

        if ($options['odd_spaces']) {
            $data = str_replace(chr(0xCA), '', $data);
        }
        if ($options['encode']) {
            $data = self::html($data, array('remove' => $options['remove_html']));
        }
        if ($options['dollar']) {
            $data = str_replace("\\\$", "$", $data);
        }
        if ($options['carriage']) {
            $data = str_replace("\r", "", $data);
        }
        if ($options['unicode']) {
            $data = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $data);
        }
        if ($options['escape']) {
            $data = self::escape($data, $options['connection']);
        }
        if ($options['backslash']) {
            $data = preg_replace("/\\\(?!&amp;#|\?#)/", "\\", $data);
        }
        return $data;
    }

    public static function cleanInput($input) {
        return $input;

        $search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );

        $output = preg_replace($search, '', $input);
        return $output;
    }

    public static function escape($input) {
        return $input;
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = self::clean($val);
            }
        } else {
            $output = filter_var(strip_tags(stripcslashes(trim($input))), FILTER_SANITIZE_STRING);
        }
        return $output;
    }

    public static function getToken() {
        $token = \Cake\Utility\Security::randomBytes(32);
        $hash = \Cake\Utility\Security::hash($token, 'sha256', false);
        return $hash;
    }

    public static function logWrite($message, $lavel = 'info') {
        \Cake\Log\Log::write($lavel, $message);
    }

    public static function setUtc($dateTime, $timezone = 'UTC') {
        if ($dateTime instanceof \Cake\I18n\Time) {
            $date = $dateTime->format('Y-m-d H:i:s');
        } elseif ($dateTime instanceof \DateTime) {
            $date = $dateTime->format('Y-m-d H:i:s');
        } else {
            $date = $dateTime;
        }
        $dateObj = new Time($date, $timezone);
        $dateObj->setTimezone('UTC');
        return $dateObj->format('Y-m-d H:i:s');
    }

    public static function getFromUtc($dateTime, $timezone = 'UTC') {
        if ($dateTime instanceof \Cake\I18n\Time) {
            $date = $dateTime->format('Y-m-d H:i:s');
        } elseif ($dateTime instanceof \DateTime) {
            $date = $dateTime->format('Y-m-d H:i:s');
        } else {
            $date = $dateTime;
        }
        $dateObj = new Time($date, 'UTC');
        $dateObj->setTimezone($timezone);
        return $dateObj->format('Y-m-d H:i:s');
    }

    /**
     * getDistanceByLatLong method
     * function use to get distance spayc to user
     * @param string|null $data.
     * @return \Cake\Network\Response|null return json
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public static function distanceBetweenTwoPoints($lat1, $lon1, $lat2, $lon2, $unit) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public static function isValidLongitude($longitude = null) {
        if (preg_match("/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,20}$/", $longitude)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isValidLatitude($latitude) {
        if (preg_match("/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,20}$/", $latitude)) {
            return true;
        } else {
            return false;
        }
    }

    public static function extractKeys($data = [], $key = []) {
        if (empty($data)) {
            return;
        }
        for ($i = 0; $i < count($data); $i++) {
            
        }
    }

    public static function toUtc($datetime,$dateTimeformat = 'm-d-Y H:i:s',$utcFormat='Y-m-d H:i:s') {
        $timezone = Configure::read('timezone');
        if (!empty($datetime)) {
            if(strtolower($datetime) == 'now'){
                $datetime = (new Time('now',$timezone));
            }else{
                if(is_object($datetime)){
                    $datetime = $datetime->format($dateTimeformat);
                }
                $datetime = Time::createFromFormat($dateTimeformat, $datetime, $timezone);
            }
            return $datetime->setTimezone(new \DateTimeZone('UTC'))->format($utcFormat);
        } else {
            return;
        }
    }

    public static function toClient($datetime,$dateTimeformat = 'm-d-Y H:i:s',$utcFormat='Y-m-d H:i:s') {
        $timezone = Configure::read('timezone');
        if (!empty($datetime)) {
            if(@strtolower($datetime) == 'now'){
                $datetime = (new Time('now','UTC'));
            }else{
                if(is_object($datetime)){
                    $datetime = $datetime->format($utcFormat);
                }
                $datetime = Time::createFromFormat($utcFormat, $datetime, 'UTC');
            }
            return $datetime->setTimezone(new \DateTimeZone($timezone))->format($dateTimeformat);
        } else {
            return;
        }
    }

    public static function distance($lat1=null, $lon1=null, $lat2=null, $lon2=null, $unit='M') {
        //echo $lat1.'<br>'.$lon1.'<br>'.$lat2.'<br>'.$lon2;die;
        if(empty($lat1) || empty($lon1) || empty($lat2) || empty($lon2)){
            return null;
        }
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            //echo number_format($miles,5);
            return number_format($miles,5);
        }
    }
    
    public static function uniqueInteger(){
        $uniqueid = abs(crc32(uniqid())).str_replace("0.","",abs( microtime()));
        return $uniqueid;
    }
    public static function getMimeType($file){
        $finfo = new \finfo();
        $fileinfo = $finfo->file($file, FILEINFO_MIME);
        return $fileinfo;
    }
    public static function dateRangeUtc($timezone,$days){
        $now = new Time('now', $timezone);        
        $endObj = clone $now;
        $now->modify('today');
        $timeStmap = $now->getTimestamp();        
        $endObj->modify('+'.$days.' days');
        $endObj->modify('1 second ago'); 
        $today_date = $now->setTimezone('UTC')->format("Y-m-d H:i");
        $twoWeek = $endObj->setTimezone('UTC')->format("Y-m-d H:i"); 
        return ['start'=>$today_date,'end'=>$twoWeek];
    }

}
