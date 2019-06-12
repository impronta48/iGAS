<?php if (isset($this->request->params['pass'][0]))
    {
      $id = $this->request->params['pass'][0];
      echo $this->element('secondary_attivita', array('aid'=>$id)); 
      $this->Html->addCrumb("Attività", "/attivita/");
      if (!empty($faseattivita))
      {
        $this->Html->addCrumb("Attività [$id] - " . $faseattivita[0]['Attivita']['name'], "/attivita/edit/$id");
      }
      else
      {
          $this->Html->addCrumb("Attività [$id]", "/attivita/edit/$id");
      }      
      $this->Html->addCrumb("Fasi", "");
    }
?>

<div class="faseattivita index">
	<h2>Fasi</h2>    

    <div class="hidden-print">  
    <?php if (isset($this->request->params['pass'][0])): ?>
    <a href="#" class="btn btn-primary" id="aggiungi-fase"><i class="fa fa-plus-circle"></i> Aggiungi una fase/prodotto</a>
    <a href="<?php echo $this->Html->url(array('controller'=>'attivita', 'action'=>'preventivo', $id)); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Stampa Preventivo</a>   
    <a href="<?php echo $this->Html->url(array('controller'=>'ddt', 'action'=>'add', $id)); ?>" class="btn btn-primary"><i class="fa fa-truck"></i> Crea DdT</a>   
    <a href="#" class="btn btn-primary" id="genera-ordine"><i class="fa fa-eject"></i> Genera ordine da selezione</a>
    <a href="#" class="btn btn-primary"><i class="fa fa-rotate-right"></i> Cambia Stato</a>
    <?php endif; ?>
    
    <div class="panel panel-cascade">
        <div class="panel-heading">
            <h3 class="panel-title" data-toggle="collapse" data-target="#aggiungi-attivita"><i class="fa fa-plus-circle"></i> Aggiungi una fase / prodotto
                <span class="pull-right">
                    <a href="#" class="panel-minimize"><i class="fa fa-chevron-up"></i></a>
                </span>
            </h3>
        </div>
        
        
        <div id="aggiungi-attivita" class="panel-body collapse">
            <?php echo $this->Form->create('Faseattivita',array(
                                'enctype' => 'multipart/form-data',
                                'inputDefaults' => array(
                                    'div' => 'form-group',
                                    'label' => array(
                                        'class' => 'col col-md-3 control-label'
                                    ),
                                    'wrapInput' => 'col col-md-4',
                                    'class' => 'form-control form-cascade-control input-xs'
                                ),	
                                'class' => 'well form-horizontal',
                                'url' => array('controller' => 'faseattivita', 'action' => 'add'),
                )); ?>  
            <?php 
                if (!empty($id))
                {
                    echo $this->Form->hidden('attivita_id', array('default'=>$id)); 
                }
                else
                {
                    echo $this->Form->input('attivita_id'); 
                }
                
            ?>
            <?php echo $this->Form->input('entrata', array('options' => array(0 =>'Uscita', 1 => 'Entrata'), 'label'=> 'Tipo di fase') );?>
            <?php echo $this->Form->input('Descrizione');?>
            <?php echo $this->Form->hidden('cespite_id',array('type'=>'text')); ?>
            <?php echo $this->Form->input('Cespite.DisplayName', array('type'=>'text', 'label' => 'Cespite Associato', 'required' => false));?>
            <?php echo $this->Form->input('qta');?>
            <?php echo $this->Form->input('um');?>
            <?php echo $this->Form->input('costou', array('label'=> 'Costo Unità'));?>
            <?php echo $this->Form->input('vendutou', array('label'=> 'Venduto Unità'));?>            
            <?php echo $this->Form->input('sc1');?>
            <?php echo $this->Form->input('sc2');?>
            <?php echo $this->Form->input('sc3');?>
            <?php echo $this->Form->input('legenda_codici_iva_id', array('options'=>$legendaCodiceiva, 'default'=>Configure::read('iGas.IvaDefault')));?>
            <?php echo $this->Form->hidden('persona_id', array('type'=>'text')); ?>
            <?php echo $this->Form->input('Persona.DisplayName', array('type'=>'text', 'label' => 'Persona')); ?>
            <?php echo $this->Form->input('legenda_stato_attivita_id');?>
            <?php echo $this->Form->input('note', array('type'=>'text'));?>
            <?php echo $this->Form->input('uploadFile', array('label'=>'Upload File', 'class'=>false, 'type'=>'file')); ?>
            <div class="col col-md-offset-3">
                <?php echo  $this->Form->button('Aggiungi ', array('class'=>'btn btn-primary', )); ?>
            </div>
            <?php echo  $this->Form->end(); ?>
        </div>
        
    </div>
    </div>

    <h2>Preventivo Costi e Venduto</h2>

    <div class="table-responsive">
	<table class="table table-condensed table-striped">
	<tr>
            <?php if (empty($id)): ?>
                <th>Attività</th>
            <?php else: ?>
                <th>Sel</th>
            <?php endif; ?>
			<th>Descrizione</th>
			<th>Qtà</th>
			<th>Qtà utilizzata</th>
			<th>UM</th>
			<th>Costo U.</th>
            <th>Venduto U.</th>
			<th>Iva</th>
			<th>Tot. Costi</th>
            <th>Tot. Venduto</th>
            <th>Soggetto</th>			
			<th>Stato</th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
    <?php 
        $tot_righe = $totVenduto_righe = 0;
        foreach ($faseattivitanegativa as $faseattivita): 
    ?>
	<tr>
        <?php if (empty($id)): ?>
            <td><?php echo $this->Html->link($faseattivita['Attivita']['name'],'/faseattivita/index/'. $faseattivita['Attivita']['id']); ?></td>
        <?php else: ?>
            <td><input type="checkbox" class="sel" checked id="fase-<?php echo $faseattivita['Faseattivita']['id']; ?>" > </td>
        <?php endif; ?>
		<td><?php echo h($faseattivita['Faseattivita']['Descrizione']); ?>&nbsp;</td>
		<td><?php echo h($faseattivita['Faseattivita']['qta']); ?>&nbsp;</td>
		<td>
			<?php
				$da_spedire = $faseattivita['Faseattivita']['qta'];
				$spedito = 0;
				foreach($faseattivita['Rigaddt'] as $r) {
					$spedito += empty($r['qta']) ? 0 : $r['qta'];
				}
			
				if($da_spedire == $spedito) {
					$cls = 'bg-success';
				}
				else {
					if($spedito == 0) {
						$cls = 'bg-danger';
					}
					else {
						$cls = 'bg-warning';
					}
				}
                //echo '<span class="badge '.$cls.'">'.$spedito.' / '.$da_spedire.'</span>';
                $spedito = ($faseattivita['Faseattivita']['qtaUtilizzata'] == NULL) ? 0 : $faseattivita['Faseattivita']['qtaUtilizzata'];
                echo '<span class="badge '.$cls.'">'.$spedito.' / '.$da_spedire.'</span>';
			?>
		</td>
		<td><?php echo h($faseattivita['Faseattivita']['um']); ?>&nbsp;</td>
        <td><?php echo h($faseattivita['Faseattivita']['costou']); ?>&nbsp; &euro;</td>
        <td><?php echo h($faseattivita['Faseattivita']['vendutou']); ?>&nbsp; &euro;</td>        
		<td><?php echo h($faseattivita['LegendaCodiciIva']['Descrizione']); ?>&nbsp;</td>
        <td><?php $tot = $faseattivita['Faseattivita']['costou']*$faseattivita['Faseattivita']['qta']; $tot_righe += $tot; echo h($tot); ?>&nbsp;&euro;</td>		
        <td><?php $totVenduto = $faseattivita['Faseattivita']['vendutou']*$faseattivita['Faseattivita']['qta']; $totVenduto_righe += $totVenduto; echo h($totVenduto); ?>&nbsp;&euro;</td>
        <td><?php echo $faseattivita['Persona']['DisplayName']; ?></td>
		<td><?php echo $faseattivita['LegendaStatoAttivita']['name']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $faseattivita['Faseattivita']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $faseattivita['Faseattivita']['id'],$faseattivita['Faseattivita']['attivita_id']), null, __('Are you sure you want to delete # %s?', $faseattivita['Faseattivita']['id'])); ?>
            <?php 
            foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
                if(file_exists(WWW_ROOT.'files'.DS.strtolower($this->request->controller).DS.$faseattivita['Faseattivita']['attivita_id'].'_'.$faseattivita['Faseattivita']['id'].'.'.$ext)){
                    echo $this->Html->link('FILE', HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$faseattivita['Faseattivita']['attivita_id'].'_'.$faseattivita['Faseattivita']['id'].'.'.$ext, array('class'=>'btn btn-xs btn-primary','title'=>'View or Download attached File')); 
                }
            }
			?>
            <?php 
                foreach($primenoteDiFasi as $primanota){
                    if($faseattivita['Faseattivita']['id'] == $primanota['Primanota']['faseattivita_id']){
                        echo $this->Html->link('Prima Nota',array('controller' => 'primanota','action' => 'edit',$primanota['Primanota']['id']));
                    }
                }
            ?>
        </td>
	</tr>    
