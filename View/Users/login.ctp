<?php echo $this->Html->css('login'); ?>

<section id="login">
    <div class="row animated fadeILeftBig">
     <div class="login-holder col-md-6 col-md-offset-3">
       <h2 class="page-header text-center text-primary"> 
        <?php echo $this->Html->image('logo-igas.png',['class'=>'img-responsive']) ?>
        Benvenuti su iGAS<br>
        <?php echo Configure::read('iGas.NomeAzienda') ?> <br>
        <small>Gestione Aziendale Semplice</small> 
        </h2>
        <?php echo $this->Form->create('User', array(
       			'url' => array('controller' => 'users', 'action' =>'login'),
				    'inputDefaults' => array(									
									'label' => false,
									'class' => 'form-control'
						)));
       	?>
        <div class="form-group">
          <?php echo $this->Form->input('User.username',
          				array('type'=> 'text', 'placeholder'=>'Nome utente o mail')); ?>
        </div>
        <div class="form-group">
          <?php echo $this->Form->input('User.password', 
          				array('type'=> 'password', 'placeholder'=>'password') );?>
        </div>
        <div class="form-footer">
	        	<div class="row">
	        	<div class="col-md-12">
              <?php echo $this->Html->link(__('Login Facebook'), '../oauth2/fbLogin', 
                    array('class'=>'btn btn-info pull-right')); ?> 
		          <?php echo $this->Html->link(__('Login Google'), '../oauth2/googleLogin', 
		          			array('class'=>'btn btn-info pull-right')); ?> 
              <?php echo $this->Form->submit('Login', array('class' => 'btn btn-info pull-right'));?>          
	          </div>
	          </div>
	          <div class="row">
	          	<div class="col-md-12">
		          <?php echo $this->Form->checkbox('remember_me'); ?> Ricordami su questo computer
		          <label>
		            <a href="<?php echo $this->Html->url('password_dimenticata')?>" >Dimenticato la Password?</a>
		          </label>
    		    	</div>
    		    </div>
        </div>
		<?php echo $this->Form->end();?>
    </div>
  </div>
</section>