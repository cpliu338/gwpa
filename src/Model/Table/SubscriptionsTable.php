<?php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Description of SubscriptionsTable
 *
 * @author cp_liu
 */
class SubscriptionsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('subscriptions');
        $this->displayField('id'); // make this more readable
        $this->primaryKey('id');
        $this->belongsTo('Members', [
            'foreignKey' => 'member_id',
            'joinType' => 'INNER'
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
            ->add('year1', 'valid', ['rule' => ['range',2004,2047]]);
        /*
            ->requirePresence('year1', 'create')
            ->notEmpty('year1');
          */  
        $validator
            ->add('batch', 'valid', ['rule' => ['range', 0, 100]]);
        /*
            ->requirePresence('batch', 'create')
            ->notEmpty('batch');
          */  
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['member_id'], 'Members'));
        return $rules;
    }
}
