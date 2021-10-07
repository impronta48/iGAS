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
<h2>Statistiche nota spese</h2>

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


     <?php echo $this->Form->input('attivita', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$attivita_list, 'value'=>$a)); ?>
    <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'multiple'=>true, 'options'=>$faseattivita,
                                    'class'=>'fase chosen-select' . $baseformclass, 'value'=>$fa
                                )); ?> 

    <?php echo $this->Form->input('persone', array('multiple'=>true,'class'=>'chosen-select'. $baseformclass,'options'=>$persona_list, 'value'=>$p)); ?>
    
    <?php echo $this->Form->input('from', array('id' => 'from', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>($f?$f:null), 'class'=> 'datepicker form-control',
                                        'default'=>date('Y-m-d', strtotime('first day of last month')))); ?>
    <?php echo $this->Form->input('to', array('id' => 'to', 'type' => 'text', 'date-format' => 'Y-m-d','value'=>$t, 'class'=> 'datepicker form-control',)); ?>

    <?php echo $this->Form->submit(__('Filtra i Risultati'), array('class'=>'col-md-offset-2')); ?>
    <?php echo $this->Form->end(); ?>


<?php if(isset($result1)):?>

	<h3>Importo Totale</h3>
	<?php echo $this->Number->currency($result1[0][0]['importo'],'EUR');?>
    <?php echo $this->Html->link('Dettaglio',array('action'=>'detail', '?'=>$this->request->query ),array('class'=>'btn btn-xs btn-primary')); ?>

	<br><br>

    <div class="panel">
         <div class="panel-heading">
             <div class="panel-title"><h3><i class='fa fa-book'></i> Totale Note Spese per Attivit&agrave;
             <span class="pull-right">
               <a href="#" class="panel-minimize"><i class="fa fa-chevron-up"></i></a>
               <a href="#" class="panel-close"><i class="fa fa-times"></i></a>
             </span>
             </h3>
             </div>
         </div>

         <div class="panel-body">
         <div class="table-responsive">
         <table id="notaspese-attivita" class="table table-hover table-condensed table-striped" cellspacing="1">
		<tr><th>Attivit&agrave;</th><th>Importo</th></tr>
	<?php foreach($result2 as $r):?>
		<tr>
            <?php
            //Aggiungo l'attività selezionata alla querystring
            $q = $this->request->query;
            $q['attivita'] =$r['Notaspesa']['eAttivita'];
            ?>
            <td width="60%">
                <?php echo $this->Html->link($r['Attivita']['name'],array('action'=>'detail', '?'=>$q));?>
            </td>
            <td><?php echo $this->Number->currency($r[0]['importo'],'EUR');?></td>
        </tr>
	<?php endforeach;?>
	</table>

	<br><br>

  <div class="panel">
    <div class="panel-heading">
        <div class="panel-title"><h3><i class='fa fa-user'></i> Totale NoteSpese per Risorsa
        <span class="pull-right">
          <a href="#" class="panel-minimize"><i class="fa fa-chevron-up"></i></a>
          <a href="#" class="panel-close"><i class="fa fa-times"></i></a>
        </span>
        </h3>
        </div>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table id="notaspese-risorsa" class="table table-hover table-striped" >
    <tr><th>Risorsa</th><th>Importo</th></tr>
	<?php foreach($result3 as $r):?>
		<tr>
            <?php
            //Aggiungo la persona selezionata alla querystring
            $q = $this->request->query;
            $q['persone'] =$r['Notaspesa']['eRisorsa'];
            ?>

            <td width="60%">
                <?php echo $this->Html->link($r['Persona']['DisplayName'],array('action'=>'detail', '?'=>$q));?>
            </td>
            <td><?php echo $this->Number->currency($r[0]['importo'],'EUR');?></td>
        </tr>
	<?php endforeach;?>
	</table>

	<br><br>

	 <div class="panel">
    <div class="panel-heading">
        <div class="panel-title"><h3><i class='fa fa-book'></i><i class='fa fa-user'></i>Totale NoteSpese per Attivit&agrave; e per Risorsa
        <span class="pull-right">
          <a href="#" class="panel-minimize"><i class="fa fa-chevron-up"></i></a>
          <a href="#" class="panel-close"><i class="fa fa-times"></i></a>
        </span>
        </h3>
        </div>
    </div>

    <div class="panel-body">

    <div class="table-responsive">
    <table id="notaspese-attivita-risorsa" cellspacing="1" class="table table-striped table-condensed" >
		<tr><th>Attivit&agrave;</th><th>Risorsa</th><th>Importo</th></tr>
	<?php foreach($result4 as $r):?>
		<tr><td width="30%"><?php echo $attivita_list[ $r['Notaspesa']['eAttivita'] ];?></td>
           <?php
                //Aggiungo la persona e l'attività selezionata alla querystring
                $q = $this->request->query;
                $q['persone'] =$r['Notaspesa']['eRisorsa'];
                $q['attivita'] =$r['Notaspesa']['eAttivita'];                
            ?>
            <td width="30%"><?php echo $this->Html->link($r['Attivita']['name'],array('action'=>'detail', '?'=>$q)) ;?></td>
            <td><?php echo $this->Number->currency($r[0]['importo'],'EUR');?></td></tr>
	<?php endforeach;?>
	</table>

<?php endif;?>
</div>
