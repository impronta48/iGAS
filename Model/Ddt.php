<?php
App::uses('AppModel', 'Model');
/**
 * Ddt Model
 *
 * @property Attivita $Attivita
 * @property LegendaCausaleTrasporto $LegendaCausaleTrasporto
 * @property LegendaPorto $LegendaPorto
 * @property Vettore $Vettore
 */
class Ddt extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = [
		'Attivita' => [
			'className' => 'Attivita',
			'foreignKey' => 'attivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'LegendaCausaleTrasporto' => [
			'className' => 'LegendaCausaleTrasporto',
			'foreignKey' => 'legenda_causale_trasporto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'LegendaPorto' => [
			'className' => 'LegendaPorto',
			'foreignKey' => 'legenda_porto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'Vettore' => [
			'className' => 'Vettore',
			'foreignKey' => 'vettore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		]
	];
    
    public $hasMany = [
		'Rigaddt' => [
			'className' => 'Rigaddt',
			'foreignKey' => 'ddt_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
	];
}
