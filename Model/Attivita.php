<?php
class Attivita extends AppModel {
	var $name = 'Attivita';
	var $displayField = 'name';
  //var $order= 'Attivita.id DESC';
  var $order= 'Attivita.name';
  var $actsAs = ['Containable'];
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = [
        'Fatturaemessa',
        'Notaspesa' => [
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
		],
        'Alias' => [
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
		],
        'Faseattivita' => [
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
		],
        'Ora' => [
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
		],
		'Primanota',
		'Fatturaricevuta'
	];

	var $belongsTo = ['Progetto','Area',
        'Persona' => [
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
		],
      ];

      //Questa funzione svuota la data se è nulla, per evitare che diventi 0000-00-00
      function beforeSave($options = []) {
          parent::beforeSave($options);

          $k = array_keys($this->data['Attivita']);
          foreach ($k as $f)
          {
              if ($this->data['Attivita'][$f]==0 && $this->_schema[$f]['type']=='date')
              {
                  $this->data['Attivita'][$f]=NULL;
              }
          }
          
          Cache::delete('faseattivita_2level');
          return true;
      }

      //Calcola il totale di ore usate da un'attività
      function oreUsate($id) {
            $r = $this->Ora->find('all', [
                'conditions' => ['Ora.eAttivita' => $id],
                'fields' => ['SUM(Ora.numOre) as S'],
                'group' => ['Ora.eAttivita'],
            ]);
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
            $r = $this->Ora->find('all', [
                'conditions' => ['Ora.eAttivita' => $id,  'Ora.pagato !=' => 1],
                'fields' => ['SUM(Ora.numOre) as S'],
                'group' => ['Ora.eAttivita'],
            ]);
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
            $r = $this->Notaspesa->find('all', [
                'conditions' => ['Notaspesa.eAttivita' => $id],
                'fields' => ['SUM(Notaspesa.importo) as S'],
                'group' => ['Notaspesa.eAttivita'],
            ]);
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
            $listaspese = [];
            $res = $this->Notaspesa->find('all', [
                'conditions' => ['Notaspesa.eAttivita' => $id, 'Notaspesa.rimborsato !=' => 1 ]]);

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
            $r = $this->Primanota->find('all', [
                'conditions' => ['Primanota.attivita_id' => $id],
                'fields' => ['SUM(Primanota.importo) as S'],
                'group' => ['Primanota.attivita_id'],
            ]);
            if (isset($r[0][0]['S']))
            {
                return $r[0][0]['S'];
            }
            else
            {
                return 0;
            }
      }

        function preventivo($id) {
            $r = $this->Faseattivita->find('all', [
                'conditions' => ['Faseattivita.attivita_id' => $id],
                'fields' => ['SUM(Faseattivita.costou*Faseattivita.qta) as S'],
                'group' => ['Faseattivita.attivita_id'],
            ]);
            if (isset($r[0][0]['S']))
            {
                return $r[0][0]['S'];
            }
            else
            {
                return 0;
            }
        }

        function offertaAlCliente($id) {
            $r = $this->Faseattivita->find('all', [
                'conditions' => ['Faseattivita.attivita_id' => $id],
                'fields' => ['SUM(Faseattivita.vendutou*Faseattivita.qta) as S'],
                'group' => ['Faseattivita.attivita_id'],
            ]);
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
          $attivita = Cache::read('attivita_list_'.$recenti, 'short');
		  if (!$attivita) {
            if (!is_null($recenti))
			{
                $attivita = $this->Ora->find('list',  [
                                'fields'=>['Attivita.id','Attivita.name'],
                                'order'=>'Attivita.name',
                                'contain'=> ['Attivita'],
                                'conditions' => [
                                    'Attivita.chiusa'=> 0,
                                    'Ora.eRisorsa'=> $recenti,
                                    'Ora.data >' => date('Y-m-d', strtotime('-3 month'))
                                ]
                            ]);
            }
            if (is_null($recenti) || !$attivita)
            {
                //$attivita = $this->Ora->Attivita->find('list', array('order'=>'Attivita.name', 'conditions' => array('chiusa'=> 0)));

                $attivita = $this->find('list');
                //debug($attivita); die;
            }
			Cache::write('attivita_list_'.$recenti, $attivita, 'short');
		  }

		  return $attivita;
      }

      //Restituisce una lista semplice di id/progetti speciali
      function getProgettiSpeciali()
      {
        $proj_speciali = Configure::read('iGas.progettiSpeciali');
        $this->recursive = -1;

        //Estraggo i progetti speciali
        $a = $this->find('all', [
            'fields' => ['id', 'name'],
            'conditions' => ['name' => $proj_speciali]
        ]);
        //Li giro per ottenere una coppia id / nome semplice da usare
        foreach ($a as $aid) {
            $proj_speciali_id[$aid['Attivita']['id']] = $aid['Attivita']['name'];
        }

        return $proj_speciali_id;
      }

      //Se l'utente non è nel gruppo admin non devo mostrare le attività chiuse
      function beforeFind($query)
      {
          if (!Auth::hasRole(Configure::read('Role.admin')))
          {
                $query['conditions']['chiusa'] = 0;
          }
          return $query;
      }
}
?>