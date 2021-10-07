<?php
class Rigafattura extends AppModel {
	var $name = 'Rigafattura';
    var $order = 'Ordine';
	var $validate = array(
		'fattura_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'Ordine' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Ordine è un numero progessivo utile ad ordinare le righe della fattura',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'Importo' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'codiceiva_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Fatturaemessa' => array(
			'className' => 'Fatturaemessa',
			'foreignKey' => 'fattura_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Codiceiva' => array(
			'className' => 'LegendaCodiciIva',
			'foreignKey' => 'codiceiva_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Faseattivita' => array(
			'className' => 'Faseattivita',
			'foreignKey' => 'faseattivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		), 
	);
}
