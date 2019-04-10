<?php
App::uses('AppModel', 'Model');
/**
 * Faseattivita Model
 *
 * @property Attivita $Attivita
 * @property LegendaStatoAttivita $LegendaStatoAttivita
 */
class Faseattivita extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'Descrizione';
    public $cacheQueries = true;
	
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
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    	'LegendaStatoAttivita' => array(
			'className' => 'LegendaStatoAttivita',
			'foreignKey' => 'legenda_stato_attivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    	'LegendaCodiciIva' => array(
			'className' => 'LegendaCodiciIva',
			'foreignKey' => 'legenda_codici_iva_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    );
    
    public $hasMany = array(
		'Rigaddt' => array(
			'className' => 'Rigaddt',
			'foreignKey' => 'faseattivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Notaspesa',
		'Ora'

    );
	
	//returns a list wich is good for a combobox
	public function getSimple($attivita_id = null, $solo_entrata = 0)
	{
		$conditions = array();
		$notset = array('0'=> '-- Non definita --');   
		
		
		if (!is_null($attivita_id))
		{			
			$conditions['attivita_id'] =$attivita_id;
		}		
		if ($solo_entrata >= 0 )
		{			
			$conditions['entrata'] =$solo_entrata;
		}		

		$fase =$this->find('all', array('conditions' => $conditions));
        $fa = Hash::combine($fase, 
                            '{n}.Faseattivita.id', 
                            array('%.40s','{n}.Faseattivita.Descrizione', '{n}.Faseattivita.entrata'),                            
                            '{n}.Attivita.name'
                           );
        $fa = Hash::merge($notset, $fa);
        return $fa;
	}
	
}
