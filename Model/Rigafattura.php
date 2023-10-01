<?php
class Rigafattura extends AppModel {
	var $name = 'Rigafattura';
    var $order = 'Ordine';
	var $validate = [
		'fattura_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
		'Ordine' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'Ordine è un numero progessivo utile ad ordinare le righe della fattura',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
		'Importo' => [
			'numeric' => [
				'rule' => ['numeric'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
		'codiceiva_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
	];
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = [
		'Fatturaemessa' => [
			'className' => 'Fatturaemessa',
			'foreignKey' => 'fattura_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'Codiceiva' => [
			'className' => 'LegendaCodiciIva',
			'foreignKey' => 'codiceiva_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'Faseattivita' => [
			'className' => 'Faseattivita',
			'foreignKey' => 'faseattivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		], 
	];
}
