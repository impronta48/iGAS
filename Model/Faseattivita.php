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
		var $actsAs = array('Containable');
	
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
		'Cespite' => array(
            'className' => 'Cespite',
            'foreignKey' => 'cespite_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
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
	
    public function beforeSave($options = Array()) {
            //debug($this->data['Faseattivita']);
            //die();
	}
    
	public function afterSave($created, $options = Array()) {
		//debug($this->data['Faseattivita']['qtaUtilizzata']);
    	//die();
		if($created) {
            //debug($this->data['Faseattivita']);
			//die();
			$venduto = ($this->data['Faseattivita']['vendutou'] == '') ? 0: $this->data['Faseattivita']['vendutou'];
			$qta = ($this->data['Faseattivita']['qta'] == '') ? 0 : $this->data['Faseattivita']['qta'];
            $this->Attivita->id = $this->data['Faseattivita']['attivita_id'];
            $nuovaOffertaAlCliente = $this->Attivita->read('Attivita.OffertaAlCliente')['Attivita']['OffertaAlCliente']+($venduto*$qta);
            $this->Attivita->saveField('OffertaAlCliente', $nuovaOffertaAlCliente); 
		} else {
			//Se in questo momento è settato $this->data['Faseattivita']['qtaUtilizzata']
			//vuol dire che sicuramente non sto modificando direttamente la Faseattivita tramite il suo form
			//e quindi non devo aggiornare Attivita.OffertaAlCliente perchè non è sicuramente
			//stata modificato nè il venduto ne la quantità ma al max solo la qtaUtilizzata
			if(!isset($this->data['Faseattivita']['qtaUtilizzata'])){
				$venduto = ($this->data['Faseattivita']['vendutou'] == '') ? $this->data['Faseattivita']['vendutou'] : 0;
				$qta = ($this->data['Faseattivita']['qta'] == '') ? $this->data['Faseattivita']['qta'] : 0;
				$this->Attivita->id = $this->data['Faseattivita']['attivita_id'];
				$nuovaOffertaAlCliente = $this->Attivita->read('Attivita.OffertaAlCliente')['Attivita']['OffertaAlCliente']-($this->data['Faseattivita']['old_venduto']*$this->data['Faseattivita']['old_qta']);
				$nuovaOffertaAlCliente += ($venduto*$qta);
				$this->Attivita->saveField('OffertaAlCliente', $nuovaOffertaAlCliente); 
			}
        }
	}
    
    public function beforeDelete($cascade = true) {
        //debug($this->data);
        //die();
    }
    
    public function afterDelete() {
        //debug($this->data);
        //die();
        $this->Attivita->id = $this->data['Faseattivita']['attivita_id'];
		$nuovaOffertaAlCliente = $this->Attivita->read('Attivita.OffertaAlCliente')['Attivita']['OffertaAlCliente']-($this->data['Faseattivita']['vendutou']*$this->data['Faseattivita']['qta']);
        $this->Attivita->saveField('OffertaAlCliente', $nuovaOffertaAlCliente);
    }

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
