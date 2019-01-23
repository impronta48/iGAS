
<div class="faseattivita form">
		<legend><?php echo __('Edit Fase Attivita'); ?></legend>        
            <?php echo $this->Form->create('Faseattivita',array(
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
            <?php echo $this->Form->input('attivita_id', array('class'=>'chosen-select'));?>
            <?php echo $this->Form->input('entrata', array('options' => array(0 =>'Uscita', 1 => 'Entrata')) );?>
            <?php echo $this->Form->input('Descrizione');?>
            
            <?php echo $this->Form->input('qta');?>
            <?php echo $this->Form->input('um');?>
            <?php echo $this->Form->input('costou');?>
            <?php echo $this->Form->input('sc1');?>
            <?php echo $this->Form->input('sc2');?>
            <?php echo $this->Form->input('sc3');?>

            <?php echo $this->Form->input('legenda_codici_iva_id', array('options'=>$legendaCodiceiva, 'default'=>Configure::read('iGas.IvaDefault')));?>
        
            <?php echo $this->Form->hidden('persona_id',array('type'=>'text')); ?>
            <?php echo $this->Form->input('Persona.DisplayName',array('type'=>'text', 'label' => 'Persona')); ?>
                        
            <?php echo $this->Form->input('legenda_stato_attivita_id');?>
            <?php echo $this->Form->input('note', array('type'=>'text'));?>
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
				$("#FaseattivitaPersonaId").val( ui.item.id );
				$(this).data("uiItem",ui.item.value);
			}
	}).bind("blur",function(){
			$( "#PersonaDisplayName" ).val($(this).data("uiItem"));
		});

} );
<?php $this->Html->scriptEnd(); ?>
