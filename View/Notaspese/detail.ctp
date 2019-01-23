<?php echo $this->Html->script("notaspese",array('inline' => false)); ?>
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php $baseformclass = ' form-control'; ?> 

<?php if (isset($this->request->query['attivita']) && count($this->request->query['attivita'])==1 && !empty($this->request->query['attivita'][0]))
    {
      $id = $this->request->query['attivita'][0];
      echo $this->element('secondary_attivita', array('aid'=>$id)); 
      $this->Html->addCrumb("Attività", "/attivita/");
      $this->Html->addCrumb("Attività [$id]" , "/attivita/edit/$id");
      $this->Html->addCrumb("Ore", "");

    }   
?>
<div class="ore view">
    <h2>Dettaglio NotaSpese</h2>
    <div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					Azioni <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a class="fattura" href="#" id="fattura"><i class="fa fa-envelope"></i> Aggiungi Fatturato</a></li>
					<li><a class="rimborsa" href="#" id="set"><i class="fa fa-euro"></i> Aggiunti Rimborsato</a></li>					
					<li><a class="rimborsa" href="#" id="remove"><i class="fa fa-euro"></i> Rimuovi Rimborsato</a></li>					
          <li><a class="stampa" href="#" ><i class="fa fa-file"></i> Genera report per il cliente</a></li>          
					<li><a class="stampa_collaboratore" href="#" ><i class="fa fa-file"></i> Genera report del collaboratore</a></li>					
        </ul>
	</div>

  <br><br>
  <?php
            //massimoi 3/9/13
            //imposto i valori di default a partire dalla querystring
            if (isset($this->request->query['from']))
            {
                $f = $this->request->query['from'];
            }
            else
            {
                $f = '';
            }
            if (isset($this->request->query['to']))
            {
                $t = $this->request->query['to'];
            }
            else
            {
                $t = '';
            }
            if (isset($this->request->query['attivita']))
            {
                $a = $this->request->query['attivita'];                
            }
            else
            {
                $a = '';
            }
            if (isset($this->request->query['faseattivita_id']))
            {
                $fa = $this->request->query['faseattivita_id'];                
            }
            else
            {
                $fa = '';
            }

            if (isset($this->request->query['persone']))
            {
                $p = $this->request->query['persone'];                
            }
            else
            {
                $p = '';
            }
            
?>

