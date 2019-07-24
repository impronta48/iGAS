<?php // debug($this->params->query['token']); ?>
<?php if(!$sendSuccess and !$resetPass) { ?>
<div id="login-form">
<?php echo $this->Session->flash('auth'); ?>
<h1>Recupero Password</h1>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' =>'password_dimenticata')));?>
<fieldset>
<?php echo $this->Form->input('User.username',array('label' => 'Nome utente: ','type'=> 'text')); ?>
<div class="descr">Le istruzioni per il recupero della password verranno inviate all'indirizzo email inserito</div>
<br>
</fieldset>
	<div class="submit">
	<?php echo $this->Form->end(array('label' => 'Recupera password', 'class' => 'btn btn-primary'));?>
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
<?php echo $this->Form->input('User.password', array('label' => 'Nuova Password ', 'type' => 'password')); ?>
<?php echo $this->Form->input('Conferma.password', array('label' => 'Conferma Password ', 'type' => 'password')); ?>
<?php echo $this->Form->input('Conferma.username', array('value' => $resetPass['username'], 'type' => 'hidden')); ?>
<?php echo $this->Form->input('Conferma.securestring', array('value' => $resetPass['securestring'], 'type' => 'hidden')); ?>
<?php echo $this->Form->input('Conferma.requestdate', array('value' => $resetPass['requestdate'], 'type' => 'hidden')); ?>
<?php echo $this->Form->input('Conferma.requesterToken', array('value' => $this->params->query['token'], 'type' => 'hidden')); ?>
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