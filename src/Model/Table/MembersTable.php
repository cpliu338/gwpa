<?php
namespace App\Model\Table;
use Cake\Validation\Validator;

/**
 * Description of MembersTable
 *
 * @author cp_liu
 */
class MembersTable extends \Cake\ORM\Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('members');
        //$this->displayField('name'); //MAKE IT name1+name2
        $this->primaryKey('id');
        $this->hasMany('Subscriptions', [
            'foreignKey' => 'member_id'
        ]);
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                'created_at' => 'new',
                'updated_at' => 'always'
                ]
            ]
        ]);
    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
            
        $validator
            ->requirePresence('name1', 'create')
            ->notEmpty('name1');
            
        $validator
            ->requirePresence('name2', 'create')
            ->notEmpty('name2');

        $validator
            ->requirePresence('sex', 'create')
            ->notEmpty('sex');

        $validator
            ->requirePresence('stream', 'create')
            ->notEmpty('stream');

        $validator
            ->requirePresence('rank', 'create')
            ->notEmpty('rank');
        $validator
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        return $validator;
    }
}
