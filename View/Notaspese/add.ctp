<?php echo $this->Html->script('//maps.google.com/maps/api/js?key=' . Configure::read('google_key') ,false);?>
<?php echo $this->Html->script('googleMaps/jquery.ui.map',false);?>		
<?php echo $this->Html->script('googleMaps/jquery.ui.map.services',false);?>		
<?php echo $this->Html->script('trasferte.js',false);?> 
<?php echo $this->Html->script("notaspese",array('inline' => false)); ?>	
<?php echo $this->Html->script('jquery.pulsate.min.js',false);?>		
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>
<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?> 

<?php

  function _riga_totday(&$o, $day, $totday)
    {
       $ret = 
        '<tr class="bg-warning" style="font-weight: bold">'.
            '<td class="bg-warning">Totale&nbsp;Giorno&nbsp;' . $day. '</td>'.
            '<td class="bg-warning"></td>'.
            '<td class="bg-warning"></td>'.
            '<td class="bg-success">'. $o->Number->currency($totday,'EUR') .'</td>'.
            '<td class="bg-warning"></td>'.
            '<td class="bg-warning"></td>'.
            '<td class="bg-warning"></td>'.
            '<td class="bg-warning"></td>'.
        '</tr>';
       
       return $ret;
    }

  function badge_fatturabile($v)
    {
        if ($v['fatturabile'])
        {
            return '<span class="badge bg-success">F</span>';
        }
        else
        {
            return '<s class="badge">F</s>';
        }
    }
    
    function badge_rimborsabile($v)
    {
        if (!$v['rimborsabile'])
        {
            return '<s class="badge">R</s>';
        }
        else if ($v['rimborsabile'])
        {
            return '<span class="badge bg-success">R</span>';
        }
        
    }
       
    //Converto la query dei mezzi in un select box complesso con tutti gli attributi che mi servono in js
	foreach($legenda_mezzi as $c) {
		$legenda_mezzi_options[$c['LegendaMezzi']['id']] = array(
			'name' => $c['LegendaMezzi']['name'],
			'value' => $c['LegendaMezzi']['id'],
			'costokm' => $c['LegendaMezzi']['costokm'],
			'co2' => $c['LegendaMezzi']['co2'],
			'biglietto' => $c['LegendaMezzi']['biglietto'],
		);
	}
?>

<?php $this->Html->addCrumb("Nota Spese", "/notaspese/edit_list/persona:$eRisorsa/anno:$anno/mese:$mese/"); ?>
<?php $this->Html->addCrumb("Aggiungi", "/add"); ?>

<h1>Inserisci Nota Spese</h1>

<a href="<?php echo $this->Html->url(array('controller'=>'notaspese', 'action'=>'detail', '?'=>array('as_values_persone' => $eRisorsa .","))); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Stampa Nota Spese</a> 
<p></p>

