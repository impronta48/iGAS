<?php if(!$sendSuccess and !$resetPass) { ?>
<?php echo $this->Session->flash('auth'); ?>
<div class="panel panel-default">
<div class="panel-heading">Recupero Password</div>
<div class="panel-body">
<?php 
echo $this->Form->create('User', array('type' => 'post', 
                                'inputDefaults' => array(
                                    'div' => 'form-group',
                                    'label' => array(
                                    'class' => 'col col-md-2 control-label'
                                    ),
                                    'wrapInput' => 'col col-md-4',
                                    'class' => 'form-control'
									),  
									'url' => array('controller' => 'users', 'action' => 'password_dimenticata'),
                                    'class' => 'well form-horizontal'        
								)); 
?>
<?php //echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' =>'password_dimenticata')));?>
<fieldset>
<?php echo $this->Form->input('User.username',array('label' => 'Nome utente: ','type'=> 'text', 'value' => '', 'required' => true)); ?>
<div class="descr">Le istruzioni per il recupero della password verranno inviate all'indirizzo email inserito</div>
<br>
</fieldset>
<div class="row">
<?php echo $this->Form->submit(__('Recupera Password'), array('class'=>'btn btn-primary', 'div' => false)); ?>
        
<?php echo $this->Form->reset(__('Reset'), array('class'=>'btn btn-warning', 'div' => false)); ?>
</div>
<?php echo $this->Form->end(); ?>
</div>
</div>
<?php } else if ($resetPass) { ?>
<div class="panel panel-default">
<div class="panel-heading">Imposta una nuova Password</div>
<div class="panel-body">
<?php 
echo $this->Form->create('User', array('type' => 'post', 
                                'inputDefaults' => array(
                                    'div' => 'form-group',
                                    'label' => array(
                                    'class' => 'col col-md-2 control-label'
                                    ),
                                    'wrapInput' => 'col col-md-4',
                                    'class' => 'form-control'
									),  
									'url' => array('controller' => 'users', 'action' => 'password_dimenticata', 'setnew'),
                                    'class' => 'well form-horizontal'        
								)); 
?>
<fieldset>
<?php echo $this->Form->input('User.id', array('value' => $resetPass['uid'])); ?>
<?php echo $this->Form->input('User.password', array('label' => 'Nuova Password ', 'type' => 'password', 'placeholder' => 'password', 'pattern' => '.{5,}', 'required' => true)); ?>
<?php echo $this->Form->input('Conferma.password', array('label' => 'Conferma Password ', 'type' => 'password', 'placeholder' => 'ripeti nuova password', 'pattern' => '.{5,}', 'required' => true)); ?>
<?php echo $this->Form->input('Conferma.username', array('value' => $resetPass['username'], 'type' => 'hidden')); ?>
<?php echo $this->Form->input('Conferma.securestring', array('value' => $resetPass['securestring'], 'type' => 'hidden')); ?>
<?php echo $this->Form->input('Conferma.requestdate', array('value' => $resetPass['requestdate'], 'type' => 'hidden')); ?>
<?php echo $this->Form->input('Conferma.requesterToken', array('value' => $this->params->query['token'], 'type' => 'hidden')); ?>
<div class="descr">* La password deve avere minimo 5 caratteri</div>
<br>
</fieldset>
<div class="row">
<?php echo $this->Form->submit(__('Cambia Password'), array('class'=>'btn btn-primary', 'div' => false)); ?>
        
<?php echo $this->Form->reset(__('Reset'), array('class'=>'btn btn-warning', 'div' => false)); ?>
</div>
<?php echo $this->Form->end(); ?>
</div>
</div>
<?php } ?>

<?php if($finalSuccess) { ?>
<?php echo $this->Html->link(__('Pagina Login'), '/users/login', array('class' => 'btn btn-primary', 'title' => 'Clicca qua per loggarti con la nuova password')); ?>
<?php } ?>