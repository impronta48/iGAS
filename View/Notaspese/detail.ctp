<?php echo $this->Html->script("notaspese",['inline' => false]); ?>
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php $baseformclass = ' form-control'; ?> 

<?php if (isset($attivita_selected) && is_array($attivita_selected) && count($attivita_selected)==1 && !empty($attivita_selected[0]))
    {
      $id = $attivita_selected[0];
      echo $this->element('secondary_attivita', ['aid'=>$id]); 
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

<?php echo $this->Form->create('Notaspesa', ['id' => 'stats-form','type' => 'get', 
  'inputDefaults' => [
    'div' => 'form-group',
    'label' => [
      'class' => 'col-md-3 control-label'
    ],
    'wrapInput' => 'col-md-9',
    'class' => 'form-control'
  ],  
  'class' => 'well form-horizontal row'        
    ]); ?>
   
    <div class="col-md-6">
        <?php echo $this->Form->input('attivita', ['multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$attivita_list, 'value'=> $attivita_selected]); ?>
        <?php echo $this->Form->input('faseattivita_id', ['label'=>'Fase Attività', 'multiple'=>true, 'options'=>$faseattivita_list,
                                        'class'=>'fase chosen-select' . $baseformclass, 'value'=>$faseattivita_id
                                    ]); ?> 
        <?php echo $this->Form->input('persone', ['multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$persona_list, 'value'=>$persona_selected]); ?>
        
        <?php echo $this->Form->input('from', ['id' => 'from', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>$from, 'class'=> 'datepicker form-control',
                                    'default'=>date('Y-m-d', strtotime('first day of last month'))]); ?>
        <?php echo $this->Form->input('to', ['id' => 'to', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>$to, 'class'=> 'datepicker form-control']); ?>
        <?php
            $fat = $this->request->query('fatturato');
            $fatbile = $this->request->query('fatturabile');
            $rim = $this->request->query('rimborsato');
            $rimbile = $this->request->query('rimborsabile');
        ?>       
    </div>

    <div class="col-md-6">

      <?php echo $this->Form->input(__('fatturato'), ['options' => ['-1' => '',1 => 'Si',0 => 'No'], 'default' => $fat]); ?>
      <?php echo $this->Form->input(__('rimborsato'), ['options' => ['-1' => '',1 => 'Si',0 => 'No'], 'default' => $rim]); ?>
      <?php echo $this->Form->input(__('fatturabile'), ['options' => ['-1' => '',1 => 'Si',0 => 'No'], 'default' => $fatbile]); ?>
      <?php echo $this->Form->input(__('rimborsabile'), ['options' => ['-1' => '',1 => 'Si',0 => 'No'], 'default' => $rimbile]); ?>
      <?php echo $this->Form->input('eProvSoldi', ['options'=>$eProvSoldi, 'label'=>'Provenienza Soldi', 'empty' => '']); ?>
    </div>

    <?php echo $this->Form->submit(__('Filtra Risultati'), ['class'=>'col-md-offset-2']); ?>

    <?php echo $this->Form->end(); ?>


    <!-- INIZIA A SCRIVERE LA TABELLA -->

    <?php if (isset($result[0])): ?>        
        <?php
            echo $this->Form->create("Ore",['detail' => 'index',                
                   'type' => 'post',
                   'id' => 'multiriga',
                   'inputDefaults' => [
                        'div' => 'form-group',
                        'label' => false,
                        'wrapInput' => false,
                        'class' => 'form-control'
                    ],
                    'class' => ' form-inline',
                ]);
        ?>  
        <table id="notaspese-attivita" class="table table-bordered table-hover table-striped display dataTable" cellspacing="1">
        <thead>
            <?php echo $this->Html->tableHeaders( ['<input type="checkbox" id="select-all"/>','Stato','Fatturabile', 'Attività', 'Fase','Risorsa', 'Data','Importo','Km','Descrizione','Origine', 'Destinazione','Categoria','Azioni'], ['class'=>"tablesorter"]) ; ?>
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
                
                $trOddBgClass=$trEvenBgClass='';
                foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
                    if(file_exists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$r['Notaspesa']['id'].'.'.$ext)){
                        $trOddBgClass='bg-primary ';
                        $trEvenBgClass='bg-info ';
                    }
                }
                
                echo $this->Html->tableCells(
                    [
                        $this->Form->checkbox('Notaspesa.'. $r['Notaspesa']['id'] .'.id', [                                                                                                         
                                                     'class' => 'selectable',
                                                     'hiddenField' => false  //non mi serve passare tutti gli zero
                                                  ]),
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
                          [
                            $this->Html->link('Edit',['action'=>'edit',$r['Notaspesa']['id']],['class'=>"btn btn-primary btn-xs glow" ]) .
                            $this->Html->link('Del',['action'=>'delete',$r['Notaspesa']['id']],['class'=>"btn btn-primary btn-xs glow" ]),                        
                            ['class'=>'actions'],
                          ],
                      ],
                    ['class' => $trOddBgClass.'darker'],
                    ['class' => $trEvenBgClass]);
                    $tot +=  $r['Notaspesa']['importo'];
                    $totkm +=  $r['Notaspesa']['km'];
                ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
              <?php
                echo $this->Html->tableCells(
                    ['Totale',
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
                      ],
                    ['class' => 'bg-success']);                 
                ?>
        </tfoot>
        </table>
    <?php echo $this->Form->end(); ?>
    <?php endif; ?>
	
</div>

<?php $this->Html->scriptStart(['inline' => false]); ?>
        $(document).ready(function() {

        var table = $('.dataTable').dataTable({
    
        "iDisplayLength" : 100,
        dom: 'Bfrtip',
        buttons: [
                'copy', 'csv', 'excel', 'print'
            ]        
    
  });
<?php $this->Html->scriptEnd();