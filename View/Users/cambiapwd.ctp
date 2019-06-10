<br>
<br>
<div class="panel panel-default">
<div class="panel-heading">Modifica password di <?php echo $givenUserName; ?></div>
<div class="panel-body">
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
                                )); 
?>
<?php
        echo $this->Form->input('User.id');
        if(($this->Session->read('Auth.User.group_id') == 1) and ($this->Session->read('Auth.User.id') == $givenUserId)){
            // Se sei admin l'input per la vecchia password verrà mostrato solo se stai cercando di modificare la tua password
            echo $this->Form->input("vecchia_password", array('size' => 20, 'type'=>'password'));
        } else if ($this->Session->read('Auth.User.group_id') != 1){
            // Se non sei admin l'input per la vecchia password verrà sempre mostrato
            echo $this->Form->input("vecchia_password", array('size' => 20, 'type'=>'password'));
        }
        echo $this->Form->input('nuova_password', array('size' => 20,'type'=>'password'));
        echo $this->Form->input('conferma_password', array('size' => 20,'type'=>'password'));
?>
        <div class="row">
        <?php echo $this->Form->submit(__('Cambia Password'), array('class'=>'btn btn-primary', 'div' => false)); ?>
        
        <?php echo $this->Form->reset(__('Reset'), array('class'=>'btn btn-warning', 'div' => false)); ?>
        </div>
        <?php echo $this->Form->end(); ?>

</div>
</div>

