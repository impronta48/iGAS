<?php
class Persona extends AppModel {
	public $name = 'Persona';
    public $displayField = 'DisplayName';
    public $order = 'DisplayName';
	public $cacheQueries = true;
	
	public $actsAs = array(	
        'Containable',
        'Tags.Taggable',
    );
    
	public $hasOne = array(
		'Impiegato' => array(
            'className' => 'Impiegato',
            'foreignKey' => 'persona_id',
            'dependent' => 1,
		),
	); 
    
    public $hasMany = array(
   		'Ora' => array(
            'className' => 'Ora',
            'foreignKey' => 'eRisorsa',		
		),
	); 
	
	/*
	// Questa non è vera validazione lato client perchè comunque il round trip c'è, 
	// al massimo non avviene l'inserimento a DB
	public $validate = array(
		'indirizzoPEC' => array(
							'rule' => 'email',
							'allowEmpty' => true,
							'message' => 'Inserisci una mail valida')
	);
	*/

}
?>