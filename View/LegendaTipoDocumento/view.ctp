<div class="legendaTipoDocumentos view">
<h2><?php echo __('Legenda Tipo Documento'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($legendaTipoDocumento['LegendaTipoDocumento']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($legendaTipoDocumento['LegendaTipoDocumento']['title']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Legenda Tipo Documento'), array('action' => 'edit', $legendaTipoDocumento['LegendaTipoDocumento']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Legenda Tipo Documento'), array('action' => 'delete', $legendaTipoDocumento['LegendaTipoDocumento']['id']), array(), __('Are you sure you want to delete # %s?', $legendaTipoDocumento['LegendaTipoDocumento']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Legenda Tipo Documentos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Legenda Tipo Documento'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fatturericevute'), array('controller' => 'fatturericevute', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fatturaricevuta'), array('controller' => 'fatturericevute', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Fatturericevute'); ?></h3>
	<?php if (!empty($legendaTipoDocumento['Fatturaricevuta'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Attivita Id'); ?></th>
		<th><?php echo __('Progressivo'); ?></th>
		<th><?php echo __('AnnoFatturazione'); ?></th>
		<th><?php echo __('Motivazione'); ?></th>
		<th><?php echo __('Provenienza'); ?></th>
		<th><?php echo __('ScadPagamento'); ?></th>
		<th><?php echo __('Importo'); ?></th>
		<th><?php echo __('DataFattura'); ?></th>
		<th><?php echo __('Fornitore Id'); ?></th>
		<th><?php echo __('Legenda Cat Spesa Id'); ?></th>
		<th><?php echo __('Imponibile'); ?></th>
		<th><?php echo __('Iva'); ?></th>
		<th><?php echo __('FuoriIva'); ?></th>
		<th><?php echo __('RitenutaAcconto'); ?></th>
		<th><?php echo __('ScadenzaRitenutaAcconto'); ?></th>
		<th><?php echo __('Pagato'); ?></th>
		<th><?php echo __('PagatoRitenutaAcconto'); ?></th>
		<th><?php echo __('Faseattivita Id'); ?></th>
		<th><?php echo __('Protocollo Ricezione'); ?></th>
		<th><?php echo __('Legenda Tipo Documento Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($legendaTipoDocumento['Fatturaricevuta'] as $fatturaricevuta): ?>
		<tr>
			<td><?php echo $fatturaricevuta['id']; ?></td>
			<td><?php echo $fatturaricevuta['attivita_id']; ?></td>
			<td><?php echo $fatturaricevuta['progressivo']; ?></td>
			<td><?php echo $fatturaricevuta['annoFatturazione']; ?></td>
			<td><?php echo $fatturaricevuta['motivazione']; ?></td>
			<td><?php echo $fatturaricevuta['provenienza']; ?></td>
			<td><?php echo $fatturaricevuta['scadPagamento']; ?></td>
			<td><?php echo $fatturaricevuta['importo']; ?></td>
			<td><?php echo $fatturaricevuta['dataFattura']; ?></td>
			<td><?php echo $fatturaricevuta['fornitore_id']; ?></td>
			<td><?php echo $fatturaricevuta['legenda_cat_spesa_id']; ?></td>
			<td><?php echo $fatturaricevuta['imponibile']; ?></td>
			<td><?php echo $fatturaricevuta['iva']; ?></td>
			<td><?php echo $fatturaricevuta['fuoriIva']; ?></td>
			<td><?php echo $fatturaricevuta['ritenutaAcconto']; ?></td>
			<td><?php echo $fatturaricevuta['scadenzaRitenutaAcconto']; ?></td>
			<td><?php echo $fatturaricevuta['pagato']; ?></td>
			<td><?php echo $fatturaricevuta['pagatoRitenutaAcconto']; ?></td>
			<td><?php echo $fatturaricevuta['faseattivita_id']; ?></td>
			<td><?php echo $fatturaricevuta['protocollo_ricezione']; ?></td>
			<td><?php echo $fatturaricevuta['legenda_tipo_documento_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fatturericevute', 'action' => 'view', $fatturaricevuta['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fatturericevute', 'action' => 'edit', $fatturaricevuta['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fatturericevute', 'action' => 'delete', $fatturaricevuta['id']), array(), __('Are you sure you want to delete # %s?', $fatturaricevuta['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fatturaricevuta'), array('controller' => 'fatturericevute', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
