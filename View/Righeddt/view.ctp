<div class="righeddt view">
<h2><?php echo __('Rigaddt'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($rigaddt['Rigaddt']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ddt'); ?></dt>
		<dd>
			<?php echo $this->Html->link($rigaddt['Ddt']['id'], array('controller' => 'ddt', 'action' => 'view', $rigaddt['Ddt']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descrizione'); ?></dt>
		<dd>
			<?php echo h($rigaddt['Rigaddt']['Descrizione']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Qta'); ?></dt>
		<dd>
			<?php echo h($rigaddt['Rigaddt']['qta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Um'); ?></dt>
		<dd>
			<?php echo h($rigaddt['Rigaddt']['um']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rigaddt'), array('action' => 'edit', $rigaddt['Rigaddt']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Rigaddt'), array('action' => 'delete', $rigaddt['Rigaddt']['id']), null, __('Are you sure you want to delete # %s?', $rigaddt['Rigaddt']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Righeddt'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rigaddt'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ddt'), array('controller' => 'ddt', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ddt'), array('controller' => 'ddt', 'action' => 'add')); ?> </li>
	</ul>
</div>
