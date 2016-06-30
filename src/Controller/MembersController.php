<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Members Controller
 *
 * @property \App\Model\Table\MembersTable $Members
 */
class MembersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->layout = 'bootstrap';
    }
    
    private function populate_choices() {
        $this->set('divisions',  
            $this->Members->find()->select(['division'])
            ->distinct(['division'])->order('division')
        );
        $this->set('ranks', 
            $this->Members->find()->select(['rank'])->distinct(['rank'])->order('rank')
        );
    }
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = ['limit'=>10];
        if (array_key_exists("name", $this->request->query)) {
            $filter = $this->request->query['name'];
        } else {
            $filter = "";
        }
        $members = $this->Members->find()->where([
            "CONCAT(name1,' ',name2) LIKE"=>"%$filter%"
        ]);
        /*
        if (array_key_exists("name", $this->request->query)) {
            $filter = $this->request->query['name'];
            $name1 = strstr($filter,' ',TRUE);
            $name2 = strstr($filter,' ');
            $members = $this->Members->find()->where([
                'name1'=> strtoupper($name1),
                'name2 LIKE'=> trim(strtoupper($name2)).'%'
            ]);
            $this->set('members', $this->paginate($members));
        }
        else {
            $filter = '';
            $members = $this->paginate($this->Members);
            $this->set('members', $members);
        }
         * 
         */
        $this->set('members', $this->paginate($members));
        $this->set(compact('filter'));
        // Add extra navigation
        unset($this->nav['Members']['index']);
        $this->nav['Members']['add'] = 'Add';
        $this->set('_serialize', ['members']);
    }

    /**
     * View method
     *
     * @param string|null $id Member id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => ['Subscriptions']
        ]);
        if ($this->request->is('post')) {
            $this->Members->touch($member);
        }
        $this->set('member', $member);
        $this->set('_serialize', ['member']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $member = $this->Members->newEntity();
        if ($this->request->is('post')) {
            $member = $this->Members->patchEntity($member, $this->request->data);
            if (!empty($m=$this->Members->save($member))) {
                $this->Flash->success(__('The member has been saved.') . ' id: ' . $m->id);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The member could not be saved. Please, try again.'));
            }
        }
        $this->populate_choices();
        $this->set(compact('member'));
        $this->set('streams', Configure::read('Streams'));
        $this->set('_serialize', ['member']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Member id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $member = $this->Members->patchEntity($member, $this->request->data);
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The member could not be saved. Please, try again.'));
            }
        }
        $this->populate_choices();
        $this->set(compact('member'));
        $this->set('_serialize', ['member']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Member id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $member = $this->Members->get($id);
        if ($this->Members->delete($member)) {
            $this->Flash->success(__('The member has been deleted.'));
        } else {
            $this->Flash->error(__('The member could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
