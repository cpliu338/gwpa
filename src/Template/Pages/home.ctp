<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->assign('title', 'Main Page');
$cakeDescription = 'Main Page';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/le-frog/jquery-ui.css"/>
    <?= $this->Html->css('gwpa.css') ?>
</head>
<body>
<div class="container">
    <div class="row">
    	<div class="col-md-3 panel panel-default">
	    	<div class="panel-heading">
    		<?= $this->Html->link("Accounts", ['controller'=>'Accounts', 'action' => 'index'], ['class'=>'btn btn-link'])?>
			</div>
			<div class="panel-body">
			<pre>
CREATE TABLE accounts (
  id int(11),
  name varchar(255),
  code varchar(255),
  remark varchar(255),
  created_at datetime,
  updated_at datetime,
  PRIMARY KEY (id)
)
			</pre>
			</div>
    	</div>
    	<div class="col-md-3 panel panel-default">
	    	<div class="panel-heading">
    		<?= $this->Html->link("Entries", ['controller'=>'Entries', 'action' => 'index'], ['class'=>'btn btn-link'])?>
			</div>
			<div class="panel-body">
			<pre>
CREATE TABLE entries (
  id int(11),
  ref int(11),
  incurred_on date,
  account_id int(11),
  amount decimal(10,2),
  detail varchar(255),
  created_at datetime,
  updated_at datetime,
  PRIMARY KEY (id),
  KEY (account_id)
)
			</pre>
			</div>
    	</div>
    	<div class="col-md-3 panel panel-default">
	    	<div class="panel-heading">
    		<?= $this->Html->link("Subscriptions", ['controller'=>'Subscriptions', 'action' => 'index'], ['class'=>'btn btn-link'])?>
			</div>
			<div class="panel-body">
			<pre>
CREATE TABLE subscriptions (
  id int(11),
  member_id int(11),
  year1 int(11),
  batch smallint(6),
  created_at datetime,
  updated_at datetime,
  PRIMARY KEY (id),
  KEY (member_id)
) 
			</pre>
			</div>
		</div>
    	<div class="col-md-3 panel panel-default">
	    	<div class="panel-heading">
    		<?= $this->Html->link("Members", ['controller'=>'Members', 'action' => 'index'], ['class'=>'btn btn-link'])?>
			</div>
			<div class="panel-body">
			<pre>
CREATE TABLE members (
  id int(11),
  name1 varchar(255),
  name2 varchar(255),
  sex varchar(1),
  stream varchar(8),
  rank varchar(32),
  division varchar(16),
  post varchar(255),
  email varchar(64),
  created_at datetime,
  updated_at datetime,
  PRIMARY KEY (id)
)
		</pre>
		</div>
    </div>
</div>
	<div class="row">

        <p>See MemberShell, EntriesShell for admin functions run on CakePHP shell</p>
        <p>Entries/report is for making reports</p>
    </div>
</body>
</html>
