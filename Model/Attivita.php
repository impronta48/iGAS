<?php
class Attivita extends AppModel {
	var $name = 'Attivita';
	var $displayField = 'name';
  //var $order= 'Attivita.id DESC';
  var $order= 'Attivita.name';
  var $actsAs = array('Containable');
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(		
        'Fatturaemessa',
        'Notaspesa' => array(
			'className' => 'Notaspesa',
			'foreignKey' => 'eAttivita',
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
        'Alias' => array(
			'className' => 'Alias',
			'foreignKey' => 'attivita_id',
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
        'Faseattivita' => array(
			'className' => 'Faseattivita',
			'foreignKey' => 'attivita_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'Ora' => array(
			'className' => 'Ora',
			'foreignKey' => 'eAttivita',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Primanota',
		'Fatturaricevuta' 
	);

	var $belongsTo = array('Progetto','Area',
        'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'cliente_id',
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
      );     
     
      //Questa funzione svuota la data se è nulla, per evitare che diventi 0000-00-00
      function beforeSave($options = array()) {
          parent::beforeSave($options);

          $k = array_keys($this->data['Attivita']);
          foreach ($k as $f)
          {
              if ($this->data['Attivita'][$f]==0 && $this->_schema[$f]['type']=='date')
              {
                  $this->data['Attivita'][$f]=NULL;
              }
          }

          return true;
      }
      
      //Calcola il totale di ore usate da un'attività
      function oreUsate($id) {
            $r = $this->Ora->find('all', array(
                'conditions' => array('Ora.eAttivita' => $id),
                'fields' => array('SUM(Ora.numOre) as S'),
                'group' => array('Ora.eAttivita'),
            ));
            if (isset($r[0][0]['S']))
            {
                return $r[0][0]['S'];
            }
            else
            {
                return 0;
            }
      }
      
      //Calcola il totale di ore da pagare in un'attivita
      function oreDaPagare($id) {
            $r = $this->Ora->find('all', array(
                'conditions' => array('Ora.eAttivita' => $id,  'Ora.pagato !=' => 1),
                'fields' => array('SUM(Ora.numOre) as S'),
                'group' => array('Ora.eAttivita'),
            ));
            if (isset($r[0][0]['S']))
            {
                return $r[0][0]['S'];
            }
            else
            {
                return 0;
            }
      }
	  
	  //Calcola il totale di ore usate da un'attività
      function notespeseUsate($id) {
            $r = $this->Notaspesa->find('all', array(
                'conditions' => array('Notaspesa.eAttivita' => $id),
                'fields' => array('SUM(Notaspesa.importo) as S'),
                'group' => array('Notaspesa.eAttivita'),
            ));
            if (isset($r[0][0]['S']))
            {
                return $r[0][0]['S'];
            }
            else
            {
                return 0;
            }
      }

      function notespeseDaRimborsare($id) {
            $listaspese = array();
            $res = $this->Notaspesa->find('all', array(
                'conditions' => array('Notaspesa.eAttivita' => $id, 'Notaspesa.rimborsato !=' => 1 )));
            
            foreach ($res as $r) {
             $listaspese[$r['Notaspesa']['faseattivita_id']] = 0;
           }

           foreach ($res as $r) {
             $listaspese[$r['Notaspesa']['faseattivita_id']] += $r['Notaspesa']['importo'];
           }

           return $listaspese;
      }
	  
	  //Calcola il totale di ore usate da un'attività
      function primanota($id) {
            $r = $this->Primanota->find('all', array(
                'conditions' => array('Primanota.attivita_id' => $id),
                'fields' => array('SUM(Primanota.importo) as S'),
                'group' => array('Primanota.attivita_id'),
            ));
            if (isset($r[0][0]['S']))
            {
                return $r[0][0]['S'];
            }
            else
            {
                return 0;
            }
      }
	   //Calcola il totale di ore usate da un'attività
      function preventivo($id) {
            $r = $this->Faseattivita->find('all', array(
                'conditions' => array('Faseattivita.attivita_id' => $id),
                'fields' => array('SUM(Faseattivita.costou*Faseattivita.qta) as S'),
                'group' => array('Faseattivita.attivita_id'),
            ));
            if (isset($r[0][0]['S']))
            {
                return $r[0][0]['S'];
            }
            else
            {
                return 0;
            }
      }
      
      //Se $recenti è null recupero tutte le attività, 
      //altrimenti solo quelle recenti dell'utente
	  function getlist($recenti = null)
	  {
		  $attivita = Cache::read('attivita_list'.$recenti, 'short');
		  if (!$attivita) {
            if (!is_null($recenti))
			{
                $attivita = $this->Ora->find('list',  array(
                                'fields'=>Array('Attivita.id','Attivita.name'),
                                'order'=>'Attivita.name', 
                                'contain'=> array('Attivita'),
                                'conditions' => array(
                                    'Attivita.chiusa'=> 0,
                                    'Ora.eRisorsa'=> $recenti,
                                    'Ora.data >' => date('Y-m-d', strtotime('-3 month'))
                                )
                            ));
            }
            if (is_null($recenti) || !$attivita)
            {
                
                $attivita = $this->Ora->Attivita->find('list', array('order'=>'Attivita.name', 'conditions' => array('chiusa'=> 0)));
            }
			Cache::write('attivita_list', $attivita, 'short');
		  }
		  
		  return $attivita;		  
      }
      
      //Restituisce una lista semplice di id/progetti speciali
      function getProgettiSpeciali()
      {
        $proj_speciali = Configure::read('iGas.progettiSpeciali');
        $this->recursive = -1;

        //Estraggo i progetti speciali
        $a = $this->find('all', array(
            'fields' => array('id', 'name'),
            'conditions' => array('name' => $proj_speciali)
        ));
        //Li giro per ottenere una coppia id / nome semplice da usare
        foreach ($a as $aid) {
            $proj_speciali_id[$aid['Attivita']['id']] = $aid['Attivita']['name'];
        } 

        return $proj_speciali_id;
      }
}
?>