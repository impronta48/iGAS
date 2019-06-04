<?php
class Cespite extends AppModel {

	public $name = 'Cespite';
	public $displayField = 'ID';
	//public $actsAs = array('Containable');
    var $order= 'Cespite.displayName';

    var $validate = array(
        'DisplayName' => array(
            'rule' => 'notEmpty',
            'required' => true
        )
    );
    
    var $belongsTo = array(
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
        
        'Persona' => array(
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
        )
        
    );
    
    public function beforeSave($options = Array()) {
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
    
}