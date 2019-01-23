<?php
class Progetto extends AppModel {
	var $name = 'Progetto';
	var $displayField = 'name';
	public $cacheQueries = true;

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Attivita' => array(
			'className' => 'Attivita',
			'foreignKey' => 'progetto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
    
    var $belongsTo = 'Area';

}
?>