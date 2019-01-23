<div class="legendaTipiImpiegatis view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Legenda Tipi Impiegati'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Legenda Tipi Impiegati'), array('action' => 'edit', $legendaTipiImpiegati['LegendaTipiImpiegati']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Legenda Tipi Impiegati'), array('action' => 'delete', $legendaTipiImpiegati['LegendaTipiImpiegati']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $legendaTipiImpiegati['LegendaTipiImpiegati']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Legenda Tipi Impiegatis'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Legenda Tipi Impiegati'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Impiegati'), array('controller' => 'impiegati', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Impiegato'), array('controller' => 'impiegati', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('TipoImpiegato'); ?></th>
		<td>
			<?php echo h($legendaTipiImpiegati['LegendaTipiImpiegati']['TipoImpiegato']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($legendaTipiImpiegati['LegendaTipiImpiegati']['id']); ?>
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
	<h3><?php echo __('Related Impiegati'); ?></h3>
	<?php if (!empty($legendaTipiImpiegati['Impiegato'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Persona Id'); ?></th>
		<th><?php echo __('TipoImpiegato'); ?></th>
		<th><?php echo __('NumeroAssistenzaSociale'); ?></th>
		<th><?php echo __('NumeroLibrettoDiLavoro'); ?></th>
		<th><?php echo __('DataAssunzione'); ?></th>
		<th><?php echo __('Stipendio'); ?></th>
		<th><?php echo __('LuogoDiNascita'); ?></th>
		<th><?php echo __('CodiceFiscale'); ?></th>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('CostoAziendale'); ?></th>
		<th><?php echo __('Venduto'); ?></th>
		<th><?php echo __('Disattivo'); ?></th>
		<th><?php echo __('DataModifica'); ?></th>
		<th><?php echo __('ModificatoDa'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($legendaTipiImpiegati['Impiegato'] as $impiegato): ?>
		<tr>
			<td><?php echo $impiegato['id']; ?></td>
			<td><?php echo $impiegato['persona_id']; ?></td>
			<td><?php echo $impiegato['TipoImpiegato']; ?></td>
			<td><?php echo $impiegato['NumeroAssistenzaSociale']; ?></td>
			<td><?php echo $impiegato['NumeroLibrettoDiLavoro']; ?></td>
			<td><?php echo $impiegato['DataAssunzione']; ?></td>
			<td><?php echo $impiegato['Stipendio']; ?></td>
			<td><?php echo $impiegato['LuogoDiNascita']; ?></td>
			<td><?php echo $impiegato['CodiceFiscale']; ?></td>
			<td><?php echo $impiegato['username']; ?></td>
			<td><?php echo $impiegato['CostoAziendale']; ?></td>
			<td><?php echo $impiegato['Venduto']; ?></td>
			<td><?php echo $impiegato['Disattivo']; ?></td>
			<td><?php echo $impiegato['DataModifica']; ?></td>
			<td><?php echo $impiegato['ModificatoDa']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'impiegati', 'action' => 'view', $impiegato['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'impiegati', 'action' => 'edit', $impiegato['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'impiegati', 'action' => 'delete', $impiegato['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $impiegato['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Impiegato'), array('controller' => 'impiegati', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
