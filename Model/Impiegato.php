<?php
class Impiegato extends AppModel {
	
	var $belongsTo = array(
		'Persona' => array(
            'className' => 'Persona',
            'foreignKey' => 'persona_id',
		),
        'LegendaTipoImpiegato' => array(
            'className' => 'LegendaTipoImpiegato',
            'foreignKey' => 'legendaTipoImpiegato_id',
		),
        'LegendaUnitaMisura' => array(
            'className' => 'LegendaUnitaMisura',
            'foreignKey' => 'legendaUnitaMisura_id',
		),
	); 

    public function attivo()
    {
        return $this->find('all', array('conditions'=>array('disattivo'=>0),'fields'=>array('id','Persona.id','Persona.DisplayName'), 'order'=>'Persona.Cognome'));
    }
}
