<?php $baseformclass = ' form-control'; ?> 
<?php
    $f = (isset($this->request->query['from'])) ? $this->request->query['from'] : '';
    $t = (isset($this->request->query['to'])) ? $this->request->query['to'] : '';
    $a = (isset($this->request->query['attivita'])) ? $this->request->query['attivita'] : '';
    $fa = (isset($this->request->query['faseattivita_id'])) ? $this->request->query['faseattivita_id'] : '';
    $p = (isset($this->request->query['persone'])) ? $this->request->query['persone'] : '';     
?>

<div class="ore form">
<h2>Statistiche utilizzo cespiti</h2>

<?php echo $this->Form->create('Notaspesa', array('id' => 'stats-form','type' => 'get',
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal row'
    )); ?>


    <?php echo $this->Form->input('attivita', array('label'=>'Attività', 'multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$attivita_list, 'value'=>$a)); ?>
    <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'multiple'=>true, 'options'=>$faseattivita,
                                    'class'=>'fase chosen-select' . $baseformclass, 'value'=>$fa
                                )); ?> 

    <?php //echo $this->Form->input('persone', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$persona_list, 'value'=>$p)); ?>
    
    <?php echo $this->Form->input('from', array('id' => 'from', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>($f?$f:null),
                                        'default'=>date('Y-m-d', strtotime('first day of last month')),
                                        'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Mostra solo gli eventi che hanno data di inizio maggiore')); ?>
    <?php echo $this->Form->input('to', array('id' => 'to', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>($t?$t:null),
                                        'default'=>date('Y-m-d'))); ?>

    <?php echo $this->Form->submit(__('Filtra i Risultati'), array('class'=>'col-md-offset-2')); ?>
    <?php echo $this->Form->end(); ?>

    <?php if(isset($searchResult)):?>
    <?php foreach($searchResult as $key => $value):?>
        <?php //debug($value); ?>
        <?php echo $value['Cespite']['DisplayName']; ?>
        <?php echo $value['Cespitecalendario']['prezzo_affitto']; ?>
        <?php echo $value['Attivita']['name']; ?>
        <?php echo $value['Faseattivita']['Descrizione']; ?>
        <?php echo BR; ?>
    <?php endforeach; ?>
    <?php //debug($searchResult); ?>
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
<?php $this->Html->scriptEnd();
