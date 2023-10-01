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
		<li><?php echo $this->Html->link(__('Edit Provenienzasoldi'), ['action' => 'edit', $provenienzasoldi['Provenienzasoldi']['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Provenienzasoldi'), ['action' => 'delete', $provenienzasoldi['Provenienzasoldi']['id']], [], __('Are you sure you want to delete # %s?', $provenienzasoldi['Provenienzasoldi']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Provenienzesoldi'), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Provenienzasoldi'), ['action' => 'add']); ?> </li>
		<li><?php echo $this->Html->link(__('List Aziende'), ['controller' => 'aziende', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Azienda'), ['controller' => 'aziende', 'action' => 'add']); ?> </li>
	</ul>
</div>