<div class="notaspese form">
    <?php echo $this->Form->create('Notaspesa', array(
    'url' => array('controller' => 'Notaspese', 'action' => 'add', 'persona' => $eRisorsa, 'anno'=> $anno, 'mese' => $mese),
	'enctype' => 'multipart/form-data',
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-2 control-label'
		),
		'wrapInput' => 'col col-md-4',
		'class' => 'form-control'
	),	
	'class' => 'well form-horizontal'        
    )); ?>

    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Form->input('eRisorsa', array('default' => $eRisorsa, 'options' => $eRisorse, 'label' => 'Persona', 'class'=>'chosen-select col col-md-8')); ?>
    
    <?php
    $def = array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>'');
    if (strlen("$anno-$mese-$giorno")) {      
        $def['selected'] = "$anno-$mese-$giorno";        
    }    
    echo $this->Form->input('data', $def);
    ?>
        
    <?php echo $this->Form->input('eAttivita', array('options' => $eAttivita, 
                                                'label' => array('text'=>'Attivita'), 
                                                'default' => $attivita_default, 
                                                'class'=>'col col-md-8 attivita chosen-select ' . $baseformclass, //chosen-select
                                                'after' => $this->Html->link('<i class="fa fa-plus-square"></i> Aggiungi nuova Attività', 
                                                            array('controller'=>'attivita','action'=>'edit'), 
                                                            array('class'=>'btn btn-xs btn-primary', 'escape'=>false, 'target'=> 'blank','tabindex'=>-1)
                                                        ),
                                               ) 
                                  ); 
    ?>        
    
	 <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'class'=>'fase ' . $baseformclass)); ?> 
    <?php echo $this->Form->input('eCatSpesa', array('options'=>$eCatSpesa, 'label'=>'Tipo di Spesa', 'onchange' =>'SelectChanged(this)')); ?>
    <?php echo $this->Form->input('descrizione'); ?>
	<?php echo $this->Form->input('uploadFile', array('label'=>'Upload Scontrino', 'class'=>false, 'type'=>'file')); ?>

    <fieldset id="spostamento">

        <legend class="text-muted">Spostamento</legend>
        <!-- Inserire origine del dipendente dalla sua anagrafica -->
        <?php echo $this->Form->input('origine', array('placeholder'=>'Torino, IT')); ?>
        <!-- Inserire destinazione dall'attività dalla sua anagrafica -->
        <?php echo $this->Form->input('destinazione', array('placeholder'=>'La Spezia, IT', 'default'=>$destinazione)); ?>
        
        
        <div class="row">               
            <div class="alert alert-info col col-md-offset-2 col-md-5">
                <div class="btn btn-default col col-md-4" id="NotaspesaAggiorna">Aggiorna Mappa</div>
                <div id="warnings_panel" class="col col-md-7 col-md-offset-1">
                    <i class="fa-li fa fa-spinner fa-spin"></i>Calcolo il percorso
                </div>
            </div>
        </div>
        <div class="row">            
            <div class="col col-md-5 col-md-offset-2">
            <div id="map_canvas" class="map ">            
            </div>       
        </div>
        </div>
        <br/>
        <?php echo $this->Form->input('km'); ?>
        <?php echo $this->Form->input('ritorno',  array(
                          'type' => 'checkbox',
                          'default' => 1,
                          'class'=>false,
                          'label' => array('class' => null,'text'=>'Ritorno: <small>se selezionato moltiplica per 2 i km (A/R)</small>'),
                          'wrapInput' => 'col col-md-9 col-md-offset-2',                          
            )); ?>
        <?php echo $this->Form->input('legenda_mezzi_id', array('options'=>$legenda_mezzi_options, 
                                                                'label'=>'Il tuo mezzo',
                                                            'after' => $this->Html->link('<i class="fa fa-plus-square"></i> Aggiungi il tuo mezzo', 
                                                            array('controller'=>'legendamezzi','action'=>'index'), 
                                                            array('class'=>'btn btn-xs btn-primary', 'escape'=>false, 'target'=> 'blank','tabindex'=>-1)
                                                        )
            )); ?>
       <div id="co2-calc" class="row" > 
           <div class="col col-md-offset-2 col-md-6">
           <table class="table table-condensed table-bordered">
               <tr><th colspan="3" class="bg-primary">Totale CO<sub>2</sub> emessa (Kg)</th></tr>
               <tr><th>Treno</th><th>Auto</th><th>Aereo</th></tr>
               
               <tr><td id="stimato-treno"></td>
               <td id="stimato-auto"></td>
               <td id="stimato-aereo"></td></tr>
           </table>
           </div>
        </div>
    </fieldset>

    <fieldset id="importo">
        <legend class="text-muted">Importo</legend>
    <?php echo $this->Form->input('importo_val', array(
                                'label'=>'importo in VALUTA',
                                'placeholder'=>'10.4',
                                'beforeInput' => '<div class="input-group">',
                                'afterInput' => '<span id="euro-addon" class="input-group-addon">EUR</span></div>',
                                'after' => '<span class="help-block">Questa spesa <a href="javascript:;" id="non-euro">non è in Euro?</a></span>'  
                                )); ?>
    
    <div id="non-euro-zone" class="small">
        <?php echo $this->Form->input('valuta', array('default'=>'EUR','wrapInput' =>'col col-md-2', 'class'=>'form-control input-sm')); ?>
        
        <?php 
               //TODO: Incorporare l'API di conversione valuta
               $url_convertitore= "//www.google.com/finance/converter?a=1to=EUR";
               echo $this->Form->input('tasso', array('default'=>1,'wrapInput' => 'col col-md-2', 
                                        'class'=>'form-control input-sm',
                                        'after'=>'<span class="help-block">Visualizza il <a href="'. $url_convertitore. '" target="valuta">tasso di conversione odierno?</a><span>'
                            )); ?>
 
    <?php echo $this->Form->input('importo', array('label'=>'importo in EUR', 'class'=>'form-control input-sm', 'id' => 'NotaspesaModalImporto')); ?>
    </div>

    <?php echo $this->Form->input('eProvSoldi', array('options'=>$eProvSoldi, 'label'=>'Provenienza Soldi', 'empty' => '- Fondi Personali -')); ?>
    
    <?php echo $this->Form->input('fatturabile',  array(
                          'type' => 'checkbox',
                          'default' => 1,
                          'label' => 'Fatturabile al cliente finale',
                          'class'=>false,
                          'label' => array('class' => null),
                          'wrapInput' => 'col col-md-9 col-md-offset-2',
                    )); ?>
    <?php echo $this->Form->input('rimborsabile',  array(
                          'type' => 'checkbox',
                          'default' => 1,
                          'class'=>false,
                          'label' => array('class' => null),
                          'wrapInput' => 'col col-md-9 col-md-offset-2',
                    )); ?>

  </fieldset>
   <div class="row">        
       <input class="submit col-md-offset-2 btn btn-primary" type="submit" value="Salva e Aggiungi altra Nota Spese" name="submit-ns" />
       <input class="submit  btn btn-primary" type="submit" value="Salva e Aggiungi Ore" name="submit-ore" />
            
    </div>

   <?php echo $this->Form->end();?>
</div>
    
