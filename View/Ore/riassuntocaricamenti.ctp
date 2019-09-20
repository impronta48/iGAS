<?php 
    // Questo blocco per creare le option dei mesi dovrebbe essere messo in un component
	$mesi[] = array();
	for($i = 1; $i <= 12; $i++) {
        switch($i) {
            case 1:
                $mesi[$i] = 'Gennaio';
                break;
            case 2:
                $mesi[$i] = 'Febbraio';
                break;
            case 3:
                $mesi[$i] = 'Marzo';
                break;
            case 4:
                $mesi[$i] = 'Aprile';
                break;
            case 5:
                $mesi[$i] = 'Maggio';
                break;
            case 6:
                $mesi[$i] = 'Giugno';
                break;
            case 7:
                $mesi[$i] = 'Luglio';
                break;
            case 8:
                $mesi[$i] = 'Agosto';
                break;
            case 9:
                $mesi[$i] = 'Settembre';
                break;
            case 10:
                $mesi[$i] = 'Ottobre';
                break;
            case 11:
                $mesi[$i] = 'Novembre';
                break;
            case 12:
                $mesi[$i] = 'Dicembre';
                break;
        }
        if(date('m') == $i){
            $selectedMonth = $mesi[$i];
        }
    }
?>
<?php 
    $baseformclass = ' form-control'; 
    $p = (isset($this->request->query['persone'])) ? $this->request->query['persone'] : '';
    $a = (isset($this->request->query['attivita'])) ? $this->request->query['attivita'] : '';
?>
<div class="ore well">
    <b>Scegli l'anno: </b>
    <?php
    $anni = Configure::read('Fattureemesse.anni');

    $condition['controller'] = 'ore';
    $condition['action'] = 'riassuntocaricamenti';
    for ($i = date('Y') - $anni; $i <= date('Y'); $i++) {
        $condition[3] = $i;
    ?>
    <a class="btn btn-default btn-xs" href="<?php echo $this->Html->url($condition) ?>"><?php echo $i ?></a>
    <?php
    }
    ?>
    <h4>Seleziona il mese e poi clicca sul report voluto per vedere i riassunti caricamento fogli ore di tutti i dipendenti </h4>
    <?php
    echo $this->Form->input('selectMonth', array('type'=>'select', 'label' => false, 'options' => $mesi, 'default' => date('m'), 'wrapInput' => 'col col-md-3', 'class' => 'form-control', 'autocomplete' => 'off'));
    echo $this->Html->link('<i class="fa fa-download"></i> Foglio Presenze',array('controller'=>'persone','action'=>'consulente', $this->request->pass[0], $currentMonth),array('id' => 'foglioPresenzeTotale', 'class'=>'btn btn-primary', 'escape'=>false, 'title'=>$selectedMonth.' - Foglio presenze per il consulente del lavoro')) . ' ' .
    $this->Html->link('<i class="fa fa-download"></i> Report Ore-Attivit&agrave;',array('controller'=>'persone','action'=>'report', $this->request->pass[0], $currentMonth),array('id' => 'reportOreAttivitaTotale', 'class'=>'btn btn-primary', 'escape'=>false, 'title'=>$selectedMonth.' - Scarica il Report Ore-Attivit&agrave')) . ' ' .
    $this->Html->link('<i class="fa fa-download"></i> Report Ore-Fasi',array('controller'=>'persone','action'=>'report_fasi', $this->request->pass[0], $currentMonth),array('id' => 'reportOreFasiTotale', 'class'=>'btn btn-primary', 'escape'=>false, 'title'=>$selectedMonth.' - Scarica il Report Ore-Fasi'));
    ?>
    <br>
    <br>
</div>

<h2>Filtra i fogli ore</h2>

<?php echo $this->Form->create('RiassuntoCaricamenti', array('id' => 'stats-form','type' => 'get',
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal'
    )); ?>
