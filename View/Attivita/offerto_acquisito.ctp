<h2>Avanzamento Generale <?php echo $tit ?></h2>


<?php echo $this->Form->create('Attivita', [
		'type' => 'get',
    'inputDefaults' => [
		'div' => 'form-group',
		'label' => [
			'class' => 'col col-md-4 control-label'
		],
		'wrapInput' => 'col col-md-8',
		'class' => 'form-control'
	],	
	'class' => 'well form-horizontal'       
    ]); ?>  

	<?= $this->Form->input('nomeattivita',['value'=>$nomeattivita]); ?>
	<?= $this->Form->input('progetto',['selected'=>$progetto, 'options'=>$progetti,'empty'=>'---']); ?>
	<?= $this->Form->input('area',['selected'=>$area, 'options'=>$aree,'empty'=>'---']); ?>
	<?= $this->Form->input('anno',['selected'=>$anno, 'options'=>$anni,'empty'=>'---','label'=>'anno inizio attivita']); ?>
	<?= $this->Form->submit('Filtra'); ?>
<?= $this->Form->end(); ?>

<table class="table table-striped table-fixed">
	<thead>
<tr>
	<th width="15%">Attivita</th>
	<th>Offerto</th>
	<th>Acquisito</th>
	<th>Fatturato</th>
	<th>Incassato</th>
	<th>Da Fatturare</th>
	<th>Da Incassare</th>
</tr>
	</thead>

	<tbody>
<?php 	

	$tot = ['offerto'=>0, 'acquisito' =>0, 'fatturato' =>0, 'incassato' => 0];
	$totArea = ['offerto'=>0, 'acquisito' =>0, 'fatturato' =>0 , 'incassato' => 0];
	
	$lastarea_id = '';
	foreach($offerte as $attivita) : 
		$offerto = 0;
		$acquisito = 0;
		$fatturato = 0;
		$incassato = 0;
	?>
	<?php
		if ($attivita['Attivita']['area_id'] != $lastarea_id)
		{

			if ($lastarea_id != '') {
			echo "<tr class=\"bg-warning\">
					<td class=\"bg-warning\" width=\"30%\">Totale ".$aree[$lastarea_id]."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['offerto'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['acquisito'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['fatturato'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['incassato'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['acquisito']-$totArea['fatturato'])."</td>
					<td class=\"bg-warning\">".$this->Number->currency($totArea['fatturato']-$totArea['incassato'])."</td>
				</tr>
				<tr>
					<td></td>
				</tr>";

				$totArea = ['offerto'=>0, 'acquisito' =>0, 'fatturato' =>0 , 'incassato' => 0];
			}

			echo "<tr><td colspan=\"7\" class=\"bg-info text-white\"><b>";
			echo $aree[$attivita['Attivita']['area_id']]; 
			echo "</b></td></tr>";
		}
	?>
	<?php if ($attivita['Attivita']['ImportoAcquisito']==0) {
					$class='text-warning warning';
			}
			else{
					$class='';
			}
	?>
	<tr class="<?= $class ?>">
		<td>
			<span class="small <?= $class ?>"><?php echo $attivita['Attivita']['name'] ?> </span>
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
                    <?php echo $this->Html->link(__('Avanzamento'), ['controller'=>'attivita', 'action' => 'avanzamento', $attivita['Attivita']['id']]); ?>
                  </li>
                  <li class="">
                    <?php echo $this->Html->link(__('Ore'), ['controller'=>'ore','action'=>'stats', '?' => ['as_values_attivita'=>$attivita['Attivita']['id']. ","] ]); ?>
                  </li>
                  <li class="">
                    <?php echo $this->Html->link(__('Fasi'), ['controller'=>'faseattivita', 'action' => 'index', $attivita['Attivita']['id']]); ?>
                  </li>
                  <li class="">
                    <?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $attivita['Attivita']['id']]); ?>
                  </li>
                </ul>
              </div>
		</td>
		<td class="<?= $class ?>"><?php if (isset($attivita['Attivita']['OffertaAlCliente']))
					{
						$offerto = $attivita['Attivita']['OffertaAlCliente']; 						
						$tot['offerto'] += $offerto;
						$totArea['offerto'] += $offerto;
					}
					echo $this->Number->currency($offerto); 
			?>
		</td>
		<td><?php if (isset($attivita['Attivita']['ImportoAcquisito']))
					{
						$acquisito = $attivita['Attivita']['ImportoAcquisito']; 						
						$tot['acquisito'] += $acquisito;
						$totArea['acquisito'] += $acquisito;
					}
					echo $this->Number->currency($acquisito); 
				
			?>
		</td>
		<td>
		
				<?php				
				if (isset($attivita['Attivita']['fatturato']))
				{
					$fatturato = $attivita['Attivita']['fatturato'];
					
					$tot['fatturato'] += $fatturato;
					$totArea['fatturato'] += $fatturato;
				}
					echo $this->Number->currency($fatturato); 
				?>
				
		</td>
		<td>
				<?php if (isset($attivita['Attivita']['incassato']))
				{
					$incassato = $attivita['Attivita']['incassato'];
					$tot['incassato'] += $incassato;
					$totArea['incassato'] += $incassato;
				}
					echo $this->Number->currency($incassato); 
				
				?>		
		</td>
		<td><?php 
						echo $this->Number->currency($acquisito - $fatturato); 
			?>
		</td>

		<td>
			<?php 
						echo $this->Number->currency($fatturato - $incassato);
			?>
		</td>

	</tr>
	<?php $lastarea_id = $attivita['Attivita']['area_id']; ?>
<?php endforeach; ?>
			</tbody>
<tfoot>
<tr class="bg-success">
	<td class="bg-success" width="30%">Totale</td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['offerto']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['acquisito']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['fatturato']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['incassato']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['acquisito'] - $tot['fatturato']) ?> </td>
	<td class="bg-success"><?php echo $this->Number->currency($tot['fatturato'] - $tot['incassato']) ?> </td>	
</tr>
<tr>
	<th width="15%">Attivita</th>
	<th>Offerto</th>
	<th>Acquisito</th>
	<th>Fatturato</th>
	<th>Incassato</th>
	<th>Da Fatturare</th>
	<th>Da Incassare</th>
</tr>
</tfoot>
</table>
