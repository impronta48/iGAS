<?php echo $this->Html->script("bootstrap-datepicker",array('inline' => false)); ?>
<?php echo $this->Html->script("locales/bootstrap-datepicker.it",array('inline' => false)); ?>
<?php echo $this->Html->script("notaspese",array('inline' => false)); ?>
<?php echo $this->Html->script("bootstrap-modalmanager",array('inline' => false)); ?>
<?php echo $this->Html->script("bootstrap-modal",array('inline' => false)); ?>

<?php echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=true',false);?>		
<?php echo $this->Html->script('googleMaps/jquery.ui.map',false);?>		
<?php echo $this->Html->script('googleMaps/jquery.ui.map.services',false);?>		
<?php echo $this->Html->script('trasferte.js',false);?>		
<?php echo $this->Html->script('jquery.pulsate.min.js',false);?>		

<?php echo $this->Html->css("bootstrap-modal-bs3fix",array('inline' => false)); ?>
<?php echo $this->Html->css("bootstrap-modals",array('inline' => false)); ?>

<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>


<?php
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
?>

<div class="ore view">
    <h2><small>Gestione nota spese di</small> <?php echo $eRisorse[$eRisorsa]; ?></h2>
    <div class="row">
        <div class="col-md-2">
            <span class="pull-right">Dettaglio Spese per il mese</span>
        </div>
        <div class="input-group bootstrap-datepicker col-md-2">						
            <input id="dpMonths" class="form-control" size="8" type="text" value="<?php echo $mese; ?>/<?php echo $anno; ?>" readonly date-date-format="mm/yyyy"></input>
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
    
    </div>
    <hr/>
    <!-- comandi -->
    <div class="hidden-print">    
        <div id="btn-aggiungi" class="btn btn-primary"><i class="fa-plus-circle fa"></i> Aggiungi Spesa</div>  
        <div id="btn-aggiungi-ricorrente" class="btn btn-default disabled">Aggiungi Spesa Ricorrente</div>  
        <div id="btn-riordina" class="btn btn-primary"><i class="fa-sort-alpha-asc fa"></i> Riordina Tabella</div>  
        <div id="btn-stampa" class="btn btn-primary disabled"><i class="fa-print fa"></i> Stampa Nota Spese</div>  
        <a href="<?php echo $this->Html->url(array('action'=>'stampa', '#null'))?>" id="btn-pdf" class="btn btn-primary disabled"><i class="fa-file fa"></i> PDF</a>  
    </div>
    <!-- legenda dei flag -->
    <div class="pull-right hidden-print">        
        <b>Legenda:</b> <?php  $v['fatturabile']=1; echo badge_fatturabile($v) ?> Fatturabile | 
            <?php $v['fatturabile']=0; echo badge_fatturabile($v) ?> Non fatturabile | 
            <?php $v['rimborsabile']=0; echo badge_rimborsabile($v) ?> Non rimborsabile 
            
    </div>
    <br>
    
    <!-- tabella e form -->
        <?php echo $this->Form->create('Notaspesa', array('action'=>'edit_riga', 'inputDefaults' => array('class' => 'form-control'))); ?>
            <?php echo $this->Form->hidden('eRisorsa', array('value'=>$eRisorsa)); //Memorizzo la risorsa per il salvataggio ?>
            <?php echo $this->Form->hidden('Notaspesa.data.month', array('value'=>$mese)); //Memorizzo la risorsa per il salvataggio ?>
            <?php echo $this->Form->hidden('Notaspesa.data.year', array('value'=>$anno)); //Memorizzo la risorsa per il salvataggio ?>
		
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
                
                echo $this->Html->tableCells(
                    array($d->format('D d'),
                          $attivita_list[$r['Notaspesa']['eAttivita']] . '<small class="text-muted">/' . substr($r['Faseattivita']['Descrizione'],0,40) . '</small>',
                          $r['Notaspesa']['origine'] ." > ". $r['Notaspesa']['destinazione'],                           
                          $this->Text->truncate($r['LegendaCatSpesa']['name'],17), 
                          $this->Number->currency($r['Notaspesa']['importo'],'EUR'),                                
                          $r['Notaspesa']['descrizione'],                                                     
                          badge_fatturabile($r['Notaspesa']) . ' ' .  badge_rimborsabile($r['Notaspesa']) ,                           
                          array(                            
                            '<div class="btn btn-primary btn-xs glow btn-edit-riga" id="'. $r['Notaspesa']['id'] . '">Edit</div>'.                            
                            $this->Html->Link('Del',array('action'=>'delete',$r['Notaspesa']['id']),array('class'=>"btn btn-primary btn-xs glow btn-del-riga" ),
                                        "Sicuro di voler cancellare questa riga?"),                        
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
       
    
    <div class="panel-body panel-border">
        <div class="page-container">
        <div id="responsive" class="modal fade" tabindex="-1" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Dettagli Spostamento</h4>
            </div>
            <div class="modal-body">
                        <div class="row">               
                            <div class="col col-md-5">
                                <!-- Inserire origine del dipendente dalla sua anagrafica -->
                                <?php echo $this->Form->input('Notaspesa.origine', array('placeholder'=>'Torino, IT')); ?>                                
                            </div>

                            <div class="col col-md-5">
                                <!-- Inserire destinazione dall'attività dalla sua anagrafica -->                                    
                                <!-- TODO: Inserisci via jquery lo stesso valore del campo destinazione -->
                                <?php echo $this->Form->input('NSDest', array('placeholder'=>'La Spezia, IT', 'label'=> 'Destinazione')); ?>
                            </div>                        
                            <div class="col col-md-1">
                                <br/>
                                <div class="btn btn-default col" id="NotaspesaAggiorna"><i class="fa fa-refresh"></i> </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">            
                            <div class="col col-md-12">
                                <div id="warnings_panel" class="alert alert-info"></div>
                                <div id="map_canvas" class="map"></div>       
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col col-md-12">
                        <?php echo $this->Form->input('Notaspesa.km'); ?>
                        <?php echo $this->Form->input('Notaspesa.ritorno',  array(
                                          'type' => 'checkbox',
                                          'default' => 1,
                                          'class'=>false,
                                          'label' => array('class' => null,'text'=>'Ritorno: <small>se selezionato moltiplica per 2 i km (A/R)</small>'),
                                          'wrapInput' => 'col col-md-9',                          
                            )); ?>
                            </div>
                        </div>
                        
                        <div class="row"> 
                            <div class="col col-md-8">                        
                                <?php echo $this->Form->input('Notaspesa.legenda_mezzi_id', array('options'=>$legenda_mezzi_options, 
                                                                                'label'=>'Il tuo mezzo')
                                ); ?>
                            </div>
                            <div class="col col-md-3">   
                                <?php echo $this->Html->link('<i class="fa fa-plus-square"></i> Aggiungi un mezzo', 
                                    array('controller'=>'legendamezzi','action'=>'index'),
                                    array('class'=>'btn btn-xs btn-default', 'escape'=>false, 'target'=> 'blank','tabindex'=>-1));
                                ?>
                            </div>
                       </div>
                      
                       <div id="co2-calc" class="row" > 
                           <div class="col col-md-12">
                           <table class="table table-condensed table-bordered">
                               <tr><th colspan="3" class="bg-primary">Totale CO<sub>2</sub> emessa (Kg)</th></tr>
                               <tr><th>Treno</th><th>Auto</th><th>Aereo</th></tr>

                               <tr><td id="stimato-treno"></td>
                               <td id="stimato-auto"></td>
                               <td id="stimato-aereo"></td></tr>
                           </table>
                           </div>
                        </div>
                    
                        <div class="row"> 
                            <div class="col col-md-4">              
                            <?php echo $this->Form->input('Notaspesa.importo_val', array(
                                    'label'=>'Importo in VALUTA',
                                    'placeholder'=>'10.4',
                                    'beforeInput' => '<div class="input-group">',
                                    'afterInput' => '<span id="euro-addon" class="input-group-addon">EUR</span></div>',
                                    'after' => '<span class="help-block">Questa spesa <a href="javascript:;" id="non-euro">non è in Euro?</a></span>'  
                                    )); ?>
                            </div>
                        
                            <div id="non-euro-zone" class="col col-md-8 small well" > 
                                <div class="col col-md-4">
                                <?php echo $this->Form->input('Notaspesa.valuta', array('default'=>'EUR',                                
                                                    'class'=>'input-sm form-control')); 
                                ?>
                                </div>
                                <div class="col col-md-4">
                                <?php 
                                       //TODO: Incorporare l'API di conversione valuta
                                       $url_convertitore= "https://www.google.com/finance/converter?a=1to=EUR";
                                       echo $this->Form->input('Notaspesa.tasso', array('default'=>1,
                                                    'class'=>'input-sm form-control',
                                                    'after'=>'<span class="help-block">Visualizza il <a href="'. $url_convertitore. '" target="valuta">tasso di conversione odierno?</a><span>'
                                                    )); 
                                ?>
                                </div>
                                <div class="col col-md-4">  
                                <?php echo $this->Form->input('Notaspesa.modalImporto', array('label'=>'importo in EUR',                                     
                                                    'class'=>'input-sm form-control')); 
                                ?>
                                </div>
                            </div>                            
                        </div>
                    
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Chiudi</button>
                <button id="btn-modal-save" type="button" class="btn btn-primary">Salva</button>
            </div>
        </div>
    </div>
    </div>
    
     <?php echo $this->Form->end(); ?>
    <p>&nbsp;</p>
</div>
