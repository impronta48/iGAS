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
            //'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
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
		if(isset($this->data['Faseattivita']['cespite_id'])){
            if($this->data['Cespite']['DisplayName'] == ''){
                $this->data['Faseattivita']['cespite_id'] = null;
            }
		}
		Cache::delete('faseattivita_2level');
		//debug($this->data);
		//die();
	}
    
	public function afterSave($created, $options = Array()) {
		/*
		if($created) {
            //debug($this->data['Faseattivita']);
			//die();
			$venduto = ($this->data['Faseattivita']['vendutou'] == '') ? 0: $this->data['Faseattivita']['vendutou'];
			$qta = ($this->data['Faseattivita']['qta'] == '') ? 0 : $this->data['Faseattivita']['qta'];
            $this->Attivita->id = $this->data['Faseattivita']['attivita_id'];
            $nuovaOffertaAlCliente = $this->Attivita->read('Attivita.OffertaAlCliente')['Attivita']['OffertaAlCliente']+($venduto*$qta);
            $this->Attivita->saveField('OffertaAlCliente', $nuovaOffertaAlCliente); 
		} else {
			if(!isset($this->data['Faseattivita']['qtaUtilizzata'])){
				$venduto = ($this->data['Faseattivita']['vendutou'] == '') ? $this->data['Faseattivita']['vendutou'] : 0;
				$qta = ($this->data['Faseattivita']['qta'] == '') ? $this->data['Faseattivita']['qta'] : 0;
				$this->Attivita->id = $this->data['Faseattivita']['attivita_id'];
				$nuovaOffertaAlCliente = $this->Attivita->read('Attivita.OffertaAlCliente')['Attivita']['OffertaAlCliente']-($this->data['Faseattivita']['old_venduto']*$this->data['Faseattivita']['old_qta']);
				$nuovaOffertaAlCliente += ($venduto*$qta);
				$this->Attivita->saveField('OffertaAlCliente', $nuovaOffertaAlCliente); 
			}
		}
		*/
	}
    
    public function beforeDelete($cascade = true) {
        //debug($this->data);
        //die();
    }
    
    public function afterDelete() {
        //debug($this->data);
		//die();
		/*
        $this->Attivita->id = $this->data['Faseattivita']['attivita_id'];
		$nuovaOffertaAlCliente = $this->Attivita->read('Attivita.OffertaAlCliente')['Attivita']['OffertaAlCliente']-($this->data['Faseattivita']['vendutou']*$this->data['Faseattivita']['qta']);
		$this->Attivita->saveField('OffertaAlCliente', $nuovaOffertaAlCliente);
		*/
    }

	//returns a list wich is good for a combobox
	public function getSimple($attivita_id = null, $solo_entrata = 0,$solo_aperte=0)
	{
		if (Configure::read('debug')==0)
        {
			$fa = Cache::read("faseattivita_2level_{$attivita_id}_{$solo_entrata}_{$solo_aperte}", 'long');
			return $fa;
        }
		
		$this->recursive = -1;
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
		if ($solo_aperte ==1)
		{			
			$conditions['legenda_stato_attivita_id !='] =2;
			//debug($conditions);
		}


		$fase =$this->find('all', [
				'fields'=> ['id','Descrizione','entrata'],
				'conditions' => $conditions,
				'contain' => ['Attivita.name']
				]);
        $fa = Hash::combine($fase, 
                            '{n}.Faseattivita.id', 
                            array('%.100s','{n}.Faseattivita.Descrizione', '{n}.Faseattivita.entrata'),                            
                            '{n}.Attivita.name'
                           );
		$fa = Hash::merge($notset, $fa);
		Cache::write('faseattivita_2level', $fa, 'long');
        return $fa;
	}
	
}
