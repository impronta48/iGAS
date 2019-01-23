<div class="righefatture index">
	<h2><?php echo __('Righefatture');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('fattura_id');?></th>
			<th><?php echo $this->Paginator->sort('DescrizioneVoci');?></th>
			<th><?php echo $this->Paginator->sort('Ordine');?></th>
			<th><?php echo $this->Paginator->sort('Importo');?></th>
			<th><?php echo $this->Paginator->sort('codiceiva_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($righefatture as $rigafattura):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $rigafattura['Rigafattura']['id']; ?>&nbsp;</td>
		<td><?php echo $rigafattura['Rigafattura']['fattura_id']; ?>&nbsp;</td>
		<td><?php echo $rigafattura['Rigafattura']['DescrizioneVoci']; ?>&nbsp;</td>
		<td><?php echo $rigafattura['Rigafattura']['Ordine']; ?>&nbsp;</td>
		<td><?php echo $rigafattura['Rigafattura']['Importo']; ?>&nbsp;</td>
		<td><?php echo $rigafattura['Rigafattura']['codiceiva_id']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $rigafattura['Rigafattura']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $rigafattura['Rigafattura']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $rigafattura['Rigafattura']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $rigafattura['Rigafattura']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Rigafattura'), array('action' => 'add')); ?></li>
	</ul>
</div>