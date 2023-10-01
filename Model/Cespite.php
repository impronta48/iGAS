<?php
class Cespite extends AppModel {

	public $name = 'Cespite';
	public $displayField = 'ID';
	//public $actsAs = array('Containable');
    var $order= 'Cespite.displayName';

    var $validate = [
        'DisplayName' => [
            'rule' => 'notEmpty',
            'required' => true
        ]
    ];
    
    var $belongsTo = [
        /*
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
        */
        
        'Persona' => [
            'className' => 'Persona',
            'foreignKey' => 'proprietario_interno',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ]
        
    ];
    
    public function beforeSave($options = []) {
        if($this->data['Cespite']['proprietario_interno']){
            $this->Persona->id = $this->data['Cespite']['proprietario_interno'];
            $personaDisplay = $this->Persona->read('Persona.DisplayName');
            if($personaDisplay['Persona']['DisplayName'] != $this->data['Persona']['DisplayName']){
                $this->data['Cespite']['proprietario_interno'] = null;
                $this->data['Cespite']['proprietario_esterno'] = $this->data['Persona']['DisplayName'];
            } else {
                $this->data['Cespite']['proprietario_esterno'] = null;
            }
        } else {
            if($this->data['Persona']['DisplayName']){
                $this->data['Cespite']['proprietario_esterno'] = $this->data['Persona']['DisplayName'];
            }
        }
    }

    public function getSimple($id = null){
        $conditions = [];
        if(!$id){
            $cespiti = $this->find('list',  [
                'fields'=>['Cespite.id','Cespite.DisplayName'],
                'order'=>'Cespite.DisplayName', 
                'conditions' => $conditions
            ]);
            /*
            Questo blocco è per rendere la lista più parlante e formattata
            $notset = array('0'=> '-- Non definito --');   	
            $cespiti =$this->find('all', array('order'=>'Cespite.DisplayName', 'conditions' => $conditions));
            $cespiti = Hash::combine($cespiti, 
                                '{n}.Cespite.id', 
                                array('%.40s','{n}.Cespite.descrizione', '{n}.Cespite.costo_acquisto'),                            
                                '{n}.Cespite.DisplayName'
                            );
            $cespiti = Hash::merge($notset, $cespiti);
            */
        } else {
            $conditions = ['Cespite.id' => $id];
            $cespiti = $this->find('first', [
                'conditions' => $conditions
            ]);
        }
        return $cespiti;
	}
    
}