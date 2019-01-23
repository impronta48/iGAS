<div class="attivita form">
<?php if (isset($this->request->params['pass'][0]))
    {
        $id = $this->request->params['pass'][0];
        echo $this->element('secondary_attivita', array('aid'=>$id)); 
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

<?php echo $this->Form->create('Attivita', array(
        'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-4 control-label'
		),
		'wrapInput' => 'col col-md-8',
		'class' => 'form-control'
	),	
	'class' => 'well form-horizontal'       
    )); ?>  
    
	
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
        $alias .= '<span class="btn btn-info btn-xs">' . $this->Html->link('Aggiungi Alias', array('controller'=>'aliases','action'=>'add')) . '</span>';
    ?>           
   
    <div class="row">
        <div class="col col-md-8"><?php echo $this->Form->input('name', array('label' => array('class' => 'col col-md-2 control-label'))); ?> </div>
        <div class="col col-md-3"><?php echo $alias ?></div>
        <div class="col col-md-1">
            <?php echo $this->Form->input('chiusa', array('class'=>false, 'wrapInput' => 'col col-md-9 col-md-offset-3', 'label'=> array('class'=>false))); ?>
        </div>        
    </div>
    
    <?php	
        echo $this->Form->input('Note', array('label' => array('class' => 'col col-md-1 control-label')));
        echo $this->Form->hidden('azienda_id');
        echo $this->Form->hidden('cliente_id');
    ?>

    <div class="row">
        <div class="col col-md-8">
        <?php echo $this->Form->input('Persona.DisplayName',array('type'=>'text', 'label' => array('class' => 'col col-md-2 control-label', 'text'=>'Cliente')));?>
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
        echo $this->Form->input('Persona.DisplayName2', array('label' => 'Display Name'));
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
		echo $this->Form->input('progetto_id', array('class'=>'chosen-select', 'label' => array('class' => 'col col-md-1 control-label')));		
        echo $this->Form->input('area_id', array('label' => array('class' => 'col col-md-1 control-label')));
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
            echo $this->Form->input('DataPresentazione', array('type'=>'text'));
            echo $this->Form->input('DataApprovazione', array('type'=>'text'));
            ?>
             
            <div class="alert alert-warning ">Per il calcolo del costo dell'attività si dave 
                <b><?php echo $this->Html->link('salvare', '#', array('id'=>'salva')); ?></b>  
                l'attività corrente e 
                utilizzare la scheda <?php echo $this->Html->link('Fasi/Prodotti', array('controller' => 'faseattivita', 'action'=>'index', $id), array('escape'=>false, )); ?>.
            </div>            
            
            <?php     
                echo $this->Form->input('OffertaAlCliente');
                echo $this->Form->input('ImportoAcquisito');
            ?>
            <?php echo $this->Form->submit('Salva', array('class'=>'col-md-offset-2  btn btn-primary')); ?>
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
                echo $this->Form->input('DataInizio', array('type'=>'text'));
                echo $this->Form->input('DataFinePrevista', array('type'=>'text'));
                echo $this->Form->input('DataFine', array('type'=>'text'));            
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
            <?php echo $this->Form->submit('Salva', array('class'=>'col-md-offset-2 btn btn-primary')); ?>    

        </div>
        </div> <!-- / warning Panel -->
        </div> <!-- / col-md-6 -->
    </div>    
    
    <?php echo $this->Form->end();?>

</div>
</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() {
    $( "#PersonaDisplayName" ).autocomplete({
		source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#AttivitaClienteId").val( ui.item.id );
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$( "#PersonaDisplayName" ).val($(this).data("uiItem"));
		});

	$( "#AttivitaDataPresentazione" ).datepicker( { dateFormat: 'yy-mm-dd' });
	$( "#AttivitaDataApprovazione" ).datepicker( { dateFormat: 'yy-mm-dd' });
	$( "#AttivitaDataInizio" ).datepicker( { dateFormat: 'yy-mm-dd' });
	$( "#AttivitaDataFine" ).datepicker( { dateFormat: 'yy-mm-dd' });
	$( "#AttivitaDataFinePrevista" ).datepicker( { dateFormat: 'yy-mm-dd' });

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
                           window.location.replace("<?php echo $this->Html->url(array('controller' => 'faseattivita', 'action'=>'index', $id), array('escape'=>false, )); ?>");
                      }, 
             error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
              },
           });        
        });
} );

<?php $this->Html->scriptEnd(); ?>
