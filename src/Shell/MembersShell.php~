<?php

namespace App\Shell;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

/**
 * Description of MembersShell
 *
 * @author cp_liu
 */
class MembersShell extends \Cake\Console\Shell {

	var $connection;
	var $qry1;
	var $subqry;
	var $subqry2;
	var $qry3;
	
	public function initialize() {
        $this->connection = ConnectionManager::get('default');
        $this->subqry = "where subscriptions.year1=%d";
        $this->subqry2 = " and members.id NOT IN (select member_id from subscriptions where year1=%s)";
        $this->qry1 = "select count(subscriptions.id) as num, members.sex from subscriptions inner join members on subscriptions.member_id=members.id";
        $this->qry3 = "group by members.sex";
	}
	
	/**
	Form 10:LD Form RTU 13(s) Annual Return of Membership
	*/
    public function form10($yr = 0) {
        if ($yr == 0) {
        	$yr = (new Time())->year-1;
        }
        $query = sprintf("%s %s %s", $this->qry1, sprintf($this->subqry, $yr-1), $this->qry3);
        $this->log($query, 'debug');
        $results = $this->connection->execute($query)->fetchAll('assoc');
        $this->log(sprintf("Members in the beginning of %d", $yr), "info");
        foreach ($results as $result) {
        	$this->log(sprintf("%d %s", $result['num'],$result['sex']), "info");
        }
        $query = sprintf("%s %s %s", $this->qry1, sprintf($this->subqry . $this->subqry2, $yr, $yr-1), $this->qry3);
        $results = $this->connection->execute($query)->fetchAll('assoc');
        $this->log(sprintf("Members joined in %d", $yr), "info");
        foreach ($results as $result) {
        	$this->log(sprintf("%d %s", $result['num'],$result['sex']), "info");
        }
        $query = sprintf("%s %s %s", $this->qry1, sprintf($this->subqry . $this->subqry2, $yr-1, $yr), $this->qry3);
        $results = $this->connection->execute($query)->fetchAll('assoc');
        $this->log(sprintf("Members left in %d", $yr), "info");
        foreach ($results as $result) {
        	$this->log(sprintf("%d %s", $result['num'],$result['sex']), "info");
        }
        $query = sprintf("%s %s %s", $this->qry1, sprintf($this->subqry, $yr), $this->qry3);
        $results = $this->connection->execute($query)->fetchAll('assoc');
        $this->log(sprintf("Members in the end of %d", $yr), "info");
        foreach ($results as $result) {
        	$this->log(sprintf("%d %s", $result['num'],$result['sex']), "info");
        }
    }
}
