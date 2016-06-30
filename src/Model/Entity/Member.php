<?php

namespace App\Model\Entity;

/**
 * Description of Member
 *
 * @author cp_liu
 */
class Member extends \Cake\ORM\Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name1' => true,
        'name2' => true,
        'sex' => true,
        'stream' => true,
        'rank' => true,
        'division' => true,
        'post' => true,
        'email' => true
    ];
    
    protected $name;
    
    public function &__get($property) {
    	if ($property == 'name') {
            $this->name = sprintf("%s %s", $this->name1, $this->name2);
            return $this->name;
    	}
        else {
            return $this->get($property);
        }
    }

}
