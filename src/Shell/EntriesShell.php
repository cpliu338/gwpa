<?php

namespace App\Shell;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

/**
 * Description of EntriesShell
 *
 * @author cp_liu
 */
class EntriesShell extends \Cake\Console\Shell {

	public function initialize() {
        $this->loadModel('Entries');
	}

	public function closeYear($year, $commit=0) {
    	$date1 = new Time("$year-04-01");
    	$nextyear = $year+1;
    	$date2 = new Time("$nextyear-04-01");
    	//$entry = $this->Entries->find()->order('incurred_on')->last();
    	$query = $this->Entries->find()->contain(['Accounts']);
		$entries = $query->select([
			'Entries.account_id',
			'Accounts.code', 'Accounts.name',
			'closing' => $query->func()->sum('amount'),
		])
		->where([
			'Entries.incurred_on >=' =>$date1,
			'Entries.incurred_on <' => $date2,
			'OR'=> [
				'Accounts.code LIKE' => '1%',
				'Accounts.code LIKE ' => '2%',
				'Accounts.code  LIKE' => '3%',
			]
			])
		->group('Accounts.code')
		->having(['closing <>' => 0])
		->order('Accounts.code');
    	$q2 = $this->Entries->find()->contain(['Accounts']);
		$earnings = $q2->select([
			'closing' => $q2->func()->sum('amount'),
		])
		->where([
			'Entries.incurred_on >=' =>$date1,
			'Entries.incurred_on <' => $date2,
			'OR'=> [
				'Accounts.code LIKE' => '4%',
				'Accounts.code LIKE ' => '5%',
			]
			])->first()->closing;
		if ($commit) {
			$table = $this->Entries;
			$nextRef = 1+$table->find()->order('ref DESC')->first()->ref;
			$opeining = [];
			foreach ($entries as $entry) {
				$e = $table->newEntity();
				$e->ref=$nextRef;
				$e->incurred_on = $date2;
				$e->account_id = $entry->account_id;
				$e->amount = $entry->closing;
				if ($entry->account->code == '31001')
					$e->amount = $e->amount+$earnings;
				$e->detail = 'Opening balance';
				$opening[] = $e;
			}
			/*
			$this->out(var_export($opening));
			*/
			$table->connection()->transactional(function() use ($table, $opening) {
				foreach ($opening as $e) {
					$table->save($e, ['atomic'=>false]);
				}
			});
			$this->out('committed');
		}
		else {
			foreach ($entries as $entry) {
				$this->out($entry->account->name);
				$this->out($entry->closing);
			}
		$this->out(var_export($earnings));
		}
	}
}