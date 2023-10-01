<?php
class Persona extends AppModel {
	public $name = 'Persona';
    public $displayField = 'DisplayName';
    public $order = 'DisplayName';
	public $cacheQueries = true;
	
	public $actsAs = [	
        'Containable',
        'Tags.Taggable',
    ];
    
	public $hasOne = [
		'Impiegato' => [
            'className' => 'Impiegato',
            'foreignKey' => 'persona_id',
            'dependent' => 1,
		],
	]; 
    
    public $hasMany = [
   		'Ora' => [
            'className' => 'Ora',
            'foreignKey' => 'eRisorsa',		
		],
	]; 
	
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