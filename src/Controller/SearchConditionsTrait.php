<?php
namespace App\Controller;
use Cake\I18n\Time;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

trait SearchConditionsTrait {
    
    public function getConditions() {
        //'2015-04-01'
        $start = Time::parseDate($this->request->query('since'), FORMAT_DATE);
        if ($start===NULL) {
            $d = Time::today();
            if ($d->month < 4) {
                $start = $d->year($d->year-1)->month(4)->day(1);
            } else {
                $start = $d->month(4)->day(1);
            }
        }
        $end = clone($start);
        $end->setDate($start->year + (($start->month>3) ? 1 : 0),
                3, 31);
        return ['incurred_on >=' => $start,
            'incurred_on <=' => $end];
    }
    
    /**
     * 
     * @param type $cond array returned from getConditions
     */
    public function getBroughtForwardConditions($cond) {
        $start = clone($cond['incurred_on <=']);
        $start->setDate($start->year-1, 4, 1);
        return ['incurred_on <' => $cond['incurred_on >='],
            'incurred_on >=' => $start];
    }
}
?>
