<div class="righeordini view">
<h2><?php echo __('Rigaordine'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($rigaordine['Rigaordine']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ordine'); ?></dt>
		<dd>
			<?php echo $this->Html->link($rigaordine['Ordine']['id'], array('controller' => 'ordini', 'action' => 'view', $rigaordine['Ordine']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descrizione'); ?></dt>
		<dd>
			<?php echo h($rigaordine['Rigaordine']['Descrizione']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Qta'); ?></dt>
		<dd>
			<?php echo h($rigaordine['Rigaordine']['qta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Um'); ?></dt>
		<dd>
			<?php echo h($rigaordine['Rigaordine']['um']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rigaordine'), array('action' => 'edit', $rigaordine['Rigaordine']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Rigaordine'), array('action' => 'delete', $rigaordine['Rigaordine']['id']), null, __('Are you sure you want to delete # %s?', $rigaordine['Rigaordine']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Righeordini'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rigaordine'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ordini'), array('controller' => 'ordini', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ordine'), array('controller' => 'ordini', 'action' => 'add')); ?> </li>
	</ul>
</div>
