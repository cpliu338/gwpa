<?php
namespace App\Model\Table;
use Cake\Validation\Validator;

/**
 * Description of AccountsTable
 *
 * @author cp_liu
 */
class AccountsTable extends \Cake\ORM\Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('accounts');
        $this->primaryKey('id');
        $this->hasMany('Entries', [
            'foreignKey' => 'account_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');
            
        $validator
            ->requirePresence('code', 'create')
            ->notEmpty('code');

        return $validator;
    }
}
