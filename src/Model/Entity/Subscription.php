<?php

/**
 * Description of Subscription
 *
 * @author cp_liu
 */
class Subscription extends \Cake\ORM\Entity {
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'year1' => true,
        'batch' => true,
        'member_id' => true
    ];
}
