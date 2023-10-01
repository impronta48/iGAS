<div class="legendaTipoAttivitaCalendarios index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Tipi di Attività Calendario'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Azioni'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Aggiungi Tipo attività Calendario'), ['action' => 'add'], ['escape' => false]); ?></li>
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
						<th nowrap><?php echo $this->Paginator->sort('title','Nome'); ?></th>
						<th nowrap>Colore</th>
						<th class="actions">Azioni</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($LegendaTipoAttivitaCalendarios as $legendaAttivitaCalendario): ?>
				<tr>
					<td><?php echo h($legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['id']); ?>&nbsp;</td>
					<td><?php echo h($legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['title']); ?>&nbsp;</td>
					<td><div style="background-color:<?php echo h($legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['color']) ?>; color:<?php echo h($legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['textColor']) ?>;"><?php echo h($legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['title']); ?></div>&nbsp;</td>
					<td class="actions">
						<div class="btn-group settings">                 
                 				<?php $u = $this->Html->url(['action' => 'edit', $legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['id']]);?>
                 			<button class="btn btn-primary btn-xs glow" onclick="location.href='<?php echo $u ?>';">
                     			<i class="fa fa-pencil"></i>                    
                 			</button>
                 			<button class="btn btn-primary btn-xs  glow dropdown-toggle" data-toggle="dropdown">
                    			<span class="caret"></span>
                    			<span class="sr-only">
                        			Toggle Dropdown
                    			</span>
                 			</button>
                 			<ul class="dropdown-menu" role="menu">
                  			<li class="">
                    			<?php echo $this->Html->link('<i class="fa fa-pencil"></i> Modifica', ['action' => 'edit', $legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['id']], ['escape' => false]); ?>
                  			</li> 
                  			<li class="">
                    			<?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i> Elimina', ['action' => 'delete', $legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['id']], ['escape' => false], __('Are you sure you want to delete # %s?', $legendaAttivitaCalendario['LegendaTipoAttivitaCalendario']['id'])); ?>
                  			</li>                  
                			</ul>
             			 </div>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

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