<?php echo $this->Form->input('persone', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$persona_list, 'value'=>$p)); ?>
<?php echo $this->Form->input('attivita', array('label'=>'Attività', 'multiple'=>true,'class'=>'chosen-select'. $baseformclass, 'options'=>$attivita_list, 'value'=>$a, 'data-placeholder'=>'Filtra per Attività')); ?>
<?php echo $this->Form->submit(__('Filtra i Risultati'), array('class'=>'col-md-offset-2 btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

<?php 
// Questo blocco non è più necessario per il momento perchè ora i report possono essere visualizzati anche per singola Persona
/*
    if(!empty($a) or !empty($p)){
        echo $this->Html->tag('span', __('Il filtro avviene solo in visualizzazione! Gli XLS esportati comprenderanno comunque tutti i contatti per l\'anno scelto!'), array('class' => 'badge bg-info')); 
    }
*/
?>

<h2>Caricamento fogli ore divisi per dipendente</h2>

<?php // debug($conteggi); ?>
<?php foreach ($conteggi as $key => $p) { ?>
<h3>Dipendente <?php echo $key ?></h3>

<table class="table table-striped">
    <thead><?php echo $this->Html->tableHeaders( array('Mese', 'Ore', 'Media ore/gg', 'Azioni') ); ?></thead>
    <tbody>
        <?php for ($i = 1; $i<=12; $i++) { ?>
        <?php if (isset($p[$i])) { ?>
            <tr><?php echo $this->Html->tableCells(array("<strong>$i</strong>", $p[$i],$p[$i] / 20, 
                array(
                    $this->Html->link('<i class="fa fa-upload"></i> Importa Xls',array('controller'=>'ore','action'=>'upload'), array('class'=>'btn btn-info', 'escape'=>false)) . ' ' .
                    $this->Html->link('<i class="fa fa-download"></i> Foglio Presenze',array('controller'=>'persone','action'=>'consulente', $this->request->pass[0], $i, $p['Id']),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>$key.' - Foglio presenze per il consulente del lavoro')) . ' ' .
                    $this->Html->link('<i class="fa fa-download"></i> Report Ore-Attivit&agrave;',array('controller'=>'persone','action'=>'report', $this->request->pass[0], $i, $p['Id']),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Scarica il Report Ore-Attivit&agrave; di '.$key)) . ' ' .
					$this->Html->link('<i class="fa fa-download"></i> Report Ore-Fasi',array('controller'=>'persone','action'=>'report_fasi', $this->request->pass[0], $i, $p['Id']),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Scarica il Report Ore-Fasi di '.$key))
					, 
                    array('class'=>'actions'))
            )); ?></tr>
        <?php } else { ?>
            <tr><?php echo $this->Html->tableCells(array("<strong>$i</strong>", 'Manca','',
                array(
                    $this->Html->link('<i class="fa fa-upload"></i> Importa Xls',array('controller'=>'ore','action'=>'upload'), array('class'=>'btn btn-info', 'escape'=>false)),
                    array('class'=>'actions'))
                )); ?>
            </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table>
<?php } ?>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() {
    $('#selectMonth').on('change', function(sel){
        $('#foglioPresenzeTotale').attr('title', sel.target[$(this).val()-1].text + ' - Foglio presenze per il consulente del lavoro');
        $('#foglioPresenzeTotale').attr('href', $('#foglioPresenzeTotale').attr('href').match(/.*\//) + $(this).val());
        $('#reportOreAttivitaTotale').attr('title', sel.target[$(this).val()-1].text + ' - Scarica il Report Ore-Attivit&agrave');
        $('#reportOreAttivitaTotale').attr('href', $('#reportOreAttivitaTotale').attr('href').match(/.*\//) + $(this).val());
        $('#reportOreFasiTotale').attr('title', sel.target[$(this).val()-1].text + ' - Scarica il Report Ore-Fasi');
        $('#reportOreFasiTotale').attr('href', $('#reportOreFasiTotale').attr('href').match(/.*\//) + $(this).val());
    });
});
<?php $this->Html->scriptEnd(); ?>