<?php echo $this->Form->create('Notaspesa', array('id' => 'stats-form','type' => 'get', 
  'inputDefaults' => array(
    'div' => 'form-group',
    'label' => array(
      'class' => 'col-md-3 control-label'
    ),
    'wrapInput' => 'col-md-9',
    'class' => 'form-control'
  ),  
  'class' => 'well form-horizontal row'        
    )); ?>
   
    <div class="col-md-6">
        <?php echo $this->Form->input('attivita', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$attivita_list, 'value'=>$a)); ?>
        <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'multiple'=>true, 'options'=>$faseattivita_list,
                                        'class'=>'fase chosen-select' . $baseformclass, 'value'=>$fa
                                    )); ?> 
        <?php echo $this->Form->input('persone', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$persona_list, 'value'=>$p)); ?>
        
        <?php echo $this->Form->input('from', array('id' => 'from', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>$f,
                                    'default'=>date('Y-m-d', strtotime('first day of last month')))); ?>
        <?php echo $this->Form->input('to', array('id' => 'to', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>$t)); ?>
        <?php
            $fat = $this->request->query('fatturato');
            $fatbile = $this->request->query('fatturabile');
            $rim = $this->request->query('rimborsato');
            $rimbile = $this->request->query('rimborsabile');
        ?>       
    </div>

    <div class="col-md-6">

      <?php echo $this->Form->input(__('fatturato'), array('options' => array('-1' => '',1 => 'Si',0 => 'No'), 'default' => $fat)); ?>
      <?php echo $this->Form->input(__('rimborsato'), array('options' => array('-1' => '',1 => 'Si',0 => 'No'), 'default' => $rim)); ?>
      <?php echo $this->Form->input(__('fatturabile'), array('options' => array('-1' => '',1 => 'Si',0 => 'No'), 'default' => $fatbile)); ?>
      <?php echo $this->Form->input(__('rimborsabile'), array('options' => array('-1' => '',1 => 'Si',0 => 'No'), 'default' => $rimbile)); ?>
      <?php echo $this->Form->input('eProvSoldi', array('options'=>$eProvSoldi, 'label'=>'Provenienza Soldi', 'empty' => '')); ?>
    </div>

    <?php echo $this->Form->submit(__('Filtra Risultati'), array('class'=>'col-md-offset-2')); ?>

    <?php echo $this->Form->end(); ?>


    <!-- INIZIA A SCRIVERE LA TABELLA -->

    <?php if (isset($result[0])): ?>        
        <?php
            echo $this->Form->create("Ore",array('detail' => 'index',                
                   'type' => 'post',
                   'id' => 'multiriga',
                   'inputDefaults' => array(
                        'div' => 'form-group',
                        'label' => false,
                        'wrapInput' => false,
                        'class' => 'form-control'
                    ),
                    'class' => ' form-inline',
                ));
        ?>  
        <table id="notaspese-attivita" class="table table-bordered table-hover table-striped display dataTable" cellspacing="1">
        <thead>
            <?php echo $this->Html->tableHeaders( array('<input type="checkbox" id="select-all"/>','Stato','Fatturabile', 'Attività', 'Fase','Risorsa', 'Data','Importo','Km','Descrizione','Origine', 'Destinazione','Categoria','Azioni'), array('class'=>"tablesorter")) ; ?>
        </thead>
        <tbody>
            <?php 
                  $tot = 0 ; 
                  $totkm = 0 ; 
                  foreach ($result as $r): 
            ?>
            <?php
                $d= new DateTime($r['Notaspesa']['data']);
				$rimborsato = '';
				$fatturato = '';
				if ($r['Notaspesa']['rimborsato'] && $r['Notaspesa']['rimborsabile'] )
				{
					$rimborsato = 'Rimborsato';
				}
				elseif  (!$r['Notaspesa']['rimborsato'] && $r['Notaspesa']['rimborsabile'] )
				{
					$rimborsato = 'Da rimborsare';
				}
					
				if (!$r['Notaspesa']['rimborsabile'])
				{
					$rimborsato = 'NON rimborsare (prepagata)';
				}
				if ($r['Notaspesa']['fatturabile'] && !$r['Notaspesa']['fatturato'])
				{
					$fatturato = 'Il consulente mette in fattura';
				}
				else if ($r['Notaspesa']['fatturabile'] && $r['Notaspesa']['fatturato'])
				{
					$fatturato = 'Già fatturato dal consulente';
				}
				else if (!$r['Notaspesa']['fatturabile'] && $r['Notaspesa']['fatturato'])
				{
					$fatturato = 'ERRORE: Non fatturabile ma fatturato';
				}
				
                echo $this->Html->tableCells(
                    array(
                        $this->Form->checkbox('Notaspesa.'. $r['Notaspesa']['id'] .'.id', array(                                                                                                         
                                                     'class' => 'selectable',
                                                     'hiddenField' => false  //non mi serve passare tutti gli zero
                                                  )),
                          "<small>$rimborsato</small>",                        
                          "<small>$fatturato</small>",                        
                          $attivita_list[$r['Notaspesa']['eAttivita']],
                          $r['Faseattivita']['descrizione'],
                          $persona_list[$r['Notaspesa']['eRisorsa']],
                          $d->format('Y-m-d'),
                          $this->Number->currency($r['Notaspesa']['importo'],'EUR'),  
                          $this->Number->precision($r['Notaspesa']['km'],0), 
                          $r['Notaspesa']['descrizione'], 
                          $r['Notaspesa']['origine'], 
                          $r['Notaspesa']['destinazione'], 
                          $r['LegendaCatSpesa']['name'], 
                          array(
                            $this->Html->link('Edit',array('action'=>'edit',$r['Notaspesa']['id']),array('class'=>"btn btn-primary btn-xs glow" )) .
                            $this->Html->link('Del',array('action'=>'delete',$r['Notaspesa']['id']),array('class'=>"btn btn-primary btn-xs glow" )),                        
                            array('class'=>'actions'),
                            ), 

                      ),
                    array('class' => 'darker'));
                    $tot +=  $r['Notaspesa']['importo'];
                    $totkm +=  $r['Notaspesa']['km'];
                ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
              <?php
                echo $this->Html->tableCells(
                    array('Totale',
                          '',
                          '',
                          '',
                          '',
						              '',
                          '',
                          '<b>' . $this->Number->currency($tot,'EUR') .'</b>',                                                      
                          '<b>' . $this->Number->precision($totkm,0) .'</b>',                                                                                
                          '', 
                          '', 
                          '', 
                          '', 
                          '', 
                      ),
                    array('class' => 'bg-success'));                 
                ?>
        </tfoot>
        </table>
    <?php echo $this->Form->end(); ?>
    <?php endif; ?>
	
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
        $(document).ready(function() {

        var table = $('.dataTable').dataTable({
    
        "iDisplayLength" : 100,
        dom: 'Bfrtip',
        buttons: [
                'copy', 'csv', 'excel', 'print'
            ]        
    
  });

            $('#from').datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateText, inst) {
                    $('#to').datepicker("option", "minDate", dateText); //no dates before selected 'from' allowed
                }
            });

            $('#to').datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateText, inst) {
                    $('#from').datepicker("option", "maxDate", dateText); //no dates after selected 'to' allowed
                }
            });
        });

<?php $this->Html->scriptEnd();