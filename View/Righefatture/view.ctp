<div class="righefatture view">
<h2><?php echo __('Rigafattura');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rigafattura['Rigafattura']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Fattura Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rigafattura['Rigafattura']['fattura_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('DescrizioneVoci'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rigafattura['Rigafattura']['DescrizioneVoci']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ordine'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rigafattura['Rigafattura']['Ordine']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Importo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rigafattura['Rigafattura']['Importo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Codiceiva Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rigafattura['Rigafattura']['codiceiva_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rigafattura'), ['action' => 'edit', $rigafattura['Rigafattura']['id']]); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Rigafattura'), ['action' => 'delete', $rigafattura['Rigafattura']['id']], null, sprintf(__('Are you sure you want to delete # %s?'), $rigafattura['Rigafattura']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Righefatture'), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Rigafattura'), ['action' => 'add']); ?> </li>
	</ul>
</div>
