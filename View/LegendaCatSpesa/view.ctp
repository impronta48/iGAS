<div class="legendaCatSpesas view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Legenda Cat Spesa'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Legenda Cat Spesa'), array('action' => 'edit', $legendaCatSpesa['LegendaCatSpesa']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Legenda Cat Spesa'), array('action' => 'delete', $legendaCatSpesa['LegendaCatSpesa']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $legendaCatSpesa['LegendaCatSpesa']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Legenda Cat Spesas'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Legenda Cat Spesa'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Primanota'), array('controller' => 'primanota', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Primanota'), array('controller' => 'primanota', 'action' => 'add'), array('escape' => false)); ?> </li>
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
			<?php echo h($legendaCatSpesa['LegendaCatSpesa']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Name'); ?></th>
		<td>
			<?php echo h($legendaCatSpesa['LegendaCatSpesa']['name']); ?>
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
	<h3><?php echo __('Related Primanota'); ?></h3>
	<?php if (!empty($legendaCatSpesa['Primanota'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Descr'); ?></th>
		<th><?php echo __('Importo'); ?></th>
		<th><?php echo __('Attivita Id'); ?></th>
		<th><?php echo __('Faseattivita Id'); ?></th>
		<th><?php echo __('Legenda Cat Spesa Id'); ?></th>
		<th><?php echo __('Provenienzasoldi Id'); ?></th>
		<th><?php echo __('Fatturaemessa Id'); ?></th>
		<th><?php echo __('Fatturaricevuta Id'); ?></th>
		<th><?php echo __('Assegno'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th><?php echo __('Num Documento'); ?></th>
		<th><?php echo __('Data Documento'); ?></th>
		<th><?php echo __('Persona Id'); ?></th>
		<th><?php echo __('Persona Descr'); ?></th>
		<th><?php echo __('Imponibile'); ?></th>
		<th><?php echo __('Iva'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($legendaCatSpesa['Primanota'] as $primanota): ?>
		<tr>
			<td><?php echo $primanota['id']; ?></td>
			<td><?php echo $primanota['data']; ?></td>
			<td><?php echo $primanota['descr']; ?></td>
			<td><?php echo $primanota['importo']; ?></td>
			<td><?php echo $primanota['attivita_id']; ?></td>
			<td><?php echo $primanota['faseattivita_id']; ?></td>
			<td><?php echo $primanota['legenda_cat_spesa_id']; ?></td>
			<td><?php echo $primanota['provenienzasoldi_id']; ?></td>
			<td><?php echo $primanota['fatturaemessa_id']; ?></td>
			<td><?php echo $primanota['fatturaricevuta_id']; ?></td>
			<td><?php echo $primanota['assegno']; ?></td>
			<td><?php echo $primanota['note']; ?></td>
			<td><?php echo $primanota['num_documento']; ?></td>
			<td><?php echo $primanota['data_documento']; ?></td>
			<td><?php echo $primanota['persona_id']; ?></td>
			<td><?php echo $primanota['persona_descr']; ?></td>
			<td><?php echo $primanota['imponibile']; ?></td>
			<td><?php echo $primanota['iva']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'primanota', 'action' => 'view', $primanota['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'primanota', 'action' => 'edit', $primanota['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'primanota', 'action' => 'delete', $primanota['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $primanota['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Primanota'), array('controller' => 'primanota', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
