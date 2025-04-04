<div class="attivita form">
<?php if (isset($this->request->params['pass'][0]))
    {
        $id = $this->request->params['pass'][0];
        echo $this->element('secondary_attivita', ['aid'=>$id]); 
    }
    else
        $id=null;
?>
    
<?php $this->Html->addCrumb("Attività", "/attivita/"); ?>
<?php 
    //Metto nel breadcrumb il nome dell'attività
    if (isset($this->request->data['Attivita']['name']))
    {
        $an = "[$id] - " . $this->request->data['Attivita']['name'];
    }
    elseif (isset($id))
    {
        $an = "[$id] " ;
    }    
?>
<?php if (isset($id)) {$this->Html->addCrumb("Attività $an" , "/attivita/edit/$id");} ?>

<?php echo $this->Form->create('Attivita', [
		'enctype' => 'multipart/form-data',
        'inputDefaults' => [
		'div' => 'form-group',
		'label' => [
			'class' => 'col col-md-4 control-label'
		],
		'wrapInput' => 'col col-md-8',
		'class' => 'form-control'
	],	
	'class' => 'well form-horizontal'       
    ]); ?>  
    
	
 	<legend><?php echo __('Edit Attivita'); ?></legend>
	<?php        
		echo $this->Form->input('id');		
        ?>

    
    <?php        
        //Scrivo gli alias
        $alias='';
        if (isset($this->request->data['Alias']))
        {
            $alias = '<b>Alias:</b> ';
            foreach ($this->request->data['Alias'] as $a)
            {
                $alias .= $a['name'] . ' ';
            }
        }
        $alias .= '<span class="btn btn-info btn-xs">' . $this->Html->link('Aggiungi Alias', ['controller'=>'aliases','action'=>'add']) . '</span>';
    ?>           
   
    <div class="row">
        <div class="col col-md-8"><?php echo $this->Form->input('name', ['label' => ['class' => 'col col-md-2 control-label']]); ?> </div>
        <div class="col col-md-3"><?php echo $alias ?></div>
        <div class="col col-md-1">
            <?php echo $this->Form->input('chiusa', ['class'=>false, 'wrapInput' => 'col col-md-9 col-md-offset-3', 'label'=> ['class'=>false]]); ?>
        </div>        
    </div>
    
    <?php	
        echo $this->Form->input('Note', ['label' => ['class' => 'col col-md-1 control-label']]);
        echo $this->Form->hidden('azienda_id');
        echo $this->Form->hidden('cliente_id');
    ?>

    <div class="row">
        <div class="col col-md-8">
        <?php echo $this->Form->input('Persona.DisplayName',['type'=>'text', 'label' => ['class' => 'col col-md-2 control-label', 'text'=>'Cliente']]);?>
        </div>
        <div class="col col-md-2">
            <div id="add-cliente" class="btn btn-xs btn-default"><i class="fa fa-plus-square"></i> Aggiungi cliente</div>    
        </div>
        <div class="col col-md-2">
        <a href="<?php echo $this->Html->url('/persone/edit/' . $this->request->data['Persona']['id']) ?>" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-arrow-right"></i> Vai alla Scheda Cliente</a>
        </div>

    </div>
        <div class="row">
        <div class="col col-md-8 col-md-offset-1">        
        <fieldset id="dettagli-cliente" class="well">
            <label>Cliente Non In Elenco</label>            
    <?php
        echo $this->Form->input('Persona.DisplayName2', ['label' => 'Display Name']);
        echo $this->Form->input('Persona.Cognome');
        echo $this->Form->input('Persona.Nome');
        echo $this->Form->input('Persona.piva');
        echo $this->Form->input('Persona.cf');
        echo $this->Form->input('Persona.Indirizzo');
        echo $this->Form->input('Persona.Citta');
        echo $this->Form->input('Persona.Provincia');
        echo $this->Form->input('Persona.CAP');
        echo $this->Form->input('Persona.TelefonoUfficio');
        
    ?>                
        </fieldset>
        </div>
    </div>
    <br/>
    <?php
		echo $this->Form->input('progetto_id', ['class'=>'chosen-select', 'label' => ['class' => 'col col-md-1 control-label']]);		
        echo $this->Form->input('area_id', ['label' => ['class' => 'col col-md-1 control-label']]);
        ?>

       
    <div class="row">
        <div class="col-md-6">
           <div class="panel panel-cascade"> 
            <div class="panel-heading bg-primary">
             <h3 class="panel-title  text-white">Preventivo
              <span class="pull-right">
               <a href="#" class="panel-minimize"><i class="fa fa-chevron-up text-white"></i></a>
             </span>
           </h3>
         </div>
         <div class="panel-body">
             
           <?php
            echo $this->Form->input('DataPresentazione', ['type'=>'text', 'class'=> 'datepicker form-control',]);
            echo $this->Form->input('DataApprovazione', ['type'=>'text', 'class'=> 'datepicker form-control',]);
            ?>
             
            <div class="alert alert-warning ">Per il calcolo del costo dell'attività si dave 
                <b><?php echo $this->Html->link('salvare', '#', ['id'=>'salva']); ?></b>  
                l'attività corrente e 
                utilizzare la scheda <?php echo $this->Html->link('Fasi/Prodotti', ['controller' => 'faseattivita', 'action'=>'index', $id], ['escape'=>false, ]); ?>.
            </div>            
            
            <?php     
                echo $this->Form->input('OffertaAlCliente', ['value' => $offertaAlCliente, 'disabled' => true]);
                echo $this->Form->input('ImportoAcquisito');
                foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
                    if(file_exists(WWW_ROOT.'files'.DS.strtolower($this->request->controller).DS.$id.'_preventivo.'.$ext)){
                        echo '<div class="alert alert-warning">';
                        echo 'E\' già stato caricato un documento.<br />';
                        echo $this->Html->link(__('View Attachment'), HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$id.'_preventivo.'.$ext, ['title'=>'View related Attachment','class'=>'btn btn-xs btn-primary']);
                        echo '&nbsp;'; // Uso questo anche se non è bello perchè vedo che ogni tanto è già usato.
                        echo $this->Html->link(__('Delete Attachment'), ['action' => 'deleteDoc', $id], ['title'=>'Delete related Attachment','class'=>'btn btn-xs btn-primary'], __('Are you sure you want to delete %s_preventivo.%s?', $id, $ext));
                        echo '<br />Un nuovo upload sovrascriverà il vecchio allegato.';
                        echo '</div>';
                    }
                }
				echo $this->Form->input('uploadFile', ['label'=>'Upload File', 'class'=>false, 'type'=>'file']);
            ?>
            <?php echo $this->Form->submit('Salva', ['class'=>'col-md-offset-2  btn btn-primary']); ?>
         </div>
        </div> <!-- / purple Panel -->
        </div>
        
        <div class="col-md-6">
        <div class="panel panel-warning"> 
          <div class="panel-heading">
           <h3 class="panel-title  text-white">Consuntivo
            <span class="pull-right">
             <a href="#" class="panel-minimize"><i class="fa fa-chevron-up text-white"></i></a>
           </span>
         </h3>
        </div>
        <div class="panel-body">
            <?php
                echo $this->Form->input('DataInizio', ['type'=>'text', 'class'=> 'datepicker form-control',]);
                echo $this->Form->input('DataFinePrevista', ['type'=>'text', 'class'=> 'datepicker form-control',]);
                echo $this->Form->input('DataFine', ['type'=>'text', 'class'=> 'datepicker form-control',]);            
                echo $this->Form->input('Utile');
            ?>            
            <div class="pull-right">Ore Usate: <span class="label label-primary"><?php echo $oreUsate ?></span>            
            <?php if ($oreUsate>0): ?>
            Ricavo Orario (ad oggi): <span class="label label-primary"><?php echo $this->Number->currency($this->request->data['Attivita']['ImportoAcquisito']/$oreUsate ,'EUR'); ?></span>            
            <?php endif; ?>
            <br>
            <div class="pull-right">gg Usate: <span class="label label-warning"><?php echo $oreUsate/8 ?></span>            
            <?php if ($oreUsate>0): ?>
            Ricavo gg (ad oggi): <span class="label label-warning"><?php echo $this->Number->currency($this->request->data['Attivita']['ImportoAcquisito']/$oreUsate*8 ,'EUR'); ?></span>            
            <?php endif; ?>
            </div>
            <br/>
            <br/>
            <?php echo $this->Form->submit('Salva', ['class'=>'col-md-offset-2 btn btn-primary']); ?>    

        </div>
        </div> <!-- / warning Panel -->
        </div> <!-- / col-md-6 -->
    </div>    
    
    <?php echo $this->Form->end();?>

</div>
</div>


<?php $this->Html->scriptStart(['inline' => false]); ?>
$(function() {
    $( "#PersonaDisplayName" ).autocomplete({
		source: "<?php echo $this->Html->url(['controller' => 'persone', 'action' => 'autocomplete']) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#AttivitaClienteId").val( ui.item.id );
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$( "#PersonaDisplayName" ).val($(this).data("uiItem"));
		});

    $('#dettagli-cliente').hide('fast');
    $( "#add-cliente" ).click( function (e) { 
            $("#dettagli-cliente").toggle('fast'); 
            $("#PersonaDisplayName").val(null); 
            $("#AttivitaClienteId").val(null); 
            $("#PersonaDisplayName").parent().toggle('fast'); 
            });
            
    $('#salva').click (function (e) {
            $.ajax({
             type: 'POST',
             url: $('form').attr('action'),
             data: $('form').serialize(), // serializes the form's elements.
             success: function(response,textStatus,xhr){                           
                           alert('Salvato con successo');
                           window.location.replace("<?php echo $this->Html->url(['controller' => 'faseattivita', 'action'=>'index', $id], ['escape'=>false, ]); ?>");
                      }, 
             error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
              },
           });        
        });
} );

<?php $this->Html->scriptEnd(); ?>
