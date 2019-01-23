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
	public $belongsTo = array(
		'Attivita' => array(
			'className' => 'Attivita',
			'foreignKey' => 'attivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Fornitore' => array(
			'className' => 'Fornitore',
			'foreignKey' => 'fornitore_id',
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
		'Provenienzasoldi' => array(
			'className' => 'Provenienzasoldi',
			'foreignKey' => 'provenienza',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LegendaTipoDocumento' => array(
			'className' => 'LegendaTipoDocumento',
			'foreignKey' => 'legenda_tipo_documento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LegendaCatSpesa' => array(
			'className' => 'LegendaCatSpesa',
			'foreignKey' => 'legenda_cat_spesa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $virtualFields = array(
		'soddisfatta' => 'SELECT SUM(Primanota.Importo*-1) from primanota Primanota WHERE Primanota.fatturaricevuta_id = Fatturaricevuta.id' 

		);

}