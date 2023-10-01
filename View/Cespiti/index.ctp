<?php

$this->Html->addCrumb('Cespiti', '/cespiti');

?>

<h2><i class='fa fa-archive'></i> <?php echo __('Cespiti');?></h2>
<div class="actions">
    <a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url('/cespiti/add') ?>"><i class='fa fa-plus'></i> Aggiungi un elemento</a>
</div>

<table class="table table-bordered table-hover table-striped display">
<tr>
    <th width="30%"><?php echo $this->Paginator->sort('DisplayName','Nome');?></th>
    <th width="10%"><?php echo $this->Paginator->sort('costo_acquisto');?></th>
    <th width="10%"><?php echo $this->Paginator->sort('costo_affitto');?></th>
    <th width="10%"><?php echo $this->Paginator->sort('data_acquisto');?></th>
    <th width="35%">Descrizione</th>			            		
    <th width="5%" class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
	$i = 0;
	foreach ($cespiti as $cespite):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr <?php echo $class;?>>
    <td><?php echo $cespite['Cespite']['DisplayName']; ?>&nbsp;</td>
		<td><?php echo $cespite['Cespite']['costo_acquisto']; ?>&nbsp;</td>
		<td><?php echo $cespite['Cespite']['costo_affitto']; ?>&nbsp;</td>
    <td><?php echo $cespite['Cespite']['data_acquisto']; ?>&nbsp;</td>
    <td><?php echo $cespite['Cespite']['descrizione']; ?>&nbsp;</td>
		<td class="actions">
            <div class="btn-group">                 
                 <a class="btn btn-primary btn-xs" href="<?php echo $this->Html->url('edit/'.$cespite['Cespite']['id']); ?>">
                     <i class="fa fa-pencil"></i>                    
                 </a>
                 <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">
                        Toggle Dropdown
                    </span>
                 </button>
                 <ul class="dropdown-menu" role="menu">                  
                  <li >
                    <?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $cespite['Cespite']['id']]); ?>
                  </li>
                  <li >
                    <?php echo $this->Html->link(__('Delete'), ['action' => 'delete', $cespite['Cespite']['id']], null, sprintf(__('Are you sure you want to delete # %s?'), $cespite['Cespite']['id'])); ?>
                  </li>                  
                </ul>
            </div>
		</td>
	</tr>
<?php endforeach; ?>
</table>