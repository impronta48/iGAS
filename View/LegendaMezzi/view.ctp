<div class="legendaMezzis view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Legenda Mezzi'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Legenda Mezzi'), ['action' => 'edit', $legendaMezzi['LegendaMezzi']['id']], ['escape' => false]); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Legenda Mezzi'), ['action' => 'delete', $legendaMezzi['LegendaMezzi']['id']], ['escape' => false], __('Are you sure you want to delete # %s?', $legendaMezzi['LegendaMezzi']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Legenda Mezzis'), ['action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Legenda Mezzi'), ['action' => 'add'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Notaspese'), ['controller' => 'notaspese', 'action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Notaspesa'), ['controller' => 'notaspese', 'action' => 'add'], ['escape' => false]); ?> </li>
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
			<?php echo h($legendaMezzi['LegendaMezzi']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Name'); ?></th>
		<td>
			<?php echo h($legendaMezzi['LegendaMezzi']['name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Costokm'); ?></th>
		<td>
			<?php echo h($legendaMezzi['LegendaMezzi']['costokm']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Co2'); ?></th>
		<td>
			<?php echo h($legendaMezzi['LegendaMezzi']['co2']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Biglietto'); ?></th>
		<td>
			<?php echo h($legendaMezzi['LegendaMezzi']['biglietto']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Notaspese'); ?></h3>
	<?php if (!empty($legendaMezzi['Notaspesa'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('EAttivita'); ?></th>
		<th><?php echo __('ERisorsa'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('ECatSpesa'); ?></th>
		<th><?php echo __('Importo'); ?></th>
		<th><?php echo __('Importo Val'); ?></th>
		<th><?php echo __('Fatturabile'); ?></th>
		<th><?php echo __('Rimborsabile'); ?></th>
		<th><?php echo __('Origine'); ?></th>
		<th><?php echo __('Destinazione'); ?></th>
		<th><?php echo __('Legenda Mezzi Id'); ?></th>
		<th><?php echo __('Km'); ?></th>
		<th><?php echo __('Descrizione'); ?></th>
		<th><?php echo __('Valuta'); ?></th>
		<th><?php echo __('Tasso'); ?></th>
		<th><?php echo __('Faseattivita Id'); ?></th>
		<th><?php echo __('Fatturato'); ?></th>
		<th><?php echo __('Rimborsato'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($legendaMezzi['Notaspesa'] as $notaspesa): ?>
		<tr>
			<td><?php echo $notaspesa['id']; ?></td>
			<td><?php echo $notaspesa['eAttivita']; ?></td>
			<td><?php echo $notaspesa['eRisorsa']; ?></td>
			<td><?php echo $notaspesa['data']; ?></td>
			<td><?php echo $notaspesa['eCatSpesa']; ?></td>
			<td><?php echo $notaspesa['importo']; ?></td>
			<td><?php echo $notaspesa['importo_val']; ?></td>
			<td><?php echo $notaspesa['fatturabile']; ?></td>
			<td><?php echo $notaspesa['rimborsabile']; ?></td>
			<td><?php echo $notaspesa['origine']; ?></td>
			<td><?php echo $notaspesa['destinazione']; ?></td>
			<td><?php echo $notaspesa['legenda_mezzi_id']; ?></td>
			<td><?php echo $notaspesa['km']; ?></td>
			<td><?php echo $notaspesa['descrizione']; ?></td>
			<td><?php echo $notaspesa['valuta']; ?></td>
			<td><?php echo $notaspesa['tasso']; ?></td>
			<td><?php echo $notaspesa['faseattivita_id']; ?></td>
			<td><?php echo $notaspesa['fatturato']; ?></td>
			<td><?php echo $notaspesa['rimborsato']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), ['controller' => 'notaspese', 'action' => 'view', $notaspesa['id']], ['escape' => false]); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), ['controller' => 'notaspese', 'action' => 'edit', $notaspesa['id']], ['escape' => false]); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), ['controller' => 'notaspese', 'action' => 'delete', $notaspesa['id']], ['escape' => false], __('Are you sure you want to delete # %s?', $notaspesa['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Notaspesa'), ['controller' => 'notaspese', 'action' => 'add'], ['escape' => false, 'class' => 'btn btn-default']); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
