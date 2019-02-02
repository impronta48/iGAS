<?php $this->Html->addCrumb('Progetti', ''); ?>

<div class="progetti index">
	<h2><i class="fa fa-building"></i><?php echo __(' Progetti');?></h2>
     <div class="actions">
        <a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url('/progetti/edit') ?>"><i class="fa fa-plus"></i> Nuovo Progetto</a>
    </div>   
    
	<table class="table table-bordered table-hover table-striped display">
	<tr>
			<th><?php echo $this->Paginator->sort('id', 'Id');?></th>
			<th><?php echo $this->Paginator->sort('name', 'Nome');?></th>
			<th><?php echo $this->Paginator->sort('DescrizioneProgetto', 'Descrizione Progetto');?></th>
			<th class="actions"><?php echo __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($progetti as $progetto):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $progetto['Progetto']['id']; ?>&nbsp;</td>
		<td><?php echo $progetto['Progetto']['name']; ?>&nbsp;</td>
		<td><?php echo $progetto['Progetto']['DescrizioneProgetto']; ?>&nbsp;</td>
		<td class="actions">
            <div class="btn-group settings">                 
                 <?php $u = $this->Html->url(array('action' => 'edit', $progetto['Progetto']['id']));?>
                 <button class="btn btn-primary btn-xs glow" onclick="location.href='<?php echo $u ?>';">
                     <i class="fa fa-pencil"></i>                    
                 </button>
                 <button class="btn btn-primary btn-xs  glow dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">
                        Toggle Dropdown
                    </span>
                 </button>
                 <ul class="dropdown-menu list-group" role="menu">
                  <li class="list-group-item">
					<?php echo $this->Html->link(__('Avanzamento'),'/attivita/avanzamento_gen?progetto=' . $progetto['Progetto']['id']); ?>                   
                  </li>
                  <li class="list-group-item">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $progetto['Progetto']['id'])); ?>
                  </li>
                  <li class="list-group-item">
                    <?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $progetto['Progetto']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $progetto['Progetto']['id'])); ?>
                  </li>                  
                </ul>
            </div>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%, visualizzati %current% risultati su %count%')
	));
	?>	</p>

	<?php echo $this->Paginator->pagination(array(
	'ul' => 'pagination'
)); ?>
</div>
