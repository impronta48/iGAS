<?php $id = $this->request->params['pass'][0];
      echo $this->element('secondary_attivita', ['aid'=>$id]); 
?>
<?php $this->Html->addCrumb("Attività", "/attivita/"); ?>
<?php $this->Html->addCrumb("Attività [$id]", "/attivita/edit/$id"); ?>
<?php $this->Html->addCrumb("Fatture Emesse", "#"); ?>

<div class="index">    
<h2>Elenco fatture emesse</h2>
<?php if (empty($fatture)):?>
		Nessuna fattura emessa per questa attività
		<div class="actions">
			<a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url(['controller'=>'fattureemesse', 'action'=>'add', $aid]) ?>">Nuova Fattura</a>
			<a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url(['controller'=>'fattureemesse', 'action'=>'add', $aid, '?' => ['serie' => 'pa']]) ?>">Nuova Fattura PA</a>
        </div>
<?php else:?>
    
	<div class="actions">
        <a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url(['controller'=>'fattureemesse', 'action'=>'add', $aid]) ?>">Nuova Fattura</a>
		<a class="btn btn-primary btn-animate-demo" href="<?php echo $this->Html->url(['controller'=>'fattureemesse', 'action'=>'add', $aid, '?' => ['serie' => 'pa']]) ?>">Nuova Fattura PA</a>
    </div>

   <div class="table-responsive">
	<table class="table table-bordered table-hover table-striped fatture"> 
    <tr>    
    <th>Progressivo</th>
    <th>Data</th>
    <th>Motivazione</th>
    <th>Importo</th>    
    <th>Actions</th>
    </tr>
    
    
<?php 
    function sommarighe($f)
    {
        $tot=0;
        foreach ($f['Rigafattura'] as $i)
        {
            $tot += $i['Importo'];
        }
        return $tot;
    }

    if (!empty($fatture))
    {
        $fatturato = 0;
        foreach ($fatture as $f):
        
?>
    <tr>
            <td>
            <?php 
				$progressivo = $f['Fatturaemessa']['Progressivo'] . '/'. $f['Fatturaemessa']['AnnoFatturazione'];
				if(!empty($f['Fatturaemessa']['Serie'])) $progressivo .= ' - '. strtoupper($f['Fatturaemessa']['Serie']);
				
				echo $this->Html->link(
                    $progressivo,
                    //array( 'controller' => 'fattureemesse','action' => 'stampa', $f['Fatturaemessa']['id'] )
                    [ 'controller' => 'fattureemesse','action' => 'edit', $f['Fatturaemessa']['id'] ]
                    );        
            ?>
            </td>    
            <td><?php echo $f['Fatturaemessa']['data'] ?></td>            
            <td><?php echo $f['Fatturaemessa']['Motivazione'] ?></td>            
            <td><?php echo $this->Number->currency(sommarighe($f),'EUR'); ?></td>            
            <td class="actions">
             <div class="btn-group settings">                 
                 <?php $u = $this->Html->url(['controller' => 'fattureemesse', 'action' => 'view', $f['Fatturaemessa']['id']]);?>
                 <button class="btn btn-primary btn-xs glow" onclick="location.href='<?php echo $u ?>';">
                     <i class="fa fa-print"></i>                    
                 </button>
                 <button class="btn btn-primary btn-xs  glow dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">
                        Toggle Dropdown
                    </span>
                 </button>
                 <ul class="dropdown-menu" role="menu">
                  <li>
                    <?php echo $this->Html->link(__('Invia a Cloud'), ['action' => 'fattureincloud', $f['Fatturaemessa']['id']]); ?>
                  </li>
                  <?php if($f['Fatturaemessa']['IdFattureInCloud']){ ?>
                  <li>
                    <?php echo $this->Html->link(__('Elimina da Cloud'), ['action' => 'fattureincloudelimina', $f['Fatturaemessa']['id']]); ?>
                  </li>
                  <?php } ?>
                  <li >
                    <?php echo $this->Html->link(__('Print'),['controller' => 'fattureemesse', 'action' => 'view', $f['Fatturaemessa']['id']]); ?>
                  </li>
                  <li>
                    <?php echo $this->Html->link(__('Edit'), ['controller' => 'fattureemesse', 'action' => 'edit',  $f['Fatturaemessa']['id']]); ?>
                  </li>
                  <li>
                    <?php echo $this->Html->link(__('Duplica'), ['controller' => 'fattureemesse', 'action' => 'dup',  $f['Fatturaemessa']['id']]); ?>
                  </li> 
                  <li >
                    <?php echo $this->Html->link(__('Delete'), ['controller' => 'fattureemesse', 'action' => 'delete',  $f['Fatturaemessa']['id']], null, sprintf(__('Are you sure you want to delete # %s?'),  $f['Fatturaemessa']['id'])); ?>
                  </li>                  
                </ul>
              </div>
              <?php if($f['Fatturaemessa']['IdFattureInCloud']){ ?>
                  <span class="badge bg-primary" title="Fattura già inviata a fattureincloud.it" alt="Fattura già inviata a fattureincloud.it"><i class="fa fa-cloud"></i> Già inviata</span>
              <?php } ?>
            </td>             
            <?php $fatturato += sommarighe($f); ?>
    </tr>
<?php
        endforeach; 
    }
    else 
    {
         echo 'Nessuna fattura per questa attivit&agrave;';
    }
?>
    <tr class="totale bg-success">
        <td colspan="3" class="totale bg-success">Fatturato Totale</td>        
        <td class="totale bg-success"><?php echo $this->Number->currency($fatturato, 'EUR'); ?></td>
        <td class="totale bg-success"></td>
    </tr>
    </table>
   </div>
    
</div>
 
 <?php endif;?>