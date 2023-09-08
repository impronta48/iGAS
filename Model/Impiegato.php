<?php
class Impiegato extends AppModel {
	
    public $actsAs = ['Containable'];

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

    public function oreContratto($id,$mese,$anno)
    {
        $this->recursive = -1;
        $impiegato = $this->findByPersonaId($id);
        //debug($impiegato); die;
        $sommaOre=0;
        $number = cal_days_in_month(CAL_GREGORIAN, $mese, $anno); //numero di giorni nel mese corrente
        $nomiColonne = ['oreDom','oreLun','oreMar','oreMer','oreGio','oreVen','oreSab'];
        for($i=1;$i<=$number;$i++)
        {
            $timestamp = strtotime($anno.'-'.$mese.'-'.$i);
            $gSett= date('w', $timestamp);
            //var_dump($gSett);
            //La @ è per togliere il notice in caso in cui una persona non abbia un tetto ore (essere impiegato)
            //iGAS attualmente permette di far inserire ore a persone che non hanno tetti ore / contratti 
            //probabilmente in un ottica in cui anche esterni possono lavorare
            $sommaOre+=@$impiegato['Impiegato'][$nomiColonne[$gSett]];
        }
        return $sommaOre;
    }
}
