<div class="legendaMezzis index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Legenda Mezzi'); ?></h1>
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
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Legenda Mezzi'), ['action' => 'add'], ['escape' => false]); ?></li>
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List'.__('Notaspese'), ['controller' => 'notaspese', 'action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New'.__('Notaspesa'), ['controller' => 'notaspese', 'action' => 'add'], ['escape' => false]); ?> </li>
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
						<th nowrap><?php echo $this->Paginator->sort('name'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('costokm'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('co2'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('biglietto'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($legendaMezzis as $legendaMezzi): ?>
					<tr>
						<td nowrap><?php echo h($legendaMezzi['LegendaMezzi']['id']); ?>&nbsp;</td>
						<td nowrap><?php echo h($legendaMezzi['LegendaMezzi']['name']); ?>&nbsp;</td>
						<td nowrap><?php echo h($legendaMezzi['LegendaMezzi']['costokm']); ?>&nbsp;</td>
						<td nowrap><?php echo h($legendaMezzi['LegendaMezzi']['co2']); ?>&nbsp;</td>
						<td nowrap><?php echo h($legendaMezzi['LegendaMezzi']['biglietto']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', ['action' => 'view', $legendaMezzi['LegendaMezzi']['id']], ['escape' => false]); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', ['action' => 'edit', $legendaMezzi['LegendaMezzi']['id']], ['escape' => false]); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $legendaMezzi['LegendaMezzi']['id']], ['escape' => false], __('Are you sure you want to delete # %s?', $legendaMezzi['LegendaMezzi']['id'])); ?>
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