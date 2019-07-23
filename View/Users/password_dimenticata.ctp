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
Qua ci va il form per impostare la nuova password.
<?php } ?>