<div class="table-responsive">
  <table id="notaspese-attivita" class="table table-bordered table-hover table-striped display" cellspacing="1">
    <thead>
      <?php echo $this->Html->tableHeaders( 
              array('Giorno', 
                    'Attività',
                      'Destinazione',
                      'Categoria',
                      'Importo €',
                      'Descrizione',
                      'Flag',
                      array('Azioni' => array('class'=>'hidden-print')),
                    ),
                  array('class'=>"tablesorter")) ; ?>
    </thead>
    <tbody>
            
            <?php $tot = 0 ; $day=0; ?>
            <?php if (isset($result[0])): ?>   
            
            <?php foreach ($result as $r):            
                $d= new DateTime($r['Notaspesa']['data']);
                
                //Questo blocco serve per scrivere il totale spese di ogni giorno
                if ($day != $d->format('d')) {                       
                    //Se non è la prima volta scrivo una riga di totali
                    if ($day > 0)
                    {          
                       echo _riga_totday($this, $day, $totday);
                    }
                    $day = $d->format('d');
                    $totday=0;
                    $scrividay = $d->format('D d');
                }
                
                if($r['Notaspesa']['provenienzasoldi_id']) {
                  $soldi = "/".$eProvSoldi[$r['Notaspesa']['provenienzasoldi_id']];
                }
                else {
                  $soldi = "";
                }

				$linkScontrino='';
				$scontrinoToDrive='';
				if(file_exists(WWW_ROOT.'files/'.$this->request->controller.'/'.$r['Notaspesa']['id'].'.pdf')){
					$linkScontrino=$this->Html->link('View Scontrino', HTTP_BASE.'/'.APP_DIR.'/files/'.$this->request->controller.'/'.$r['Notaspesa']['id'].'.pdf', array('class'=>'btn btn-xs btn-primary','title'=>'View or Download PDF'));
					$scontrinoToDrive=$this->Html->link('Upload Scontrino in Drive', array('action'=>'setUploadToDrive',$r['Notaspesa']['id']),array('class'=>"btn btn-primary btn-xs glow btn-edit-riga-riga"));					
				} 

                echo $this->Html->tableCells(
                    array($d->format('D d'),
                          $eAttivita[$r['Notaspesa']['eAttivita']] . '<small class="text-muted">/' . substr($r['Faseattivita']['Descrizione'],0,40) . '</small>',
                          $r['Notaspesa']['origine'] ." > ". $r['Notaspesa']['destinazione'],                           
                          $this->Text->truncate($r['LegendaCatSpesa']['name'],17), 
                          $this->Number->currency($r['Notaspesa']['importo'],'EUR').'<small class="text-muted">'. $soldi .'</small>',                                
                          $r['Notaspesa']['descrizione'],                                                     
                          badge_fatturabile($r['Notaspesa']) . ' ' .  badge_rimborsabile($r['Notaspesa']) ,                           
                          array(                            
                            //'<div class="btn btn-primary btn-xs glow btn-edit-riga" id="'. $r['Notaspesa']['id'] . '">Edit</div>'.
                            $this->Html->Link('Edit',array('action'=>'edit',$r['Notaspesa']['id']),array('class'=>"btn btn-primary btn-xs glow btn-edit-riga-riga")).                        
                            $this->Html->Link('Del',array('action'=>'delete',$r['Notaspesa']['id']),array('class'=>"btn btn-primary btn-xs glow btn-del-riga" ),"Sicuro di voler cancellare questa riga?").
                            $this->Html->Link('Duplicate',array('action'=>'duplicate',$r['Notaspesa']['id']),array('class'=>"btn btn-primary btn-xs glow btn-edit-riga-riga" )).    
							$linkScontrino.
							$scontrinoToDrive,
                            array('class'=>'actions hidden-print')),                            
                          ),
                    array('class' => 'darker'));
                    $tot +=  $r['Notaspesa']['importo'];                                        
                    $totday +=  $r['Notaspesa']['importo'];                                        
                    $scrividay='';
                ?>
            <?php endforeach; ?>            
            <?php //Ultimo giorno
                echo _riga_totday($this, $day, $totday);
            ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
              <?php
                echo $this->Html->tableCells(
                    array('Totale',
                          '',
                          '', 
                          '<b>' . $this->Number->currency($tot,'EUR') .'</b>',                                                     
                          '', 
                          '', 
                          '', 
                          '', 
                      ),
                    array('class' => 'bg-success'));                 
                ?>
        </tfoot>
        </table>
  </div>




<?php $this->Html->scriptStart(array('inline' => false)); ?>
        $("#non-euro-zone").hide();        
        $("#co2-calc").hide();        
        mostraViaggio();        
                
        $( "#NotaspesaECatSpesa").change(function(e) {mostraViaggio();});
        $( "#NotaspesaRitorno").change(function(e) {mostraPercorso();});
        $( "#NotaspesaImportoVal").change(function(e) {convertiValuta();});
        $( "#NotaspesaTasso").change(function(e) {convertiValuta();});
        $( "#NotaspesaLegendaMezziId").change(function(e) {stimaPrezzi();});      
        $("#non-euro").click(function (e) {            
            $("#non-euro-zone").toggle();
            $("#euro-addon").toggle();
            return false;
            }
        );

<?php $this->Html->scriptEnd(); 
