<?php

$this->Html->addCrumb('Cespiti', '/cespiti');

?>

<h2><i class='fa fa-calendar'></i> <?php echo __('Event List');?></h2>
<div class="actions">
    <a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url('/cespiti/eventadd') ?>"><i class='fa fa-plus'></i> Aggiungi un evento</a>
    <a class="btn btn-info btn-animate-demo" href="<?php echo $this->Html->url('/cespiti/calendar') ?>"><i class='fa fa-calendar'></i> Visualizza Calendario</a>
</div>

<table class="table table-bordered table-hover table-striped display">
<tr>
    <th width="25%"><?php echo $this->Paginator->sort('Cespite.displayName','Cespite');?></th>
    <th width="25%"><?php echo $this->Paginator->sort('Persona.displayName','User');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('start');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('end');?></th>
    <th width="10%">note</th>			            		
    <th width="5%" class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
    //debug($events);
	$i = 0;
	foreach ($events as $event):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
        }
?>
    
	<tr <?php echo $class;?> <?php echo 'style="background-color:'.$event['LegendaTipoAttivitaCalendario']['color'].'; color:'.$event['LegendaTipoAttivitaCalendario']['textColor'].'"'; ?>>
        <td><?php echo $event['Cespite']['displayName']; ?>&nbsp;</td>
        <td><?php echo ($event['Persona']['displayName'] !== NULL) ? $event['Persona']['displayName'] : $event['Cespitecalendario']['utilizzatore_esterno'] ; ?>&nbsp;</td>
		<td><?php echo $event['Cespitecalendario']['start']; ?>&nbsp;</td>
		<td><?php echo $event['Cespitecalendario']['end']; ?>&nbsp;</td>
        <td><?php echo $event['Cespitecalendario']['note']; ?>&nbsp;</td>
		<td class="actions">
            <div class="btn-group">                 
                 <a class="btn btn-primary btn-xs" href="<?php echo $this->Html->url('eventedit/'.$event['Cespitecalendario']['id']); ?>">
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
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'eventedit', $event['Cespitecalendario']['id'])); ?>
                  </li>
                  <li >
                    <?php echo $this->Html->link(__('Delete'), array('action' => 'eventdelete', $event['Cespitecalendario']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $event['Cespitecalendario']['id'])); ?>
                  </li>                  
                </ul>
            </div>
            <?php if($event['Cespitecalendario']['eventGroup']!==null){ ?>
            <a class="btn btn-primary btn-xs" href="<?php echo $this->Html->url('eventlist/'.$event['Cespitecalendario']['eventGroup']); ?>">
                See Group                
            </a>
            <?php } ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>