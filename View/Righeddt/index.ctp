<div class="righeddt index">
	<h2><?php echo __('Righeddt'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('ddt_id'); ?></th>
			<th><?php echo $this->Paginator->sort('Descrizione'); ?></th>
			<th><?php echo $this->Paginator->sort('qta'); ?></th>
			<th><?php echo $this->Paginator->sort('um'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($righeddt as $rigaddt): ?>
	<tr>
		<td><?php echo h($rigaddt['Rigaddt']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($rigaddt['Ddt']['id'], array('controller' => 'ddt', 'action' => 'view', $rigaddt['Ddt']['id'])); ?>
		</td>
		<td><?php echo h($rigaddt['Rigaddt']['Descrizione']); ?>&nbsp;</td>
		<td><?php echo h($rigaddt['Rigaddt']['qta']); ?>&nbsp;</td>
		<td><?php echo h($rigaddt['Rigaddt']['um']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $rigaddt['Rigaddt']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $rigaddt['Rigaddt']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $rigaddt['Rigaddt']['id']), null, __('Are you sure you want to delete # %s?', $rigaddt['Rigaddt']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Rigaddt'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Ddt'), array('controller' => 'ddt', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ddt'), array('controller' => 'ddt', 'action' => 'add')); ?> </li>
	</ul>
</div>
