<div class="impiegati index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Impiegati'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->
    
    <div class="alert alert-info alert-dismissable">    	
    	Per aggiungere un impiegato dovete andare nella sezione contatti, aggiungere la scheda della persona (o cercarla nell'elenco) e poi scegliere la linguetta "Costi e Tariffe"
    </div>
    
    <?php 
    	if (isset($persona_id))
    	{
    		if (!empty($impiegati))
    		{
    			echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Crea una variazione per questo impiegato'), array('action' => 'variation', $impiegati[0]['Impiegato']['id']), array('escape' => false, 'class'=> 'btn btn-primary')); 

    		}
    		else
    		{
    			echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Crea una variazione per questo impiegato'), array('action' => 'add', $persona_id), array('escape' => false, 'class'=> 'btn btn-primary')); 
    		}
    	}
    ?>

    <table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
                        <th nowrap><?php echo $this->Paginator->sort('Persona.DisplayName','Nome'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('LegendaTipoImpiegato_id','Tipo Impiegato'); ?></th>						
						<th nowrap><?php echo $this->Paginator->sort('dataAssunzione'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('costoAziendale','Costo Aziendale'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('venduto','Tariffa di Vendita'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('oreContratto','Ore a Contratto'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('dataValidità','Validità'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('modified', 'DataModifica'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($impiegati as $impiegato):
                        $extraclass= 'disabled';
                        if ($impiegato['Impiegato']['disattivo'])
                        {
                            $extraclass= 'disabled';
                        }
                ?>
					<tr class="<?php echo $extraclass ?>">
                        <td>                            
                            <?php echo $this->Html->link($impiegato['Persona']['DisplayName'], array('controller' => 'impiegati', 'action' => 'index', $impiegato['Persona']['id'])); ?>
                        </td>
                        <td nowrap><?php echo h($impiegato['LegendaTipoImpiegato']['TipoImpiegato']); ?>&nbsp;</td>						
						<td nowrap><?php echo h($this->Time->format($impiegato['Impiegato']['dataAssunzione'], '%d-%m-%Y', 'invalid')); ?>&nbsp;</td>
						<td nowrap><?php echo h($impiegato['Impiegato']['costoAziendale']); ?>€ (a <?php echo h($impiegato['LegendaUnitaMisura']['name']); ?>)&nbsp;</td>
						<td nowrap><?php echo h($impiegato['Impiegato']['venduto']); ?>€&nbsp;</td>						
						<td nowrap>
							<?php echo $impiegato['Impiegato']['oreLun']; ?> |
							<?php echo $impiegato['Impiegato']['oreMar']; ?> |
							<?php echo $impiegato['Impiegato']['oreMer']; ?> |
							<?php echo $impiegato['Impiegato']['oreGio']; ?> |
							<?php echo $impiegato['Impiegato']['oreVen']; ?> |
							<?php echo $impiegato['Impiegato']['oreSab']; ?> |
							<?php echo $impiegato['Impiegato']['oreDom']; ?>							
						</td>						
						<td nowrap><?php echo h($this->Time->format($impiegato['Impiegato']['dataValidita'], '%d-%m-%Y')); ?>&nbsp;</td>
						<td nowrap><?php echo h($this->Time->format($impiegato['Impiegato']['modified'], '%d-%m-%Y', 'invalid')); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span>', array('controller' => 'persone', 'action' => 'edit', $impiegato['Persona']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $impiegato['Impiegato']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $impiegato['Impiegato']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $impiegato['Impiegato']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $impiegato['Impiegato']['persona_id'])); ?>
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