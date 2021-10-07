<div class="provenienzesoldi view">
<h2><?php echo __('Provenienzasoldi'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($provenienzasoldi['Provenienzasoldi']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ModoPagamento'); ?></dt>
		<dd>
			<?php echo h($provenienzasoldi['Provenienzasoldi']['ModoPagamento']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($provenienzasoldi['Provenienzasoldi']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Provenienzasoldi'), array('action' => 'edit', $provenienzasoldi['Provenienzasoldi']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Provenienzasoldi'), array('action' => 'delete', $provenienzasoldi['Provenienzasoldi']['id']), array(), __('Are you sure you want to delete # %s?', $provenienzasoldi['Provenienzasoldi']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Provenienzesoldi'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Provenienzasoldi'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Aziende'), array('controller' => 'aziende', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Azienda'), array('controller' => 'aziende', 'action' => 'add')); ?> </li>
	</ul>
</div>
