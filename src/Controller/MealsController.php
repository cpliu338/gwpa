<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\I18n\Time;
/**
 * Members Controller
 *
 * @property \App\Model\Table\MembersTable $Members
 */
class MealsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->layout = 'jq_mobile';
    }
    
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('members', Configure::read('Duty.people'));
        if($this->request->is('get')) {
            $this->set('debug', 'get');
        }
        else if ($this->request->is('put')) {
            $this->set('debug',"put");
        }
        else if ($this->request->is('post')) {
            $this->set('debug',"POST");
        }
        else if ($this->request->is('ajax')) {
            $this->set('debug',"ajax");
        }
    }
    
    public function add() {
        $dt = Time::parse($this->request->query['dt']);
        $this->set('dt', $dt);
        debug($dt);
        debug([\IntlDateFormatter::FULL, \IntlDateFormatter::SHORT]);
    }

}
