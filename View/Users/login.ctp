<?php echo $this->Html->css('login'); ?>

<div class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel ">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $this->Html->image('logo-igas.png',['class'=>'img-responsive']) ?>
                </div>

            </div>
        </div>

        <div style="padding-top:30px" class="panel-body">

            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

            <?php echo $this->Form->create('User', array(
       			'url' => array('controller' => 'users', 'action' =>'login'),
				    'inputDefaults' => array(									
									'label' => false,
									'class' => 'form-horizontal',
									'id' => 'loginform',
									'role' => 'form',
						)));
       			?>


            <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <?php echo $this->Form->input('User.username',
          				array('type'=> 'text', 'placeholder'=>'Nome utente o mail')); ?>
            </div>

            <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <?php echo $this->Form->input('User.password', 
          				array('type'=> 'password', 'placeholder'=>'password') );?>

            </div>



            <div class="input-group">

                <?php echo $this->Form->checkbox('remember_me',['checked'=>true]); ?> Ricordami su questo computer

            </div>


            <div style="margin-top:10px" class="form-group">
                <!-- Button -->

                <div class="col-sm-12 controls">
                    <?php echo $this->Html->link(__('Login Facebook'), '../oauth2/fbLogin', 
                    				array('class'=>'btn btn-info pull-right', 'id'=>"btn-fblogin")); ?>
                    <?php echo $this->Form->submit('Login', array('class' => 'btn btn-success pull-right','id'=>"btn-login"));?>
                </div>
            </div>

            <?php echo $this->Form->end();?>



		</div>
		
		<div class="panel-footer">
		<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="<?php echo $this->Html->url('password_dimenticata')?>">Dimenticato la
                                    Password?</a>
		</div>
	
    </div>
</div>
</div>