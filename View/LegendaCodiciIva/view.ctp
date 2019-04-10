<div class="legendaCodiciIvas view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Legenda Codici Iva'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Legenda Codici Iva'), array('action' => 'edit', $legendaCodiciIva['LegendaCodiciIva']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Legenda Codici Iva'), array('action' => 'delete', $legendaCodiciIva['LegendaCodiciIva']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $legendaCodiciIva['LegendaCodiciIva']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Legenda Codici Ivas'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Legenda Codici Iva'), array('action' => 'add'), array('escape' => false)); ?> </li>		
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($legendaCodiciIva['LegendaCodiciIva']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Percentuale'); ?></th>
		<td>
			<?php echo h($legendaCodiciIva['LegendaCodiciIva']['Percentuale']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Descrizione'); ?></th>
		<td>
			<?php echo h($legendaCodiciIva['LegendaCodiciIva']['Descrizione']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>


