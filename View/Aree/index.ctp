<div class="aree index">
	<h2><?php echo __('Aree');?></h2>
     <div class="actions">
        <a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url(['action' => 'add']) ?>">Nuova Area</a>
    </div> 
	<table class="table table-bordered table-hover table-striped display">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($aree as $area):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $area['Area']['id']; ?>&nbsp;</td>
		<td><?php echo $area['Area']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Avanzamento'), '/attivita/avanzamento_gen/area:' . $area['Area']['id']); ?>
			<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $area['Area']['id']]); ?>
			<?php echo $this->Html->link(__('Delete'), ['action' => 'delete', $area['Area']['id']], null, sprintf(__('Are you sure you want to delete # %s?'), $area['Area']['id'])); ?>			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter([
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total')
	]);
	?>	</p>

	<?php echo $this->Paginator->pagination([
	'ul' => 'pagination'
]); ?>
</div>
