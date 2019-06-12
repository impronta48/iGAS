
<div class="faseattivita form">
		<legend><?php echo __('Edit Fase Attivita'); ?></legend>        
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
                
                )); ?>  
            <?php echo $this->Form->hidden('id');?>
            <?php echo $this->Form->hidden('old_venduto', array('default' => $this->request->data['Faseattivita']['vendutou']));?>
            <?php echo $this->Form->hidden('old_qta', array('default' => $this->request->data['Faseattivita']['qta']));?>
            <?php echo $this->Form->input('attivita_id', array('class'=>'chosen-select'));?>
            <?php echo $this->Form->input('entrata', array('options' => array(0 =>'Uscita', 1 => 'Entrata')) );?>
            <?php echo $this->Form->input('Descrizione');?>
            <?php echo $this->Form->input('entrata', array('options' => array(0 =>'Uscita', 1 => 'Entrata'), 'label'=> 'Tipo di fase') );?>
            <?php echo $this->Form->hidden('cespite_id',array('type'=>'text')); ?>
            <?php echo $this->Form->input('Cespite.DisplayName', array('type'=>'text', 'label' => 'Cespite Associato', 'required' => false));?>
            <?php echo $this->Form->input('qta');?>
            <?php echo $this->Form->input('um');?>
            <?php echo $this->Form->hidden('persona_id', array('type'=>'text')); ?>
            <?php echo $this->Form->input('Persona.DisplayName', array('type'=>'text', 'label' => 'Persona')); ?>
            <?php echo $this->Form->input('costou', array('label'=> 'Costo Unità'));?>
            <?php echo $this->Form->input('vendutou', array('label'=> 'Venduto Unità'));?>       
            <!--
            echo $this->Form->input('sc1');
            echo $this->Form->input('sc2');
            echo $this->Form->input('sc3');
            -->
            <?php echo $this->Form->input('legenda_codici_iva_id', array('options'=>$legendaCodiceiva, 'default'=>Configure::read('iGas.IvaDefault')));?>
            
            <?php echo $this->Form->input('legenda_stato_attivita_id');?>
            <?php echo $this->Form->input('note', array('type'=>'text'));?>
            <?php
            $id = $this->request->data['Faseattivita']['id'];
            $aid = $this->request->data['Faseattivita']['attivita_id'];
            foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
                if(file_exists(WWW_ROOT.'files'.DS.strtolower($this->request->controller).DS.$aid.'_'.$id.'.'.$ext)){
                    echo '<div class="alert alert-warning">';
                    echo 'E\' già stato caricato un documento.<br />';
                    echo $this->Html->link(__('View Attachment'), HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$aid.'_'.$id.'.'.$ext, array('title'=>'View related Attachment','class'=>'btn btn-xs btn-primary'));
                    echo '&nbsp;'; // Uso questo anche se non è bello perchè vedo che ogni tanto è già usato.
                    echo $this->Html->link(__('Delete Attachment'), array('action' => 'deleteDoc', $aid, $id), array('title'=>'Delete related Attachment','class'=>'btn btn-xs btn-primary'), __('Are you sure you want to delete %s_preventivo.%s?', $id, $ext));
                    echo '<br />Un nuovo upload sovrascriverà il vecchio allegato.';
                    echo '</div>';
                }
            }
            echo $this->Form->input('uploadFile', array('label'=>'Upload File', 'class'=>false, 'type'=>'file'));
            ?>
            <div class="col col-md-offset-3">
                <?php echo  $this->Form->button('Salva',array('class'=>'btn btn-primary', )); ?>
            </div>
            <?php echo  $this->Form->end(); ?>
        

</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() { 
    $( "#PersonaDisplayName" ).autocomplete({
		source: "<?php echo $this->Html->url(array('controller' => 'persone', 'action' => 'autocomplete')) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
            $("#FaseattivitaPersonaId").val(ui.item.id);
                $(this).data("uiItem",ui.item.value);
                //alert(ui.item.value);
                console.log(ui.item);
                //DIALOG DI CONFERMA
                if($("#FaseattivitaCostou").val()=="")
                    $("#FaseattivitaCostou").val(ui.item.costoU);
                else
                {
                    var domanda = confirm("Vuoi sostituire il valore di Costo Unità presente con quello di "+ui.item.value+"?");
                    if (domanda === true)
                        $("#FaseattivitaCostou").val(ui.item.costoU); 
                }
                if($("#FaseattivitaVendutou").val()=="")
                    $("#FaseattivitaVendutou").val(ui.item.vendutoU);
                else
                {
                    var domanda = confirm("Vuoi sostituire il valore di Venduto Unità presente con quello di "+ui.item.value+"?");
                    if (domanda === true)
                        $("#FaseattivitaVendutou").val(ui.item.vendutoU); 
                }
	}).bind("blur",function(){
			$( "#PersonaDisplayName" ).val($(this).data("uiItem"));
	});

    $("#CespiteDisplayName").autocomplete({
		source: "<?php echo $this->Html->url(array('controller' => 'cespiti', 'action' => 'autocomplete')) ?>",
		minLength: 2,
		mustMatch : true,
		select: function( event, ui ) {
				$("#FaseattivitaCespiteId").val( ui.item.id );
                $("#FaseattivitaCostou").val( ui.item.defaultPrice );
                $("#FaseattivitaUm").val('gg');
                $(this).data("uiItem",ui.item.value);
                console.log(ui.item.value);
            }
    }).bind("blur",function(){
			$( "#CespiteDisplayName" ).val($(this).data("uiItem"));
	});
});
<?php $this->Html->scriptEnd(); ?>
