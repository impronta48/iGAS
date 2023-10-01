<?php
App::uses('AppModel', 'Model');
/**
 * LegendaTipiImpiegati Model
 *
 * @property Impiegato $Impiegato
 */
class LegendaTipoImpiegato extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'legenda_tipi_impiegati';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'TipoImpiegato';

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Impiegato' => [
			'className' => 'Impiegato',
			'foreignKey' => 'legendaTipoImpiegato_id',
			'dependent' => false,
		]
	];

}
