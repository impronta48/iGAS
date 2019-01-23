<div class="progetti view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Progetto'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Progetto'), array('action' => 'edit', $progetto['Progetto']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Progetto'), array('action' => 'delete', $progetto['Progetto']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $progetto['Progetto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Progetti'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Progetto'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Aree'), array('controller' => 'aree', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Area'), array('controller' => 'aree', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Attivita'), array('controller' => 'attivita', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Attivita'), array('controller' => 'attivita', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($progetto['Progetto']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Name'); ?></th>
		<td>
			<?php echo h($progetto['Progetto']['name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('DescrizioneProgetto'); ?></th>
		<td>
			<?php echo h($progetto['Progetto']['DescrizioneProgetto']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Area'); ?></th>
		<td>
			<?php echo $this->Html->link($progetto['Area']['name'], array('controller' => 'aree', 'action' => 'view', $progetto['Area']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('PercentualeIVA'); ?></th>
		<td>
			<?php echo h($progetto['Progetto']['PercentualeIVA']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Nota'); ?></th>
		<td>
			<?php echo h($progetto['Progetto']['Nota']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Attivita'); ?></h3>
	<?php if (!empty($progetto['Attivita'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Progetto Id'); ?></th>
		<th><?php echo __('Cliente Id'); ?></th>
		<th><?php echo __('DataPresentazione'); ?></th>
		<th><?php echo __('DataApprovazione'); ?></th>
		<th><?php echo __('DataInizio'); ?></th>
		<th><?php echo __('DataFine'); ?></th>
		<th><?php echo __('DataFinePrevista'); ?></th>
		<th><?php echo __('NumOre'); ?></th>
		<th><?php echo __('NumOreConsuntivo'); ?></th>
		<th><?php echo __('OffertaAlCliente'); ?></th>
		<th><?php echo __('ImportoAcquisito'); ?></th>
		<th><?php echo __('NettoOra'); ?></th>
		<th><?php echo __('OreUfficio'); ?></th>
		<th><?php echo __('MotivazioneRit'); ?></th>
		<th><?php echo __('Utile'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th><?php echo __('Area Id'); ?></th>
		<th><?php echo __('Azienda Id'); ?></th>
		<th><?php echo __('Chiusa'); ?></th>
		<th><?php echo __('Alias'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($progetto['Attivita'] as $attivita): ?>
		<tr>
			<td><?php echo $attivita['id']; ?></td>
			<td><?php echo $attivita['name']; ?></td>
			<td><?php echo $attivita['progetto_id']; ?></td>
			<td><?php echo $attivita['cliente_id']; ?></td>
			<td><?php echo $attivita['DataPresentazione']; ?></td>
			<td><?php echo $attivita['DataApprovazione']; ?></td>
			<td><?php echo $attivita['DataInizio']; ?></td>
			<td><?php echo $attivita['DataFine']; ?></td>
			<td><?php echo $attivita['DataFinePrevista']; ?></td>
			<td><?php echo $attivita['NumOre']; ?></td>
			<td><?php echo $attivita['NumOreConsuntivo']; ?></td>
			<td><?php echo $attivita['OffertaAlCliente']; ?></td>
			<td><?php echo $attivita['ImportoAcquisito']; ?></td>
			<td><?php echo $attivita['NettoOra']; ?></td>
			<td><?php echo $attivita['OreUfficio']; ?></td>
			<td><?php echo $attivita['MotivazioneRit']; ?></td>
			<td><?php echo $attivita['Utile']; ?></td>
			<td><?php echo $attivita['Note']; ?></td>
			<td><?php echo $attivita['area_id']; ?></td>
			<td><?php echo $attivita['azienda_id']; ?></td>
			<td><?php echo $attivita['chiusa']; ?></td>
			<td><?php echo $attivita['alias']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'attivita', 'action' => 'view', $attivita['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'attivita', 'action' => 'edit', $attivita['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'attivita', 'action' => 'delete', $attivita['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $attivita['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Attivita'), array('controller' => 'attivita', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
