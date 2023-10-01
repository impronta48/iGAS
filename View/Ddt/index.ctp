<div class="ddt index">
    <h2><i class="fa fa-truck"></i> DdT</h2>
    
    <div class="table-responsive">
	<table class="table table-condensed table-striped dataTable">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('attivita_id'); ?></th>
			<th><?php echo $this->Paginator->sort('data_inizio_trasporto'); ?></th>
			<th><?php echo $this->Paginator->sort('destinatario'); ?></th>
			<th><?php echo $this->Paginator->sort('luogo', 'Luogo Consegna'); ?></th>
			<th><?php echo $this->Paginator->sort('legenda_causale_trasporto_id','Causale Trasporto'); ?></th>
			<th><?php echo $this->Paginator->sort('legenda_porto_id','Porto'); ?></th>
			<th><?php echo $this->Paginator->sort('n_colli'); ?></th>
			<th><?php echo $this->Paginator->sort('vettore_id'); ?></th>		
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($ddt as $ddt): ?>
	<tr>
		<td><?php echo h($ddt['Ddt']['id']); ?>&nbsp;</td>
		<td><?php echo h($ddt['Attivita']['name']); ?>&nbsp;</td>
		<td><?php echo h($ddt['Ddt']['data_inizio_trasporto']); ?>&nbsp;</td>
        <td><b><?php echo h($ddt['Ddt']['destinatario']); ?></b>&nbsp;
		<?php echo h($ddt['Ddt']['destinatario_via']); ?>&nbsp;
		<?php echo h($ddt['Ddt']['destinatario_cap']); ?>&nbsp;
		<?php echo h($ddt['Ddt']['destinatario_citta']); ?>&nbsp;
		<?php echo h($ddt['Ddt']['destinatario_provincia']); ?>&nbsp;</td>
		<td>
		<?php echo h($ddt['Ddt']['luogo_via']); ?>&nbsp;
		<?php echo h($ddt['Ddt']['luogo_cap']); ?>&nbsp;
		<?php echo h($ddt['Ddt']['luogo_citta']); ?>&nbsp;
		<?php echo h($ddt['Ddt']['luogo_provincia']); ?>&nbsp;</td>
		<td><?php echo h($ddt['LegendaCausaleTrasporto']['name']); ?>&nbsp;</td>
		<td><?php echo h($ddt['LegendaPorto']['name']); ?>&nbsp;</td>
		<td><?php echo h($ddt['Ddt']['n_colli']); ?>&nbsp;</td>
		<td><?php echo h($ddt['Vettore']['name']); ?>&nbsp;</td>		
		<td class="actions">
			<?php echo $this->Html->link(__('View'), ['action' => 'view', $ddt['Ddt']['id']]); ?>
			<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $ddt['Ddt']['id']]); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $ddt['Ddt']['id']], null, __('Are you sure you want to delete # %s?', $ddt['Ddt']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
    </div>	
</div>