<?php endforeach; ?>    
    <tfoot>
    <tr class="bg-success">       
        <td class="bg-success"></td>
        <td colspan="7" class="bg-success"><b>Totali</b></td>        
        <td class="bg-success"><b><?php echo $tot_righe; $tot_uscite= $tot_righe; ?> &euro;</b></td>
        <td class="bg-success"><b><?php echo $totVenduto_righe; $totVenduto_uscite= $totVenduto_righe; ?> &euro;</b></td>
        <td colspan="3" class="bg-success"></td>
    </tr>
    </tfoot>
	</table>
    </div>
</div>


  <h2>Entrate previste</h2>
  <div class="table-responsive">
    <table class="table table-condensed table-striped">
    <tr>
            <?php if (empty($id)): ?>
                <th><?php echo $this->Paginator->sort('attivita_id'); ?></th>
            <?php else: ?>
                <th>Sel</th>
            <?php endif; ?>
            <th><?php echo $this->Paginator->sort('Descrizione'); ?></th>
            <th>Qtà</th>
            <th>Qtà utilizzata</th>
            <th>UM</th>
            <th><?php echo $this->Paginator->sort('costou','Costo U.'); ?></th>
            <th><?php echo $this->Paginator->sort('vendutou','Venduto U.'); ?></th>
            <th>Iva</th>
            <th>Tot. Costi</th>
            <th>Tot. Venduto</th>
            <th><?php echo $this->Paginator->sort('Soggetto'); ?></th>          
            <th><?php echo $this->Paginator->sort('legenda_stato_attivita_id','Stato'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    <?php 
        $tot_righe = $totVenduto_righe = 0;
        foreach ($faseattivitapositiva as $faseattivita): 
    ?>
    <tr>
        <?php if (empty($id)): ?>
            <td><?php echo $this->Html->link($faseattivita['Attivita']['name'],'/faseattivita/index/'. $faseattivita['Attivita']['id']); ?></td>
        <?php else: ?>
            <td><input type="checkbox" class="sel" checked id="fase-<?php echo $faseattivita['Faseattivita']['id']; ?>" > </td>
        <?php endif; ?>
        <td><?php echo h($faseattivita['Faseattivita']['Descrizione']); ?>&nbsp;</td>
        <td><?php echo h($faseattivita['Faseattivita']['qta']); ?>&nbsp;</td>
        <td>
            <?php
                $da_spedire = $faseattivita['Faseattivita']['qta'];
                $spedito = 0;
                foreach($faseattivita['Rigaddt'] as $r) {
                    $spedito += empty($r['qta']) ? 0 : $r['qta'];
                }
            
                if($da_spedire == $spedito) {
                    $cls = 'bg-success';
                }
                else {
                    if($spedito == 0) {
                        $cls = 'bg-danger';
                    }
                    else {
                        $cls = 'bg-warning';
                    }
                }
            
                echo '<span class="badge '.$cls.'">'.$spedito.' / '.$da_spedire.'</span>';
            ?>
        </td>
        <td><?php echo h($faseattivita['Faseattivita']['um']); ?>&nbsp;</td>
        <td><?php echo h($faseattivita['Faseattivita']['costou']); ?>&nbsp; &euro;</td>
        <td><?php echo h($faseattivita['Faseattivita']['vendutou']); ?>&nbsp; &euro;</td>        
        <td><?php echo h($faseattivita['LegendaCodiciIva']['Descrizione']); ?>&nbsp;</td>
        <td><?php $tot = $faseattivita['Faseattivita']['costou']*$faseattivita['Faseattivita']['qta']; $tot_righe += $tot; echo h($tot); ?>&nbsp;&euro;</td>        
        <td><?php $totVenduto = $faseattivita['Faseattivita']['vendutou']*$faseattivita['Faseattivita']['qta']; $totVenduto_righe += $totVenduto; echo h($totVenduto); ?>&nbsp;&euro;</td> 
        <td><?php echo $faseattivita['Persona']['DisplayName']; ?></td>
        <td><?php echo $faseattivita['LegendaStatoAttivita']['name']; ?></td>
        <td class="actions">
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $faseattivita['Faseattivita']['id'])); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $faseattivita['Faseattivita']['id'],$faseattivita['Faseattivita']['attivita_id']), null, __('Are you sure you want to delete # %s?', $faseattivita['Faseattivita']['id'])); ?>
            <?php 
            foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
                if(file_exists(WWW_ROOT.'files'.DS.strtolower($this->request->controller).DS.$faseattivita['Faseattivita']['attivita_id'].'_'.$faseattivita['Faseattivita']['id'].'.'.$ext)){
                    echo $this->Html->link('FILE', HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$faseattivita['Faseattivita']['attivita_id'].'_'.$faseattivita['Faseattivita']['id'].'.'.$ext, array('class'=>'btn btn-xs btn-primary','title'=>'View or Download attached File')); 
                }
            }
			?>
        </td>
    </tr>    
