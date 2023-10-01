<?php
App::uses('AppModel', 'Model');
/**
 * Fatturericevute Model
 *
 * @property Attivita $Attivita
 * @property Fornitore $Fornitore
 * @property Faseattivita $faseattivita
 */
class Fatturaricevuta extends AppModel {
	
    public $order = 'Fatturaricevuta.id desc';

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
		'Fornitore' => [
			'className' => 'Fornitore',
			'foreignKey' => 'fornitore_id',
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
		'Provenienzasoldi' => [
			'className' => 'Provenienzasoldi',
			'foreignKey' => 'provenienza',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'LegendaTipoDocumento' => [
			'className' => 'LegendaTipoDocumento',
			'foreignKey' => 'legenda_tipo_documento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'LegendaCatSpesa' => [
			'className' => 'LegendaCatSpesa',
			'foreignKey' => 'legenda_cat_spesa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		]
	];

	public $virtualFields = [
		'soddisfatta' => 'SELECT SUM(Primanota.Importo*-1) from primanota Primanota WHERE Primanota.fatturaricevuta_id = Fatturaricevuta.id' 

		];

}