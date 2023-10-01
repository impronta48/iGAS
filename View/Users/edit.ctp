<h1>Modifica Utente</h1>
<?php echo $this->Form->create('Users', ['type' => 'post', 
                                'inputDefaults' => [
                                    'div' => 'form-group',
                                    'label' => [
                                    'class' => 'col col-md-2 control-label'
                                    ],
                                    'wrapInput' => 'col col-md-4',
                                    'class' => 'form-control'
                                    ],  
                                    'class' => 'well form-horizontal'        
                                ]); ?>
<FIELDSET>
<?php echo $this->Form->input('User.username'); ?>
<?php //echo $this->Form->input('User.password', array('default'=>null)); ?>
<?php echo $this->Form->input('User.group_id'); ?>
<?php echo $this->Form->input('User.persona_id', ['class'=>'chosen-select form-control', 'label'=>'Associa ad un contatto', 'options'=>$persone]); ?>
<?php echo $this->Form->hidden('User.id'); ?>
</FIELDSET>
<div class="row">
<?php echo $this->Form->submit(__('Salva Modifiche'), ['class'=>'btn btn-primary', 'div' => false]); ?>

<?php echo $this->Form->reset(__('Reset'), ['class'=>'btn btn-warning', 'div' => false]); ?>
<br>
<br>
<?php echo $this->html->link(__('Modifica password'),
    ['controller' => 'users', 'action' => 'cambiapwd', $this->request->data['User']['id']],
    ['class' => 'btn btn-primary', 'target' => '_blank', 'title' => __('Modifica password')]); 
?>
</div>
<?php echo $this->Form->end(); ?>
<?php $this->Html->scriptStart(['inline' => false]); ?>
$(function() {

	$("#UsersReset").on('click', function() { 
        $(".chosen-select").val(<?php echo ($this->request->data['User']['persona_id']) ? $this->request->data['User']['persona_id'] : 0; ?>).trigger("chosen:updated");
    });

});
<?php $this->Html->scriptEnd(); ?>