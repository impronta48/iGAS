<div class="provenienzesoldi index">
	<h2><?php echo __('Banche, Carte e Conti'); ?></h2>
	<?php echo $this->Html->link(__('New Provenienzasoldi'), ['action' => 'add'], ['class'=>'btn btn-primary']); ?>
	<table class="table table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('ModoPagamento'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($provenienzesoldi as $provenienzasoldi): ?>
	<tr>
		<td><?php echo h($provenienzasoldi['Provenienzasoldi']['id']); ?>&nbsp;</td>
		<td><?php echo h($provenienzasoldi['Provenienzasoldi']['ModoPagamento']); ?>&nbsp;</td>
		<td><?php echo h($provenienzasoldi['Provenienzasoldi']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), ['action' => 'view', $provenienzasoldi['Provenienzasoldi']['id']]); ?>
			<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $provenienzasoldi['Provenienzasoldi']['id']]); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $provenienzasoldi['Provenienzasoldi']['id']], [], __('Are you sure you want to delete # %s?', $provenienzasoldi['Provenienzasoldi']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter([
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	]);
	?>	
	</p>
	<?php echo $this->Paginator->pagination([
		'ul' => 'pagination'
	]); ?>
</div>
