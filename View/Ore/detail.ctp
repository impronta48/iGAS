<?php echo $this->Html->script("ora",array('inline' => false)); ?>
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
    <h2>Dettaglio ore</h2>

    <div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					Azioni <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a class="fattura" href="#" id="fattura"><i class="fa fa-envelope"></i> Considera Fatturate al cliente</a></li>
					<li><a class="paga" href="#" id="set"><i class="fa fa-euro"></i> Aggiunti Pagato alle ore</a></li>
					<li><a class="paga" href="#" id="remove"><i class="fa fa-euro"></i> Rimuovi Pagato dalle ore</a></li>
					<li><a class="stampa" href="#" id="report"><i class="fa fa-euro"></i> Genera report per il cliente</a></li>
				</ul>
	</div>

  <p></p>
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
<?php echo $this->Form->create('Ora', array('id' => 'stats-form','type' => 'get',
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

    <?php echo $this->Form->input('attivita', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$attivita_list, 'value'=>$a)); ?>
    <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'multiple'=>true, 'options'=>$faseattivita,
                                    'class'=>'fase chosen-select' . $baseformclass, 'value'=>$fa
                                )); ?>

    <?php echo $this->Form->input('persone', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$persona_list, 'value'=>$p)); ?>

    <?php echo $this->Form->input('from', array('id' => 'from', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>$f, 'class'=> 'datepicker form-control',
                                  'default'=>date('Y-m-d', strtotime('first day of last month')))); ?>
    <?php echo $this->Form->input('to', array('id' => 'to', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>$t, 'class'=> 'datepicker form-control',)); ?>
    <?php echo $this->Form->submit(__('Filter'), array('class'=>'col-md-offset-2')); ?>
    <?php echo $this->Form->end(); ?>

    <?php

    function get_json_from_list($selected_list, $complete_list) {
        //Converto la lista di id selezionati in un'array json con id, nome
        if (!isset($selected_list)) {
            $selected_list = '';
        };

        $selected_list2array = explode(',', $selected_list);
        $res = array();

        foreach ($selected_list2array as $p) {
            if ($p > 0) {
                $a = new StdClass();
                $a->value = $p;
                $a->name = $complete_list[$p];
                $res[] = $a;
            }
        }
        return json_encode($res);
    }
    ?>



    <?php if (isset($result[0])): ?>
        <h2></h2>


        <h3>Dettaglio Ore</h3>
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
        <table id="ore-attivita" class="table table-bordered table-hover table-striped display dataTable" cellspacing="1">
        <thead>
            <?php echo $this->Html->tableHeaders( array('<input type="checkbox" id="select-all"/>','Stato','Attività','Fase','Risorsa', 'data','ore','gg','Dettagli', 'LuogoTrasferta','Actions'), array('class'=>"tablesorter")) ; ?>
        </thead>
        <tbody>
            <?php $tot = 0 ; foreach ($result as $r): ?>
            <?php
            	//Azioni
            	$act = array(
                            $this->Html->link('Edit',array('action'=>'edit',$r['Ora']['id']),array('class'=>"btn btn-primary btn-xs glow" )) .
                            $this->Html->link('Del',array('action'=>'delete',$r['Ora']['id']),array('class'=>"btn btn-primary btn-xs glow" )),
                            array('class'=>'actions'),
                            );

                $d= new DateTime($r['Ora']['data']);


                echo $this->Html->tableCells(
                    array(
                          $this->Form->checkbox('Ora.'. $r['Ora']['id'] .'.id', array(
                                                     'class' => 'selectable',
                                                     'hiddenField' => false  //non mi serve passare tutti gli zero
                                                  )),
                          $r['Ora']['pagato'],
                          $this->Ore->getAttivitaDetail($r, $attivita_list),
                          substr($r['Faseattivita']['Descrizione'],0,40),
                          $persona_list[$r['Ora']['eRisorsa']],
                          $d->format('Y-m-d'),
                          $this->Ore->getOraDetail($r),
                          $r['Ora']['numOre']/8,
                          $r['Ora']['dettagliAttivita'],
                          $this->Ore->getLuogoDetail($r),
                          $act,
                      ),
                    array('class' => 'darker'));
                    $tot +=  $r['Ora']['numOre'];
                ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
              <?php
                echo $this->Html->tableCells(
                    array('',
                          'Totale',
                          '',
                          '',
                          '',
						              '',
                          $tot,
                          $tot/8,
                          '',
                          '',
                          '',
                      ),
                    array('class' => 'bg-info'));
                ?>
        </tfoot>
        </table>
        <?php echo $this->Form->end(); ?>


    <?php endif; ?>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>


$(document).ready(function() {
  $('document').ready(function(){
  	//data table
  	$('.dataTable').dataTable({
          "iDisplayLength" : 100,
          dom: 'Bfrtip',
          buttons: [
                  'copy', 'csv','print'
              ]
  	});
});


<?php $this->Html->scriptEnd();