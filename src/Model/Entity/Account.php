<?php

namespace App\Model\Account;

/**
 * Description of Account
 *
 * @author cp_liu
 */
class Account extends \Cake\ORM\Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'code' => true,
        'remark' => true
    ];
    
}
