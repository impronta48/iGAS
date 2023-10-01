<?php
App::uses('AppModel', 'Model');
/**
 * Faseattivita Model
 *
 * @property Attivita $Attivita
 * @property LegendaStatoAttivita $LegendaStatoAttivita
 */
class Faseattivita extends AppModel
{

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'Descrizione';
  //public $cacheQueries = true;
  var $actsAs = ['Containable'];

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
    'Persona' => [
      'className' => 'Persona',
      'foreignKey' => 'persona_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    ],
    'Cespite' => [
      'className' => 'Cespite',
      'foreignKey' => 'cespite_id',
      //'dependent' => false,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
    ],
    'LegendaStatoAttivita' => [
      'className' => 'LegendaStatoAttivita',
      'foreignKey' => 'legenda_stato_attivita_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    ],
    'LegendaCodiciIva' => [
      'className' => 'LegendaCodiciIva',
      'foreignKey' => 'legenda_codici_iva_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    ],
  ];

  public $hasMany = [
    'Rigaddt' => [
      'className' => 'Rigaddt',
      'foreignKey' => 'faseattivita_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    ],
    'Notaspesa',
    'Ora'

  ];

  public function beforeSave($options = [])
  {
    if (isset($this->data['Faseattivita']['cespite_id'])) {
      if ($this->data['Cespite']['DisplayName'] == '') {
        $this->data['Faseattivita']['cespite_id'] = null;
      }
    }

    Cache::clear('long');
    //debug($this->data);
    //die();
  }

  public function afterSave($created, $options = [])
  {
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

  public function beforeDelete($cascade = true)
  {
    Cache::clear('long');
    //debug($this->data);
    //die();
  }

  public function afterDelete()
  {
    //debug($this->data);
    //die();
    /*
        $this->Attivita->id = $this->data['Faseattivita']['attivita_id'];
		$nuovaOffertaAlCliente = $this->Attivita->read('Attivita.OffertaAlCliente')['Attivita']['OffertaAlCliente']-($this->data['Faseattivita']['vendutou']*$this->data['Faseattivita']['qta']);
		$this->Attivita->saveField('OffertaAlCliente', $nuovaOffertaAlCliente);
		*/
  }

  //returns a list wich is good for a combobox
  public function getSimple($attivita_id = null, $solo_entrata = 0, $solo_aperte = 0)
  {
    /*     if (Configure::read('debug') == 0) {
      $fa = Cache::read("faseattivita_2level_{$attivita_id}_{$solo_entrata}_{$solo_aperte}", 'long');
      if (!empty($fa)) {
        return $fa;
      }
    } */

    $this->recursive = -1;
    $conditions = [];
    $notset = ['0' => '-- Non definita --'];


    if (!is_null($attivita_id)) {
      $conditions['attivita_id'] = $attivita_id;
    }
    if ($solo_entrata >= 0) {
      $conditions['entrata'] = $solo_entrata;
    }
    if ($solo_aperte == 1) {
      $conditions['legenda_stato_attivita_id !='] = 2;
      //debug($conditions);
    }


    $fase = $this->find('all', [
      'fields' => ['id', 'Descrizione', 'entrata'],
      'conditions' => $conditions,
      'contain' => ['Attivita.name']
    ]);
    $fa = Hash::combine(
      $fase,
      '{n}.Faseattivita.id',
      ['%.100s', '{n}.Faseattivita.Descrizione', '{n}.Faseattivita.entrata'],
      '{n}.Attivita.name'
    );
    $fa = Hash::merge($notset, $fa);
    //Cache::write("faseattivita_2level_{$attivita_id}_{$solo_entrata}_{$solo_aperte}", $fa, 'long');
    return $fa;
  }
}
