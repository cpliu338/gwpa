<?php

namespace App\Shell;
use Cake\I18n\Time;

/**
 * Description of SubscriptionsShell
 *
 * @author cp_liu
 */
class SubscriptionsShell extends \Cake\Console\Shell {
	
	public function initialize() {
        $this->loadModel('Subscriptions');
	}

    public function maillist($yr = 0) {
        if ($yr == 0) {
        	$yr = (new Time())->year-1;
        }
        $query = $this->Subscriptions->find()->contain(['Members'])->where([
        	'Subscriptions.year1'=>$yr,
        	'Members.email NOT LIKE' => '%unknown'
		])->order('Members.email');
        foreach ($query as $subscription) {
        	$this->out(
        		$subscription->member->email);
        }
    }

    public function quitted($yr = 0) {
        if ($yr == 0) {
        	$yr = (new Time())->year-1;
        }
		$member_ids = $this->Subscriptions->find()->where([
			'year1'=>$yr])->combine('id','member_id');
        $query = $this->Subscriptions->find()->contain(['Members'])->where([
        	'Subscriptions.year1'=>$yr-1,
        	'Members.email NOT LIKE' => '%unknown',
        	'Members.id NOT IN'=>$member_ids->toArray()
		])->order('Members.division, Members.name1, Members.name2');
		$div = 'xyz'; // impossible
        foreach ($query as $subscription) {
        	if ($subscription->member->division != $div) {
        		$div = $subscription->member->division;
        		$this->out($subscription->member->division);
        	}
        	$this->out(sprintf('%s %s: %s', $subscription->member->name1,
        		$subscription->member->name2, $subscription->member->email));
        }
    }

}