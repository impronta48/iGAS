<?php
class Fatturaemessa extends AppModel {
	var $name = 'Fatturaemessa';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
    var $order = 'data DESC, AnnoFatturazione DESC, Progressivo';
    var $actsAs = array('Containable');
    
    var $hasMany = array(
            'Rigafattura' => array(
                'className' => 'Rigafattura',
                'foreignKey' => 'fattura_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            )
        );
    
	var $belongsTo = array(
		'Attivita' => array(
			'className' => 'Attivita',
			'foreignKey' => 'attivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProvenienzaSoldi' => array(
			'className' => 'Provenienzasoldi',
			'foreignKey' => 'provenienzasoldi_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    
    //Campo calcolato che prende il totale delle righe fattura
    public $virtualFields =array(
            'TotaleNetto' => 'SELECT SUM(Rigafattura.Importo) from righefatture Rigafattura WHERE Rigafattura.fattura_id = Fatturaemessa.id', 
            'TotaleLordo' => 'SELECT SUM(Rigafattura.Importo*(1+Percentuale/100)) FROM righefatture Rigafattura LEFT JOIN legenda_codici_iva LegendaCodiciIva ON codiceiva_id = LegendaCodiciIva.id WHERE Rigafattura.fattura_id = Fatturaemessa.id',
            'Descrizione' => 'CONCAT(Fatturaemessa.AnnoFatturazione, "/", Fatturaemessa.Progressivo , " - ", LEFT(Fatturaemessa.Motivazione,50))',
            //'Pagato' => 'SELECT SUM(Primanota.Importo) from primanota Primanota WHERE Primanota.fattura_id = Fatturaemessa.id'
            ); 
            
    //restituisce il prossimo progessivo libero di una fattura
    //se non c'è il parametro vale l'anno corrente, altrimenti l'anno passato
    public function progressivoLibero($serie, $anno = null)
    { 
        if (empty($anno))
        {
            $anno = date('Y');
        }
        
        $conditions = array();
        $conditions['AnnoFatturazione'] = $anno;
        if (!empty($serie))
        {
        	$conditions['Serie'] = $serie;
        }

		$result = $this->find('first', array(
           'fields' => array('MAX(CAST(Progressivo as SIGNED))+1 as progressivoLibero'),
           'conditions' => $conditions,        
   		   ));     

        if (is_null($result[0]['progressivoLibero']))
        {
            return 1;
        }
        else
        {
            return $result[0]['progressivoLibero'];
        }
        
    }    
}
