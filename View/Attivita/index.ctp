<?php $this->Html->addCrumb('Attività', ''); ?>
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php $baseformclass = ' form-control input-sm '; ?>
<?php 
    //Preparo le caselle del filtro con i valori della query string (se non ci sono uso quelli del cookie)
    function cookie_or_query($obj, $param, $cookieprep)
    {        
        $q = $obj->request->query($param);        
        if (empty($q))
        {            
            if (isset($cookieprep[$param]))
            {
                $q = $cookieprep[$param];
            }
        }
        return $q;
    }
    $q = cookie_or_query($this, 'q', $cookieprep);
    $anno = cookie_or_query($this, 'anno', $cookieprep);
    $tipo = cookie_or_query($this, 'tipo', $cookieprep);
?>
<div class="attivita index">    
	<h2><i class='fa fa-book'></i> <?php echo __('Attivit&agrave;');?></h2>

    <div class="actions">
    <a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url('/attivita/edit') ?>"><i class='fa fa-plus'></i> Nuova Attivit&agrave;</a>
    </div>
     <div class="row">
        <div class="well parent-chosen" id="ricerca-avanzata">
        <!-- Form di Ricerca -->
        <?php
        echo $this->Form->create("Attivita",array(
                'url' => array('action' => 'index'),
                'type' => 'get',
                'inputDefaults' => array(
                    'div' => 'form-group ',
                    'wrapInput' => true,
                    'class' => $baseformclass
                ),
                'class' => ' form-inline',
            ));
        ?>        
        
        <?php echo $this->Form->input('q', array('label'=>'Cliente o Titolo', 'value'=>$q )); ?>
        <?php echo $this->Form->input('anno', array('default'=>'*', 'label'=>'Anno',                                                 
                                                'selected'=>$anno,
                                                'options'=>array(
                                                    date('Y')=>'Anno Corrente', 
                                                    date('Y')-1 => date('Y')-1,
                                                    date('Y')-2 => date('Y')-2,
                                                    date('Y')-3 => date('Y')-3,
                                                    date('Y')+1 => 'Anno Prossimo',
                                                    '*' => 'Sempre',
                                                    '-1' => 'Date Anomale',
                                                    )
                                )); ?>
        <?php echo $this->Form->input('tipo', array('label'=>'Tipo', 
                                                'value'=>$tipo,
                                                'selected'=>$tipo,
                                                'options'=>array(
                                                    null=> 'Tutte',
                                                    'offerte'=> 'Offerte',
                                                    'aperte'=> 'Aperte',
                                                    'chiuse'=> 'Chiuse',
                                                    )
                                )); ?>
        <?php echo $this->Form->end('Filtra'); ?>
        <div class="alert alert-warning small">
            Ci sono <span class="label label-info"><?php echo $totale ?></span> attività su iGAS, usa i filtri per 
            <?php echo $this->Html->link('vederle tutte', array(
                                                'controller' => 'attivita',
                                                'action' => 'index',
                                                '?' => array('anno'=>'*')
            )); ?>
        </div>
        </div>
    </div>

    <?php if ($this->request->query('anno') ==-1 && !empty($attivita)): //Invito a correggere le date anomale ?>
            <div class="alert alert-info">
                Le attività in questo elenco hanno date anomale, puoi correggerle velocemente usando il 
                <a href="attivita/correggiDateInizioFine" class="btn btn-warning">Correttore di Date Anomale</a>
            </div>
    <?php endif ?>

    <div class="table-responsive">
	<table class="table table-bordered table-hover table-striped display dataTable">
    <thead>
	<tr>
			<th>Id</th>
			<th>Stato</th>
			<th>Nome</th>
			<th>Progetto</th>
			<th>Area</th>
			<th>Cliente</th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
    </thead>

    <tbody>
	<?php
    $i = 0;
	foreach ($attivita as $attivita):
	?>

	<tr>
		<td><?php echo $attivita['Attivita']['id'] ?></td>
        <td>
            <?php //Scelgo il colore della label 
            switch ($statoAttivita[$attivita['Attivita']['id']]) {
                case 'commessa':
                    $c = 'primary';
                    break;
                
                case 'offerta':
                    $c = 'warning';
                    break;
                
                case 'chiusa':
                    $c = 'default';
                    break;
                
                default:
                    $c = '';
                    break;
            } 
            ?>
            <div class="label label-<?php echo $c ?>"><?php echo $statoAttivita[$attivita['Attivita']['id']]; ?></div>
        </td>
		<td>
            <?php echo $attivita['Attivita']['name']; ?>
        </td>
        <td><?php echo $this->Html->link(strtolower($attivita['Progetto']['name']), array('controller' => 'progetti', 'action' => 'view', $attivita['Progetto']['id'])); ?></td>
		<td>
            <?php echo $this->Html->link($attivita['Area']['name'], array('controller' => 'aree','action' => 'view', $attivita['Area']['id'])); ?>       </td>
		<td>
			<?php echo $this->Html->link($attivita['Persona']['displayName'], array('controller' => 'persone', 'action' => 'edit', $attivita['Persona']['id'])); ?>
		</td>
		<td class="actions">
             <div class="btn-group dropup settings">                 
                 <?php $u = $this->Html->url(array('action' => 'edit', $attivita['Attivita']['id']));?>
                 <button class="btn btn-primary btn-xs glow" onclick="location.href='<?php echo $u ?>';">
                     <i class="fa fa-pencil"></i>                    
                 </button>
                 <button class="btn btn-primary btn-xs  glow dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">
                        Toggle Dropdown
                    </span>
                 </button>
                 <ul class="dropdown-menu pull-right" role="menu">
                  <li class="">
                    <?php echo $this->Html->link(__('Ore'), array('controller'=>'ore','action'=>'stats', '?' => array('as_values_attivita'=>$attivita['Attivita']['id']. ",") )); ?>
                  </li>
                  <li class="">
                    <?php echo $this->Html->link(__('Fasi'), array('controller'=>'faseattivita', 'action' => 'index', $attivita['Attivita']['id'])); ?>
                  </li>
				  <li class="">
                    <?php echo $this->Html->link(__('Avanzamento'), array('controller'=>'attivita', 'action' => 'avanzamento', $attivita['Attivita']['id'])); ?>
                  </li>
                <?php 
                  foreach(Configure::read('iGas.commonFiles') as $ext => $mimes): 
                    if(file_exists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$attivita['Attivita']['id'].'_preventivo.'.$ext)): 
                ?>
                    <li class="">
                        <?php echo $this->Html->link('View Attachment', HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$attivita['Attivita']['id'].'_preventivo.'.$ext); ?>
                    </li>
                <?php 
                    endif;
                  endforeach; 
                ?>
                  <li class="">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $attivita['Attivita']['id'])); ?>
                  </li>
                  <li class="">
                    <?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $attivita['Attivita']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $attivita['Attivita']['id'])); ?>
                  </li>                  
                </ul>
              </div>
		</td>
	</tr>
<?php endforeach; ?>
    </tbody>
	</table>
  <?php echo $this->Paginator->pagination(array(
  'ul' => 'pagination'
)); ?>
	</div>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
  
  $('document').ready(function(){
	//data table
	$('.dataTable').dataTable({
        aaSorting: [[ 0 , 'desc' ]],		    
        "iDisplayLength" : 200,
        
        buttons: [
                'copy', 'csv', 'print'
            ]        		
	});
});
<?php $this->Html->scriptEnd(); 