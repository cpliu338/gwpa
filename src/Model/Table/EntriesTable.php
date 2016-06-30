<?php
namespace App\Model\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Description of EntriesTable
 *
 * @author cp_liu
 */
class EntriesTable extends \Cake\ORM\Table {
    
    /**
     * Convert a JSON array of entries into a PHP array of entries
     * @param $accounts list of accounts as ['code'=>'id'] for account id lookup
     */
    public function fromPostData($requestdata, $ref, $incurred_on, $accounts) {
        $results = array();
        foreach ($this->find()->where(['ref'=>$ref]) as $entity) {
            // check $incurred_on is valid
            $entity->incurred_on = $incurred_on;
            $entity->amount = 0.0;
            $results[$entity->id] = $entity;
        }
        // create next $ref if needed
        if ($ref == 0) {
            $q = $this->find();
            $lastref = $q->select(['lastref'=>$q->func()->max('ref')])->toArray();
            $ref = $lastref[0]['lastref']+1;
        }
        if (count($requestdata)>0) {
            foreach ($requestdata as $item) {
                $item->ref = $ref;
                if (property_exists($item, 'id') && array_key_exists($item->id, $results)) {
                    $o = $results[$item->id];
                }
                else {
                    $o = $this->newEntity();
                    // $o->id = $item->id;
                    $o->incurred_on = $incurred_on;
                    $o->ref = $ref;
                    array_push($results, $o);
                }
                $acc_str = $item->account;
                $code = substr($acc_str, 0, strpos($acc_str, ':'));
                $o->account_id = (array_key_exists($code, $accounts)) ? $accounts[$code] : 0;
                $o->amount = $item->amount;
                $o->detail = $item->detail;
            }
        }
        return $results;
    }
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('entries');
        $this->displayField('detail');
        $this->primaryKey('id');
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
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
            ->add('ref', 'valid', ['rule' => ['range',1,10000000000]]);

        $validator
            ->requirePresence('detail', 'create')
            ->notEmpty('detail');

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
        $rules->add($rules->existsIn(['account_id'], 'Accounts'));
        return $rules;
    }
}