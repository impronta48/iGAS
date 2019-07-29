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
</div>

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
    if(!empty($a) or !empty($p)){
        echo $this->Html->tag('span', __('Il filtro avviene solo in visualizzazione! Gli XLS esportati comprenderanno comunque tutti i contatti per l\'anno scelto!'), array('class' => 'badge bg-info')); 
    }
?>

<h2>Caricamento fogli ore</h2>

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
                    $this->Html->link('<i class="fa fa-download"></i> Foglio Presenze',array('controller'=>'persone','action'=>'consulente', $this->request->pass[0], $i, $p['Id']),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Foglio presenze per il consulente del lavoro')) . ' ' .
                    $this->Html->link('<i class="fa fa-download"></i> Report Ore-Attivit&agrave;',array('controller'=>'persone','action'=>'report', $this->request->pass[0], $i, $p['Id']),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Scarica il Report Ore-Attivit&agrave;')) . ' ' .
					$this->Html->link('<i class="fa fa-download"></i> Report Ore-Fasi',array('controller'=>'persone','action'=>'report_fasi', $this->request->pass[0], $i, $p['Id']),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Scarica il Report Ore-Fasi'))
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