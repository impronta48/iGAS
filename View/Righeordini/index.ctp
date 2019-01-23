<div class="righeordini index">
	<h2><?php echo __('Righeordini'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('ordine_id'); ?></th>
			<th><?php echo $this->Paginator->sort('Descrizione'); ?></th>
			<th><?php echo $this->Paginator->sort('qta'); ?></th>
			<th><?php echo $this->Paginator->sort('um'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($righeordini as $rigaordine): ?>
	<tr>
		<td><?php echo h($rigaordine['Rigaordine']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($rigaordine['Ordine']['id'], array('controller' => 'ordini', 'action' => 'view', $rigaordine['Ordine']['id'])); ?>
		</td>
		<td><?php echo h($rigaordine['Rigaordine']['Descrizione']); ?>&nbsp;</td>
		<td><?php echo h($rigaordine['Rigaordine']['qta']); ?>&nbsp;</td>
		<td><?php echo h($rigaordine['Rigaordine']['um']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $rigaordine['Rigaordine']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $rigaordine['Rigaordine']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $rigaordine['Rigaordine']['id']), null, __('Are you sure you want to delete # %s?', $rigaordine['Rigaordine']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Rigaordine'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Ordini'), array('controller' => 'ordini', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ordine'), array('controller' => 'ordini', 'action' => 'add')); ?> </li>
	</ul>
</div>
