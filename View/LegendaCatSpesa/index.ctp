<div class="legendaCatSpesas index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Legenda Categorie di Spesa'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

    <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Nuova Cat Spesa'), array('action' => 'add'), array('escape' => false, 'class'=>'btn btn-primary')); ?></li>

			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th nowrap><?php echo $this->Paginator->sort('id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('voceNotaSpesa'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('name'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($legendaCatSpesas as $legendaCatSpesa): ?>
					<tr>
						<td nowrap><?php echo h($legendaCatSpesa['LegendaCatSpesa']['id']); ?>&nbsp;</td>
						<td nowrap><?php echo h($legendaCatSpesa['LegendaCatSpesa']['voceNotaSpesa']); ?>&nbsp;</td>
						<td nowrap><?php echo h($legendaCatSpesa['LegendaCatSpesa']['name']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $legendaCatSpesa['LegendaCatSpesa']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $legendaCatSpesa['LegendaCatSpesa']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $legendaCatSpesa['LegendaCatSpesa']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $legendaCatSpesa['LegendaCatSpesa']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<p>
				<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));
					echo $this->Paginator->next('Next &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
				?>
			</ul>
			<?php } ?>

</div><!-- end containing of content -->