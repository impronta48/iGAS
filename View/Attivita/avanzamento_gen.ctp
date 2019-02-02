<h2>Avanzamento Generale <?php echo $tit ?></h2>

<div class="well">
<?php echo $this->Form->create('Attivita', array(
		'type' => 'get',
    'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-4 control-label'
		),
		'wrapInput' => 'col col-md-8',
		'class' => 'form-control'
	),	
	'class' => 'well form-horizontal'       
    )); ?>  

	<?= $this->Form->input('nomeattivita',['value'=>$nomeattivita]); ?>
	<?= $this->Form->input('progetto',['value'=>$progetto, 'options'=>$progetti,'empty'=>'---']); ?>
	<?= $this->Form->input('area',['value'=>$area, 'options'=>$aree,'empty'=>'---']); ?>
	<?= $this->Form->input('anno',['value'=>$anno, 'options'=>$anni,'empty'=>'---','label'=>'anno inizio attivita']); ?>
	<?= $this->Form->submit('Filtra'); ?>
	<?= $this->Form->end(); ?>
</div>

<table class="table table-striped">
<tr>
	<th width="15%">Attivita</th>
	<th>Preventivo Entrate</th>
	<th>Preventivo Uscite</th>
	<th>Preventivo Avanzo</th>
	<th>Entrate<br><small>Documenti Non Incassati + PrimaNota</small></th>
	<th>Uscite<br><small>Documenti Non Pagati  + PrimaNota</small></th>
	<th>Ore<br><small>non pagate</small></th>
	<th>Note Spese<br><small>non pagate</small></th>	
	<th>Avanzo Effettivo</th>
