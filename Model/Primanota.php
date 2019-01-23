<?php
class Primanota extends AppModel {
	
	var $belongsTo = array(
        'Attivita',
        'LegendaCatSpesa',
        'Fatturaemessa',
        'Faseattivita',
        'Fatturaricevuta',
        'Provenienzasoldi',        
        'Persona',        
	);
    
    
    //Aggiungo il taggable per poter aggiungere un tag alla prima nota e fare dei raggruppamenti
    //Esempio per rendicontazione
    public $actsAs = array(	
        'Containable',
        'Tags.Taggable',
    );
}
?>