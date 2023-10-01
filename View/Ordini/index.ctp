<?php $this->Html->addCrumb('Ordini', ''); ?>

<div class="ordini index">
	<h1><i class="fa fa-gift"></i><?php echo __(' Ordini'); ?></h1>
    <div class="table-responsive">
	<table class="table table-bordered table-hover table-striped display dataTable">
    <thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('dataOrdine'); ?></th>
			<th><?php echo $this->Paginator->sort('fornitore_id'); ?></th>
			<th><?php echo $this->Paginator->sort('attivita_id'); ?></th>
			<th>Ricevuti</th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
    </thead>
    <tbody>
	<?php foreach ($ordini as $ordine): ?>
	<tr>
		<td><?php echo h($ordine['Ordine']['id']); ?>&nbsp;</td>
		<td><?php echo h($ordine['Ordine']['dataOrdine']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ordine['Fornitore']['DisplayName'], ['controller' => 'persone', 'action' => 'edit', $ordine['Fornitore']['id']]); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ordine['Attivita']['name'], ['controller' => 'attivita', 'action' => 'edit', $ordine['Attivita']['id']]); ?>
		</td>
		<td>
			<?php 
				$da_ricevere = 0;
				$ricevuti = 0;
				foreach($ordine['Rigaordine'] as $r) {
					$da_ricevere += empty($r['qta']) ? 0 : $r['qta'];
					$ricevuti += empty($r['qta_ricevuta']) ? 0 : $r['qta_ricevuta'];
				}
			
				if($da_ricevere == $ricevuti) {
					$cls = 'bg-success';
				}
				else {
					if($ricevuti == 0) {
						$cls = 'bg-danger';
					}
					else {
						$cls = 'bg-warning';
					}
				}
			
				echo '<span class="badge '.$cls.'">'.$ricevuti.' / '.$da_ricevere.'</span>';
			
			?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), ['action' => 'view', $ordine['Ordine']['id']], ['class'=>'btn btn-primary btn-xs']); ?>
			<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $ordine['Ordine']['id']], ['class'=>'btn btn-primary btn-xs']); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $ordine['Ordine']['id']], ['class'=>'btn btn-primary btn-xs btn-del-riga'], __('Are you sure you want to delete # %s?', $ordine['Ordine']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
    </tbody>
	</table>	
    </div>
</div>

<?php $this->Html->scriptStart(['inline' => false]); ?>  
  $('document').ready(function(){
	//data table
	$('.dataTable').dataTable({
        aaSorting: [[ 1, 'asc' ]],
		
        "iDisplayLength" : 100
        
		//"bFilter": true,
		//"bPaginate": false
	});
});
<?php $this->Html->scriptEnd();