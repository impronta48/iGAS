<div class="legendaCodiciIvas index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Legenda Codici Ivas'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->



	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Legenda Codici Iva'), ['action' => 'add'], ['escape' => false]); ?></li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th nowrap><?php echo $this->Paginator->sort('id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Percentuale'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Descrizione'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($legendaCodiciIvas as $legendaCodiciIva): ?>
					<tr>
						<td nowrap><?php echo h($legendaCodiciIva['LegendaCodiciIva']['id']); ?>&nbsp;</td>
						<td nowrap><?php echo h($legendaCodiciIva['LegendaCodiciIva']['Percentuale']); ?>&nbsp;</td>
						<td nowrap><?php echo h($legendaCodiciIva['LegendaCodiciIva']['Descrizione']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', ['action' => 'view', $legendaCodiciIva['LegendaCodiciIva']['id']], ['escape' => false]); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', ['action' => 'edit', $legendaCodiciIva['LegendaCodiciIva']['id']], ['escape' => false]); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $legendaCodiciIva['LegendaCodiciIva']['id']], ['escape' => false], __('Are you sure you want to delete # %s?', $legendaCodiciIva['LegendaCodiciIva']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<p>
				<small><?php echo $this->Paginator->counter(['format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')]);?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('&larr; Previous', ['class' => 'prev','tag' => 'li','escape' => false], '<a onclick="return false;">&larr; Previous</a>', ['class' => 'prev disabled','tag' => 'li','escape' => false]);
					echo $this->Paginator->numbers(['separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a']);
					echo $this->Paginator->next('Next &rarr;', ['class' => 'next','tag' => 'li','escape' => false], '<a onclick="return false;">Next &rarr;</a>', ['class' => 'next disabled','tag' => 'li','escape' => false]);
				?>
			</ul>
			<?php } ?>

		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->