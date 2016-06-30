<?php

namespace App\Model\Entity;

/**
 * Description of Entry
 *
 * @author cp_liu
 */
class Entry extends \Cake\ORM\Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'ref' => true,
        'incurred_on' => true,
        'account_id' => true,
        'amount' => true,
        //'rank' => true,
        'detail' => true
    ];
    
}
