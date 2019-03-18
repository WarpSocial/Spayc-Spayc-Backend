<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\View;

use Cake\View\View;
use Cake\Utility\Hash;
use Cake\Core\Configure;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link https://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize() {
        $errorTemplates = [
            'error' => '<small class="input-alert">{{content}}</small>',
        ];
        $this->Form->setTemplates($errorTemplates);
    }

    public function dateFormat($dateTime, $format = DATEFORMAT_DISPLAY) {
        if (empty($dateTime)) {
            return;
        }
        if ($dateTime instanceof \Cake\I18n\Time) {
            $date = $dateTime->format($format);
        } elseif ($dateTime instanceof \DateTime) {
            $date = $dateTime->format($format);
        } else {
            $date = (new \Cake\I18n\Time($dateTime))->format($format);
        }
        return $date;
    }

    public function eventRepeat($warpFrequency) {
        if (empty($warpFrequency[0])) {
            return;
        }
        if ($warpFrequency[0]->repeat_type == WEEKLY) {
            //echo $warpFrequency[0]->day_of_week;die;
            $string = __('Repeat every week on '.$this->dayOfWeek($warpFrequency[0]->day_of_week));
        } elseif ($warpFrequency[0]->repeat_type == CUSTOM) {
            $string = __('Repeat on following date ' . $warpFrequency[0]->repeat_date);
        } else {
            $string = __('Repeat daily');
        }
        return $string;
    }

    public function spycCategories($spayc) {
        if (empty($spayc['warp_categories'])) {
            return null;
        }
        $categoreis = [];
        foreach ($spayc['warp_categories'] as $categories):
            if (!empty($categories->spayc_category)) {
                $categoreis[] = $this->emoji($categories->spayc_category->code) . " " . $categories->spayc_category->name;
            }
        endforeach;
        return implode(', ', $categoreis);
    }

    public function warpImage($spayc) {
        $element = '';
        $emoji = false;
        /* if event has image */
        if (!empty($spayc->image)) {
            $element = $this->Html->image($spayc->image, ["alt" => $spayc->name, 'class' => 'warp-img']);
        } elseif (!empty($spayc['warp_categories'])) {
            /* if event has no image but has emoji */
            $category = Hash::extract($spayc['warp_categories'], '{n}[is_primary=1]');
            if (!empty($category['0']->spayc_category)) {
                $emoji = true;
                $element = '<span class="emoji d-flex align-items-center justify-content-center w-100 h-100">' . $this->emoji($category['0']->spayc_category->code) . '</span>';
            }
        } else {
            /* event has neither image nor emoji then default image will render */
            $element = $this->Html->image('no-image-big.png', ["alt" => $spayc->name, 'class' => 'warp-img']);
        }
        if ($emoji) {
            return '<div class="image-wrap blank-emoji">' . $element . '</div>';
        } else {
            return '<div class="image-wrap ">' . $element . '</div>';
        }
    }

    public function emoji($code) {
        $hexCode = explode(',', $code);
        if (count($hexCode) > 1) {
            return "&#" . hexdec($hexCode[0]) . "&#" . hexdec($hexCode[1]) . ";";
        } else {
            return "&#" . hexdec($code) . ";";
        }
    }

    public function warpCategories($spayc) {
        if (empty($spayc['warp_categories'])) {
            return null;
        }
        $primary = null;
        $other = [];
        foreach ($spayc['warp_categories'] as $categories):
            if ($categories->is_primary) {
                $primary = $categories->spayc_category_id;
            } else {
                $other[] = $categories->spayc_category_id;
            }
        endforeach;
        return [
            'primary' => $primary,
            'other' => $other,
        ];
    }
    public function dayOfWeek($daysVal){
        $days = array_intersect_key(Configure::read('day_of_week'), explode(',',$daysVal));
        return implode(', ',$days);
    }

}
