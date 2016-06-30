<?php 
use Cake\Utility\Inflector;
	foreach ($nav as $c=>$array_of_actions) {
		foreach ($array_of_actions as $a=>$verb) {
			if ($a=='index')
				$entity = $c;
			else
				$entity = Inflector::singularize($c);
			echo $this->Html->link("$verb $entity", ['controller'=>$c, 'action' => $a], ['class'=>'btn btn-link']);
		}
	}
	