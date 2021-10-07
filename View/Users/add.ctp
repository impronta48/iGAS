<h1>Aggiungi Utente</h1>
<?php echo $this->Form->create('Users', array('type' => 'post', 
                                'inputDefaults' => array(
                                    'div' => 'form-group',
                                    'label' => array(
                                    'class' => 'col col-md-2 control-label'
                                    ),
                                    'wrapInput' => 'col col-md-4',
                                    'class' => 'form-control'
                                    ),  
                                    'class' => 'well form-horizontal'        
                                )); ?>
<FIELDSET>
<?php echo $this->Form->input('User.username'); ?>
<?php echo $this->Form->input('User.password'); ?>
<?php echo $this->Form->input('User.group_id'); ?>
<?php echo $this->Form->input('User.persona_id', array('class'=>'chosen-select form-control', 'label'=>'Associa ad un contatto', 'options'=>$persone)); ?>
</FIELDSET>
<div class="row">
<?php echo $this->Form->submit(__('Salva Modifiche'), array('class'=>'btn btn-primary', 'div' => false)); ?>

<?php echo $this->Form->reset(__('Reset'), array('class'=>'btn btn-warning', 'div' => false)); ?>
</div>
<?php echo $this->Form->end(); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() {

	$("#UsersReset").on('click', function() { 
        $(".chosen-select").val('').trigger("chosen:updated");
    });

});
<?php $this->Html->scriptEnd(); ?>