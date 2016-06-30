<?php
namespace App\Controller;

use App\Controller\AppController;
// use SearchConditionsTrait;
use Cake\I18n\Time;

/**
 * Entries Controller
 *
 * @property \App\Model\Table\EntriesTable $Entries
 */
class EntriesController extends AppController
{
    use SearchConditionsTrait;
    
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'bootstrap';
        $this->set('period', $this->getConditions());
    }
    
    private function _getAccountList($crit=null) {
        $this->loadModel('Accounts');
        $query = $this->Accounts->find();
        if ($crit) {
            $query = $query->where($crit);
        }
        $acc = $query->order(['code' => 'ASC'])
            ->map(function ($row) { // map() is a collection method, it executes the query
                $row->desc = $row->code .':'.$row->name;
                return $row;
            })
            ->combine('id', 'desc')
            ->toArray();
        return $acc;
    }

    public function transact($ref=0) {
        $this->set('ref', $ref);
        $acc = $this->_getAccountList();
        $this->set('accounts', $acc); //array_values($acc));
        $json = array();
        $incurred_on = Time::now();
        foreach ($this->Entries->find()->where(['ref'=>$ref]) as $entity) {
            $incurred_on = $entity->incurred_on;
            $entity->account = $acc[$entity->account_id];
            $json[]=$entity->jsonSerialize();
        }
        $this->set('json', json_encode($json));
        $this->set('incurred_on', $incurred_on);
        if (!$this->request->is('get')) {
            $objects = json_decode($this->request->data['objects']);
            $ref = (preg_match('/[1-9][0-9]*/', $this->request->data['ref']) ? $this->request->data['ref']:0);
            $entries = $this->Entries;
            $this->loadModel('Accounts');
            /*
            $ref 0 to become last ref to be implemented here instead of EntriesTable.php
             * so that redirect upon success gets the correct $ref
            return;
             */
            $entities = $entries->fromPostData($objects, $ref, $this->request->data['incurred_on'],
                    array_flip($this->Accounts->find()->combine('id','code')->toArray()));
            foreach ($entities as $entity) {
                $date1 = Time::parse($entity->incurred_on);
                $entity->incurred_on = $date1;
            }
            /*
            */
            $success = true;
            try {
            $entries->connection()->transactional(function () use ($entries, $entities, $success) {
                foreach ($entities as $entity) {
                    if (abs($entity->amount) < 0.01) {
                            $success = $entries->delete($entity, ['atomic' => false]);
                        } else {
                            $success = $entries->save($entity, ['atomic' => false]);
                        }
                        if (!$success) {
                            throw new \Exception('error on data save.');
                    }
                }
            });
            $this->Flash->success('The entries have been saved.');
            }
            catch (\Exception $e) {
            	$this->Flash->error("Caught ".$e->getMessage());
            }
            return $this->redirect(['action' => 'transact', $ref]);
        }
    }
    
    /**
     * Index method
     * Query has a 'since' param to be used in SearchConditionsTrait
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'order' => [
                'Entries.incurred_on' => 'asc',
                'Entries.ref' => 'asc',
                'Entries.account_id' => 'asc'
            ],
            'limit' => 15,
            'contain' => ['Accounts']
        ];
        $this->layout = 'bootstrap';
        if ($this->request->is('json')) {
            $this->set('entries', $this->Entries->find()->limit(2));
        }
        else {
            $this->set('entries', $this->paginate($this->Entries->find()->where($this->getConditions())));
        }
        // Add extra navigation
        unset($this->nav['Entries']['index']);
        $this->nav['Entries']['transact'] = 'Add';
        $this->set('_serialize', ['entries']);
    }

    /**
     * View method
     *
     * @param string|null $id Entry id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $entry = $this->Entries->get($id, [
            'contain' => ['Accounts']
        ]);
        $this->set('entry', $entry);
        $this->set('_serialize', ['entry']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $entry = $this->Entries->newEntity();
        if ($this->request->is('post')) {
            $entry = $this->Entries->patchEntity($entry, $this->request->data);
            if ($this->Entries->save($entry)) {
                $this->Flash->success(__('The entry has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The entry could not be saved. Please, try again.'));
            }
        }
        $accounts = $this->Entries->Accounts->find('list', ['limit' => 200]);
        $this->set(compact('entry', 'accounts'));
        $this->set('_serialize', ['entry']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Entry id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $entry = $this->Entries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $entry = $this->Entries->patchEntity($entry, $this->request->data);
            if ($this->Entries->save($entry)) {
                $this->Flash->success(__('The entry has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The entry could not be saved. Please, try again.'));
            }
        }
        $accounts = $this->Entries->Accounts->find('list', ['limit' => 200]);
        $related = $this->Entries->find()->where([
            	'ref'=>$entry->ref
            	]);
        $this->set(compact('entry', 'accounts'));
        $this->set('related_entries', json_encode($related->toArray()));
        $this->set('_serialize', ['entry']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Entry id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $entry = $this->Entries->get($id);
        if ($this->Entries->delete($entry)) {
            $this->Flash->success(__('The entry has been deleted.'));
        } else {
            $this->Flash->error(__('The entry could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function raw()
    {
        $this->layout = 'ajax';
		$this->set('entries', $this->Entries->find()->where($this->getConditions())
			->contain('Accounts')
			->order([
                'Entries.incurred_on' => 'asc',
                'Entries.ref' => 'asc',
                'Entries.account_id' => 'asc'
            ]
			));
		$this->render('list');
    }

    public function report()
    {
        $this->layout = 'ajax';
        $currentyr = $this->getConditions(); // may be modified by param['since']
        $this->set('year_end', array_values($currentyr)[1]);
        $lastyr = [];
        foreach ($currentyr as $key=>$v) {
            $limit = clone $v;
            $lastyr[$key] = $limit->year($limit->year-1);
        }
        $query = $this->Entries->find()->contain(['Accounts']);
        $results = [];
        // Order done in view because not all codes appear in the same year, odd codes appended at the end
        foreach ($query->select(['Accounts.name','Accounts.code',
            'total'=>$query->func()->sum('Entries.amount')])
            ->where($currentyr)
            ->group('account_id') as $acc) {
            $results[$acc->account->code]['name'] = $acc->account->name;
            $results[$acc->account->code]['current'] = $acc->total;
        }
        $query2 = $this->Entries->find()->contain(['Accounts']);
        foreach ($query2->select(['Accounts.name','Accounts.code',
            'total'=>$query2->func()->sum('Entries.amount')])
            ->where($lastyr)
            ->group('account_id') as $acc) {
            $results[$acc->account->code]['name'] = $acc->account->name;
            $results[$acc->account->code]['last'] = $acc->total;
        }
        $this->set('results', $results);
    }

}
