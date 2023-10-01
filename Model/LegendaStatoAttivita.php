<?php
App::uses('AppModel', 'Model');
/**
 * LegendaStatoAttivita Model
 *
 */
class LegendaStatoAttivita extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $cacheQueries = true;

    public $hasMany = ['Faseattivita'];
}
