<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Subscriptions Controller
 *
 * @property \App\Model\Table\SubscriptionsTable $Subscriptions
 */
class SubscriptionsController extends AppController
{
    use SearchConditionsTrait;

    public function initialize()
    {
    	parent::initialize();
        $this->layout = 'bootstrap';
    }
    
    private function enrol($item) {
            return $item->year1;
        }

    public function report($year=0) {
        $this->layout = 'jq_mobile';
        $years=array_map(function($item) {return $item->year1;}, $this->Subscriptions->find()->select(['year1'])->distinct(['year1'])->order(['year1'])->toArray());
        if (empty($year) || !preg_match('/^20[0-2][0-9]$/', $year)) {
            $this->redirect (['action'=>'report',$this->defaultYear]);
            return;
        }
        $this->set('year', $year);
        $this->set('subscriptions', $this->Subscriptions->find()->contain(['Members'])
                ->where(['year1'=> $year])->order('Members.id'));
        $this->set('_serialize', ['subscriptions']);
        
    }
    /**
     * Index method
     *
     * @return void
     */
    public function index($year=0)
    {
        $years=array_map(function($item) {return $item->year1;}, $this->Subscriptions->find()->select(['year1'])->distinct(['year1'])->order(['year1'])->toArray());
        if (empty($year) || !preg_match('/^20[0-2][0-9]$/', $year)) {
            $this->redirect (['action'=>'index',$this->defaultYear]);
            return;
        }
        /*
        if (!empty($div)) {
            $this->add($year, $div);
            $this->layout = 'bootstrap';
            $this->render('add');
            return;
        }
        */
        $this->paginate = [
            'conditions' => ['year1'=> $year],
            'contain' => ['Members'],
            'limit' => 10,
            'sortWhitelist' => ['Members.division','Members.name1','Members.name2','batch']
        ];
        $this->set(compact('year', 'years'));
        $this->set('subscriptions', $this->paginate($this->Subscriptions));
        // Add extra navigation
        unset($this->nav['Subscriptions']['index']);
        $this->nav['Subscriptions']['add'] = 'Add';
        $this->set('_serialize', ['subscriptions']);
    }

    /**
     * View method
     *
     * @param string|null $id Subscription id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subscription = $this->Subscriptions->get($id, [
            'contain' => ['Members']
        ]);
        $this->set('subscription', $subscription);
        $this->set('_serialize', ['subscription']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if (empty($this->request->query('year'))) {
            $year = Time::today()->year;
        }
        else {
            $year = $this->request->query('year');
        }
        $div = $this->request->query('div');
        $this->loadModel('Members');
        $divisions = $this->Members->find()->select(['division'])->distinct(['division']);
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            $ids = explode(',',$this->request->data('ids'));
            $sub_table = $this->Subscriptions;
            try {
            	$n = 0;
            	$sub_table->connection()->transactional(function () use ($sub_table, $ids, $data,&$n) {
					foreach ($ids as $id) {
						if ($id) { // trailing , in ids query parameter causes an empty element at the end
							$subscription = $this->Subscriptions->newEntity();
							$subscription = $this->Subscriptions->patchEntity($subscription, $data);
							$subscription->member_id = $id;
							$sub_table->save($subscription, ['atomic' => false]);
							$n= $n+1;
						}
					}
				});
				$this->Flash->success("$n " . __('subscriptions have been saved.'));
				return $this->redirect(['action' => 'index', $this->request->data('year1')]);
            }
            catch (Exception $e) {
                $this->Flash->error(__('The subscription could not be saved. Please, try again.') . $e->getMessage());
                return;
            }
        }
        $subscriptions = $this->Subscriptions->find()->contain('Members')->where([
            'Subscriptions.year1'=>$year,'Members.division'=>$div
        ]);
        $subscribed = array_map(function($sub) {
            return $sub->member->id;
        }, $subscriptions->toArray());
        $all_members = $this->Members->find('list')->where(['division'=>$div])->toArray();
        $members = $this->Members->find()->where(['id IN'=>array_diff(array_keys($all_members), $subscribed)])->order('name1, name2');
        $query = $this->Subscriptions->find();
        $batch = $query->select(['batch'=>$query->func()->max('batch')])->where(['year1'=>$year])->first();
        $maxbatch = $batch->batch;
        $this->set(compact('subscriptions', 'divisions', 'members', 'year', 'div', 'maxbatch'));
    }
    
    /**
     * Edit method
     *
     * @param string|null $id Subscription id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subscription = $this->Subscriptions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->data);
            if ($this->Subscriptions->save($subscription)) {
                $this->Flash->success(__('The subscription has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
            }
        }
        $members = $this->Subscriptions->Members->find()
            ->where(['id >' => 1, 'email NOT LIKE'=>'%unknown'])->limit(600)
            ->order(['name2' => 'ASC'])
            ->map(function ($row) { // map() is a collection method, it executes the query
                $row->fullName = sprintf("%s, %s", $row->name2, $row->name1);
                return $row;
            })
            ->combine('id', 'fullName'); // combine() is another collection method
        $this->set(compact('subscription', 'members'));
        $this->set('_serialize', ['subscription']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscription id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscription = $this->Subscriptions->get($id);
        if ($this->Subscriptions->delete($subscription)) {
            $this->Flash->success(__('The subscription has been deleted.'));
        } else {
            $this->Flash->error(__('The subscription could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function memberlist($yr) {
        $query = $this->Subscriptions->find()->contain(['Members']);
        $subscriptions = $query->where( 
            ['year1' => $yr, 'Members.division'=>$this->request->query['div']])
            ->order(['name1','name2'])
            ->limit(100);
        $members=$this->Subscriptions->find()->contain(['Members'])->select(['Members.division'])->
                distinct(['division'])->
                order(['Members.division']);
        $division = $this->request->query['div'];
        $this->set(compact('subscriptions', 'members','yr','division'));
    }
}