</tr>
<?php 	

	$tot = array('primanota'=>0, 'preventivoentrate' =>0, 'preventivouscite' =>0, 'pne' =>0, 'pnu' =>0, 'costoore'=>0, 'notespese'=>0, 'avanzo'=>0 ,'docnonincassati' =>0, 'docnonpagati' => 0);
	$totArea = array('primanota'=>0, 'preventivoentrate' =>0, 'preventivouscite' =>0, 'pne' =>0, 'pnu' =>0, 'costoore'=>0, 'notespese'=>0, 'avanzo'=>0 ,'docnonincassati' =>0, 'docnonpagati' => 0);

	$lastarea_id = '';
	foreach($a as $attivita) : 
		$primanota = 0;
		$preventivoentrate = 0;
		$primanotae = 0;
		$primanotau = 0;
		$preventivouscite = 0;
		$costoore = 0;
		$notespese = 0;		
		$docnonpagati = 0;
		$docnonincassati = 0;		
	?>
	<?php
		if ($attivita['Attivita']['area_id'] != $lastarea_id)
		{

			if ($lastarea_id != '') {
			echo "<tr class=\"bg-warning\">
					<td class=\"bg-warning\" width=\"30%\">Totale ".$aree[$attivita['Attivita']['area_id']]."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['preventivoentrate'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['preventivouscite'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['preventivoentrate'] - $totArea['preventivouscite'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['pne'] + $totArea['docnonincassati'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['pnu'] + $totArea['docnonpagati'])."</td>	
					<td class=\"bg-warning\">".$this->Number->currency($totArea['costoore'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['notespese'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['avanzo'])."</td>	
				</tr>
				<tr>
					<td></td>
				</tr>";

			$totArea = array('primanota'=>0, 'preventivoentrate' =>0, 'preventivouscite' =>0, 'pne' =>0, 'pnu' =>0, 'costoore'=>0, 'notespese'=>0, 'avanzo'=>0 ,'docnonincassati' =>0, 'docnonpagati' => 0);
			}

			echo "<tr><td colspan=\"9\" class=\"bg-info text-white\"><b>";
			echo $aree[$attivita['Attivita']['area_id']]; 
			echo "</b></td></tr>";
		}
	?>
	<tr>
		<td><?php echo $attivita['Attivita']['name'] ?>
			<small> 			
			<div class="btn-group settings pull-right">                 
			<?php	$u = $this->Html->url('/attivita/avanzamento/' . $attivita['Attivita']['id'])  ?>
                 <button class="btn btn-primary btn-xs glow" onclick="location.href='<?php echo $u ?>';">
                     <i class="fa fa-euro"></i>                    
                 </button>
                 <button class="btn btn-primary btn-xs  glow dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">
                        Toggle Dropdown
                    </span>
                 </button>
                 <ul class="dropdown-menu" role="menu">
				  <li class="">
                    <?php echo $this->Html->link(__('Avanzamento'), array('controller'=>'attivita', 'action' => 'avanzamento', $attivita['Attivita']['id'])); ?>
                  </li>
                  <li class="">
                    <?php echo $this->Html->link(__('Ore'), array('controller'=>'ore','action'=>'stats', '?' => array('as_values_attivita'=>$attivita['Attivita']['id']. ",") )); ?>
                  </li>
                  <li class="">
                    <?php echo $this->Html->link(__('Fasi'), array('controller'=>'faseattivita', 'action' => 'index', $attivita['Attivita']['id'])); ?>
                  </li>
                  <li class="">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $attivita['Attivita']['id'])); ?>
                  </li>
                </ul>
              </div>
			  
			</small>			
		</td>
		<td><?php if (isset($fentrate[$attivita['Attivita']['id']]))
					{
						$preventivoentrate = $fentrate[$attivita['Attivita']['id']]; 						
						$tot['preventivoentrate'] += $preventivoentrate;
						$totArea['preventivoentrate'] += $preventivoentrate;
					}
					echo $this->Number->currency($preventivoentrate); 
			?>
		</td>
		<td><?php if (isset($fuscite[$attivita['Attivita']['id']]))
					{
						$preventivouscite = $fuscite[$attivita['Attivita']['id']]; 						
						$tot['preventivouscite'] += $preventivouscite;
						$totArea['preventivouscite'] += $preventivouscite;
					}
					echo $this->Number->currency($preventivouscite); 
			?>
		</td>
		<td><?php 
					echo $this->Number->currency($preventivoentrate - $preventivouscite); 
			?>
		</td>

		<td>
			<?php 
					$docricevuti = 0;

					if (isset($pne[$attivita['Attivita']['id']]))
					{	
						$primanotae = $pne[$attivita['Attivita']['id']];
						if (isset($docric[$attivita['Attivita']['id']]))
						{
							$docricevuti = $docric[$attivita['Attivita']['id']];
						}
						$tot['pne'] += $primanotae + $docricevuti;
						$totArea['pne'] += $primanotae + $docricevuti;
					}
					echo $this->Number->currency($primanotae + $docricevuti);
			?>
		</td>

		<td><?php if (isset($pnu[$attivita['Attivita']['id']]))
					{	
						$primanotau = $pnu[$attivita['Attivita']['id']];
						$tot['pnu'] += $primanotau;
						$totArea['pnu'] += $primanotau;
					}
					echo $this->Number->currency($primanotau);
			?>
		</td>

		<td><?php 
					if (isset($ore[$attivita['Attivita']['id']]))
					{
						$costoore = $ore[$attivita['Attivita']['id']]*30; 
						$tot['costoore'] += $costoore;
						$totArea['costoore'] += $costoore;
					}
					echo $this->Number->currency($costoore);
			?>
		</td>	
		<td>
			<?php 
					if (isset($ns[$attivita['Attivita']['id']]))
					{
						$notespese = $ns[$attivita['Attivita']['id']]; 
						$tot['notespese'] += $notespese;
						$totArea['notespese'] += $notespese;
					}					
					echo $this->Number->currency($notespese); 
			?>		
		</td>
		
		
		<td><?php 
				echo $this->Number->currency($primanotae - $costoore - $notespese + $primanotau);
				$tot['avanzo'] += $primanotae - $costoore - $notespese + $primanotau;
				$totArea['avanzo'] += $primanotae - $costoore - $notespese + $primanotau;
			?>
		</td>
	</tr>
	<?php $lastarea_id = $attivita['Attivita']['area_id']; ?>
<?php endforeach; ?>
<tfoot>
<tr class="bg-success">
	<td class="bg-success" width="30%">Totale</td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['preventivoentrate']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['preventivouscite']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['preventivoentrate'] - $tot['preventivouscite']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['pne'] + $tot['docnonincassati']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['pnu'] + $tot['docnonpagati']) ?> </td>	
	<td class="bg-success"><?php echo $this->Number->currency($tot['costoore']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['notespese']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['avanzo']) ?> </td>	
</tr>
</tfoot>
</table>