<?php endforeach; ?>    
    <tfoot>
    <tr class="bg-success">       
        <td class="bg-success"></td>
        <td colspan="7" class="bg-success"><b>Totali</b></td>        
        <td class="bg-success"><b><?php echo $tot_righe ?> &euro;</b></td>
        <td class="bg-success"><b><?php echo $totVenduto_righe ?> &euro;</b></td>
        <td colspan="3" class="bg-success"></td>
    </tr>
    </tfoot>
    </table>
    </div>
   
</div>

<h2>Utile Commessa: <?php echo $totVenduto_uscite - $tot_uscite ?>&euro;</h2>
<h2>Da incassare: <?php echo $totVenduto_uscite - $totVenduto_righe ?>&euro;</h2>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() { 
    $( "#PersonaDisplayName" ).autocomplete({
		source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#FaseattivitaPersonaId").val(ui.item.id);
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$("#PersonaDisplayName").val($(this).data("uiItem"));
    });
    
    $("#CespiteDisplayName").rules("remove", "required"); // Not useful now

    $("#CespiteDisplayName").autocomplete({
		source: "<?php echo $this->Html->url(array('controller' => 'cespiti', 'action' => 'autocomplete')) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#FaseattivitaCespiteId").val(ui.item.id);
                $("#FaseattivitaCostou").val(ui.item.defaultPrice);
                $("#FaseattivitaUm").val('gg');
                $(this).data("uiItem",ui.item.value);
                //console.log(ui.item.value);
            }
    }).bind("blur",function(){
			$("#CespiteDisplayName").val($(this).data("uiItem"));
	});

} );

$('#aggiungi-fase').click( function(e) { $('h3.panel-title').trigger('click'); });

$('#genera-ordine').click (function (e) {
      var arrayOfValues = [];
      $('.sel:checked').each( function(){ 
              $f = $(this).attr('id').substring(5);
              arrayOfValues.push($f);        
          }
      );
      location.assign('<?php echo $this->Html->url(array('controller' => 'ordini', 'action' => 'add', '?'=>array('attivita_id'=> $id))) ?>' + '&fasi='+arrayOfValues);
  });          

<?php $this->Html->scriptEnd();
