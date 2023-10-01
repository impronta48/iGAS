<?php
App::uses('AppModel', 'Model');
/**
 * LegendaTipoAttivitaCalendario Model
 *
 * @property Fatturaricevuta $Fatturaricevuta
 */
class LegendaTipoAttivitaCalendario extends AppModel {

	var $validate = [
        'title' => [
            'rule' => 'notEmpty',
            'required' => true
        ]
    ];

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	public $cacheQueries = true;


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Cespite' => [
			'className' => 'Cespite',
			'foreignKey' => 'id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		]
	];

}
