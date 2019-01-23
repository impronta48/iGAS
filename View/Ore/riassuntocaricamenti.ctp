<div class="ore view">
        <b>Scegli l'anno: </b>
        <?php
        $anni = Configure::read('Fattureemesse.anni');

        $condition['controller'] = 'ore';
        $condition['action'] = 'riassuntocaricamenti';
        for ($i = date('Y') - $anni; $i <= date('Y'); $i++) {
            $condition[3] = $i;
        ?>
    <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url($condition) ?>"><?php echo $i ?></a>
        <?php
        }
        ?>
</div>

<h2>Caricamento fogli ore</h2>

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
                    $this->Html->link('<i class="fa fa-download"></i> Foglio Presenze',array('controller'=>'persone','action'=>'consulente', $this->request->pass[0], $i),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Foglio presenze per il consulente del lavoro')) . ' ' .
                    $this->Html->link('<i class="fa fa-download"></i> Report Ore-Attivit&agrave;',array('controller'=>'persone','action'=>'report', $this->request->pass[0], $i),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Scarica il Report Ore-Attivit&agrave;')) . ' ' .
					$this->Html->link('<i class="fa fa-download"></i> Report Ore-Fasi',array('controller'=>'persone','action'=>'report_fasi', $this->request->pass[0], $i),array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Scarica il Report Ore-Fasi'))
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