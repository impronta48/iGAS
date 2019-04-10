<?php echo $this->Html->script("jquery.tagsinput.min",array('inline' => false)); ?>
<?php echo $this->Html->script('tags',array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.tagsinput'); ?>
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>
<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?> 
 
<div class="primanota form">
		<legend><?php echo __('Edit Prima Nota'); ?></legend>        
            <?php echo $this->Form->create('Primanota',array(
								'enctype' => 'multipart/form-data',
                                'inputDefaults' => array(
                                    'div' => 'form-group',
                                    'label' => array(
                                        'class' => 'col col-md-3 control-label'
                                    ),
                                    'wrapInput' => 'col col-md-4',
                                    'class' => $baseformclass,
                                ),	
                                'class' => 'well form-horizontal',
                
                )); ?>  
        
            <?php echo  $this->Form->input('id'); ?>
            <?php echo  $this->Form->input('data', array('type'=>'date', 'class'=>false, 'dateFormat'=>'DMY')); ?>            
            <?php   if (!isset($this->request->data['Primanota']['importo']))
            		{
            			$importo = 0;
            		}
            		else{
            			$importo =$this->request->data['Primanota']['importo'];	
            		}            		
                    if ($importo>0)
                    {
                        echo  $this->Form->input('importoEntrata', array('placeholder'=>'10.2', 'label'=>'Entrata', 'wrapInput' => 'col col-md-2','default'=>$importo));
                        echo  $this->Form->input('importoUscita', array('placeholder'=>'10.2', 'label'=>'Uscita', 'wrapInput' => 'col col-md-2'));       
                    }
                    else
                    {
                        echo  $this->Form->input('importoEntrata', array('placeholder'=>'10.2', 'label'=>'Entrata', 'wrapInput' => 'col col-md-2'));
                        echo  $this->Form->input('importoUscita', array('placeholder'=>'10.2', 'label'=>'Uscita', 'wrapInput' => 'col col-md-2','default'=>-$importo));       
                    }            
            ?>
            <?php             
                if (!empty($id))
                {
                    echo $this->Form->hidden('attivita_id', array('default'=>$id)); 
                }
                else
                {
                    echo $this->Form->input('attivita_id', array('class'=>'attivita chosen-select' . $baseformclass));  //array('class'=>'chosen-select')
                }                
            ?>
            <?php echo  $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'options'=>$faseattivita, 'class' => 'fase ' . $baseformclass)); ?> 
            <?php echo  $this->Form->input('legenda_cat_spesa_id', array('options'=>$legenda_cat_spesa)); ?>
            <?php echo  $this->Form->input('provenienzasoldi_id'); ?>           
                <div class="row">   
                    <div class="">
                        <?php echo $this->Form->input('tags', array('class'=>'dest-suggestion form-control tagsinput'));?>                        
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <h5>Tag disponibili: <i class="fa fa-arrow-up"></i></h5> 
                        <?php foreach($taglist as $t): ?>
                           <div class="btn btn-xs btn-default tag-suggestion"><?php echo $t ?></div>
                        <?php endforeach; ?>                        
                    </div>                   
               </div>                       
               <br>
            <?php echo  $this->Form->hidden('persona_id',array('type'=>'text')); ?>           
            <?php echo  $this->Form->input('persona_descr'); ?>           
            <?php echo  $this->Form->input('descr'); ?>           
                                              
            
            <div  id="aggiungi-fattura-emessa" class="scomparsa">
                <?php echo  $this->Form->input('fatturaemessa_id', array('label'=>'Fattura Emessa', 'options'=>$fatturaemessa)); ?> 
            </div>
            <div id="aggiungi-fattura-ricevuta" class="scomparsa">
                <?php echo  $this->Form->input('fatturaricevuta_id', array('label'=>'Fattura Ricevuta', 'options'=>$fatturaricevuta)); ?> 
            </div>
			<?php
			if(file_exists(WWW_ROOT.'files/'.$this->request->controller.'/'.$this->request->data['Primanota']['id'].'.pdf')):
					echo 'E\' già stato caricato un documento. ';
					echo $this->Html->link('Download this PDF', HTTP_BASE.'/'.APP_DIR.'/files/'.$this->request->controller.'/'.$this->request->data['Primanota']['id'].'.pdf', array('class'=>'btn btn-xs btn-primary'));
					echo '&nbsp;'; // Uso questo anche se non è bello perchè vedo che ogni tanto è già usato.
					echo $this->Html->link(__('Delete this PDF'), array('action' => 'deleteDoc', $this->request->data['Primanota']['id']), array('class'=>'btn btn-xs btn-primary'), __('Are you sure you want to delete %s_preventivo.pdf?', $this->request->data['Primanota']['id']));
					echo '<br />Un nuovo upload sovrascriverà il vecchio documento.';
				endif;
			echo $this->Form->input('uploadFile', array('label'=>'Upload File PDF', 'class'=>false, 'type'=>'file'));
			?>
            
            <?php echo  $this->Form->end('Salva'); ?>
        </div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>    
$(function() {
     $( "#PrimanotaPersonaDescr" ).autocomplete({
		source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#PrimanotaPersonaId").val( ui.item.id );
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$( "#PrimanotaPersonaDescr" ).val($(this).data("uiItem"));
		});
  
});

<?php $this->Html->scriptEnd();