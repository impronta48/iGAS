<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php $baseformclass = ' form-control'; ?> 
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
<div class="ore form">
    <h2>Statistiche ore</h2>

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
    
    <?php echo $this->Form->input('attivita', array('label' => 'Attività', 'multiple'=>true, 'class'=>'chosen-select'. $baseformclass,'options'=>$attivita_list, 'value'=>$a)); ?>
    <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'multiple'=>true, 'options'=>$faseattivita,
                                    'class'=>'fase chosen-select' . $baseformclass, 'value'=>$fa
                                )); ?> 

    <?php
        if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)){ 
            echo $this->Form->input('persone', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$persona_list, 'value'=>$p));
        } else {
            echo $this->Form->hidden('persone', array('value' => $this->Session->read('Auth.User.persona_id')));
            echo $this->Form->input('personaDisplay_dummy', array('label' => 'Persona', 'value' => $this->Session->read('Auth.User.Persona.DisplayName'), 'Disabled' => true));
        }
    ?>
    
    <?php echo $this->Form->input('from', array('id' => 'from', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>($f?$f:null),
                                        'default'=>date('Y-m-d', strtotime('first day of last month')))); ?>
    <?php echo $this->Form->input('to', array('id' => 'to', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>$t)); ?>
    <?php echo $this->Form->submit(__('Filter'), array('class'=>'col-md-offset-2 btn btn-primary')); ?>
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



    <?php if (isset($result1)): ?>

        <h3><i class="fa fa-arrow-circle-o-right"></i> Totale</h3>
        <i class="fa fa-clock-o"></i> Ore: <?php echo round($result1[0][0]['numOre'], 2); ?>
        <i class="fa fa-calendar-o"></i> Giornate: <?php echo round($result1[0][0]['numOre']/8, 2); ?>
        <?php echo $this->Html->link('Dettaglio',array('action'=>'detail', '?'=>$this->request->query ),array('class'=>'btn btn-xs btn-primary')); ?>
        <?php echo $this->Html->link('Tabella Pivot',array('action'=>'pivot' ),array('class'=>'btn btn-xs btn-primary')); ?>

        <!-- TODO: Aggiungere formattazione dei numeri
        http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html
        -->

        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title"><h3><i class='fa fa-book'></i> Totale Ore per Attivit&agrave;
                <span class="pull-right">            
                  <a href="#" class="panel-minimize"><i class="fa fa-chevron-up"></i></a>
                  <a href="#" class="panel-close"><i class="fa fa-times"></i></a>
                </span>
                </h3>
                </div>
            </div>
            
            <div class="panel-body">
            <div class="table-responsive">
            <table id="ore-attivita" class="table table-hover table-condensed table-striped" cellspacing="1">
            <thead>
                <th class="tablesorter" width="80%">Attivita</th>
                <th class="tablesorter" width="10%">Ore</th>
                <th class="tablesorter" width="10%">Giornate</th>
            </thead>
            <tbody>
                <?php foreach ($result2 as $r): ?>
                <?php                    
                    if (isset($r['Ora']['eAttivita']))
                    {
                        //Aggiungo l'attività selezionata alla querystring
                        $q = $this->request->query;
                        $q['attivita'] =$r['Ora']['eAttivita'];

                        echo $this->Html->tableCells(array(
                            array(
                                    $this->Html->link($r['Attivita']['name'],array('action'=>'detail', '?'=>$q)), 
                                    round($r[0]['numOre'], 2), 
                                    round($r[0]['numOre']/8, 
                                    2
                                ))
                                ),
                            array('class' => 'darker'));
                    }
                    ?>
                <?php endforeach; ?>
            </tbody>
            </table> 
            </div>
            </div>
        </div>
        
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title"><h3><i class='fa fa-user'></i> Totale Ore per Risorsa
                <span class="pull-right">            
                  <a href="#" class="panel-minimize"><i class="fa fa-chevron-up"></i></a>
                  <a href="#" class="panel-close"><i class="fa fa-times"></i></a>
                </span>
                </h3>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                <table id="ore-risorsa" class="table table-hover table-condensed table-striped" cellspacing="1" >
                    <thead>
                        <th class="tablesorter" width="80%">Risorsa</th>
                        <th class="tablesorter" width="10%">Ore</th>
                        <th class="tablesorter" width="10%">Giornate</th>
                    </thead>
                <tbody>

                    <?php   foreach ($result3 as $r): ?>
                        <?php

                        //Aggiungo la persona selezionata alla querystring
                        $q = $this->request->query;
                        $q['persone'] =$r['Ora']['eRisorsa'];

                        echo $this->Html->tableCells(array(
                            array(
                                $this->Html->link($r['Persona']['DisplayName'],array('action'=>'detail', '?'=>$q)), 
                                 round($r[0]['numOre'], 2), round($r[0]['numOre']/8, 2))
                                ),
                            array('class' => 'darker'));
                        ?>
                    <?php endforeach; ?>
                </tbody>
                </table>
                </div>         
            </div>
        </div>
        
        
  <div class="panel">
            <div class="panel-heading">
                <div class="panel-title"><h3><i class='fa fa-book'></i><i class='fa fa-user'></i>Totale Ore per Attivit&agrave; e per Risorsa
                <span class="pull-right">            
                  <a href="#" class="panel-minimize"><i class="fa fa-chevron-up"></i></a>
                  <a href="#" class="panel-close"><i class="fa fa-times"></i></a>
                </span>
                </h3>
                </div>
            </div>
            
            <div class="panel-body">
        
            <div class="table-responsive">
            <table id="ore-attivita-risorsa" cellspacing="1" class="table table-striped table-condensed" >
            <thead>
                <th class="tablesorter" width="40%">Attivita</th>
                <th class="tablesorter" width="40%">Risorsa</th>
                <th class="tablesorter" width="10%">Ore</th>
                <th class="tablesorter" width="10%">Giornate</th>
            </thead>                
            <tbody>
                <?php foreach ($result4 as $r): ?>
                    <?php
                        //Aggiungo la persona e l'attività selezionata alla querystring
                        $q = $this->request->query;
                        $q['persone'] =$r['Ora']['eRisorsa'];
                        $q['attivita'] =$r['Ora']['eAttivita'];
                        
                        echo $this->Html->tableCells(array(
                        array($this->Html->link($r['Attivita']['name'],array('action'=>'detail', '?'=>$q)), 
                             $r['Persona']['DisplayName'], round($r[0]['numOre'], 2), round($r[0]['numOre']/8, 2))
                            ),
                        array('class' => 'darker'));
                    ?>
                 <?php endforeach; ?>
            </tbody>
            </table>
            </div>
            </div>
        </div>                
    <?php endif; ?>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
        $(document).ready(function() {

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
<?php $this->Html->scriptEnd(); ?>