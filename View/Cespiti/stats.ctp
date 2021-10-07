<?php $baseformclass = ' form-control'; ?> 
<?php
    $f = (isset($this->request->query['from'])) ? $this->request->query['from'] : '';
    $t = (isset($this->request->query['to']) and $this->request->query['to']!='' and $this->request->query['to']!=null) ? $this->request->query['to'] : date('Y-m-d');
    $c = (isset($this->request->query['cespite_id'])) ? $this->request->query['cespite_id'] : '';
    $a = (isset($this->request->query['attivita'])) ? $this->request->query['attivita'] : '';
    $fa = (isset($this->request->query['faseattivita_id'])) ? $this->request->query['faseattivita_id'] : '';
    //$p = (isset($this->request->query['persone'])) ? $this->request->query['persone'] : '';     
?>

<div class="ore form">
<h2>Statistiche utilizzo cespiti</h2>

<?php echo $this->Form->create('Cespite', array('id' => 'stats-form','type' => 'get',
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

    <?php echo $this->Form->input('cespite_id', array('label'=>'Cespite', 'multiple'=>true,'class'=>'chosen-select'. $baseformclass, 'options'=>$cespiti_list, 'value'=>$c, 'data-placeholder'=>'Filtra per nome cespite')); ?>
    <?php echo $this->Form->input('attivita', array('label'=>'Attività', 'multiple'=>true,'class'=>'chosen-select'. $baseformclass, 'options'=>$attivita_list, 'value'=>$a, 'data-placeholder'=>'Filtra per Attività')); ?>
    <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'multiple'=>true, 'options'=>$faseattivita,
                                    'class'=>'fase chosen-select' . $baseformclass, 'value'=>$fa,
                                    'data-placeholder'=>'Filtra per Fasi Attività'
                                )); ?> 

    <?php //echo $this->Form->input('persone', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$persona_list, 'value'=>$p)); ?>
    
    <?php echo $this->Form->input('from', array('label' => 'Data inizio maggiore di', 'id' => 'from', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>($f?$f:null),
                                        'default'=>date('Y-m-d', strtotime('first day of last month')),
                                        'class' => 'input-sm'. $baseformclass,
                                        'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Mostra solo gli eventi che hanno data di inizio maggiore')); ?>
    <?php echo $this->Form->input('to', array('label' => 'Data inizio minore di', 'id' => 'to', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>($t?$t:null),
                                        'default'=>date('Y-m-d'),
                                        'class' => 'input-sm'. $baseformclass)); ?>

    <?php echo $this->Form->submit(__('Filtra i Risultati'), array('class'=>'col-md-offset-2 btn btn-primary')); ?>
    <?php echo $this->Form->end(); ?>

    <?php if(isset($searchResult)):?>
    <div class="well row">
    <h4>Totali di utilizzo secondo i criteri di ricerca dal <?php echo $f; ?> al <?php echo $t; ?>:</h4>
    <ul>
    <?php foreach ($finalReport as $cespiteId => $cespiteReport): ?>
        <li>
        <?php echo $this->Html->link($cespiteReport['nomeCespite'], array('controller'=>'cespiti','action'=>'edit', $cespiteId)); ?>
        usato in 
        <?php echo $cespiteReport['numeroEventi']; ?>
        eventi per un totale affitto di 
        <?php echo $cespiteReport['totaleAffitto']; ?>
        Euro
        </li>
    <?php endforeach; ?>
    </ul>
    </div>
    <div class="table-responsive">
        <table class="dataTable table table-bordered table-hover table-striped table-condensed display">
        <thead>
            <tr>
                <th>Nome Cespite</th>
                <th>Data Inizio</th>
                <th>Data Fine</th>
                <th>Prezzo Affitto Evento</th>
                <th>Attività</th>
                <th>Fase</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($searchResult as $key => $value):?>
            <tr>
                <?php //debug($value); ?>
                <td><?php echo $value['Cespite']['DisplayName']; ?></td>
                <td><?php echo $value['Cespitecalendario']['start']; ?></td>
                <td><?php echo $value['Cespitecalendario']['end']; ?></td>
                <td><?php echo $value['Cespitecalendario']['prezzo_affitto']; ?> Euro</td>
                <td><?php echo $value['Attivita']['name']; ?></td>
                <td><?php echo $value['Faseattivita']['Descrizione']; ?></td>
            </tr>       
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr class="bg-info">
            <td></td>
            <td></td>
            <td></td>
            <td class="bg-success">TOTALE: <?php echo $prezzoAffittoTot; ?> Euro</td>
            <td></td>
            <td></td>
            </tr> 
        </tfoot>
        </table>
    </div>
    <?php //debug($searchResult); ?>
    <?php endif; ?>

    <?php echo $this->Html->link(__('Visualizza Calendario'), array('controller'=>'cespiti','action'=>'calendar'), array('class'=>'btn btn-primary')); ?>

    <?php echo $this->Html->link(__('Visualizza Lista Eventi'), array('controller'=>'cespiti','action'=>'eventlist'), array('class'=>'btn btn-primary')); ?>

    <?php echo $this->Html->link(__('Visualizza Lista Cespiti'), array('controller'=>'cespiti','action'=>'index'), array('class'=>'btn btn-primary')); ?>

</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
        $(document).ready(function() {

            var dataTablePagination = true;

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

            $('.dropdown-menu').find('form').click(function (e) {
                e.stopPropagation();
            });

            //data table
            $('.dataTable').dataTable({
                aaSorting: [[1, 'asc']],
                "lengthChange": true,
                "iDisplayLength" : 23,
                "paging" : true,
                dom: "Bfrt<'col-sm-2'l><'col-sm-2'i>p",
                buttons: ['csv', 'pdf', 'print']
            });

        });
<?php $this->Html->scriptEnd();
