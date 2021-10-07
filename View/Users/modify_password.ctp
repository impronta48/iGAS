<?php echo $this->Form->create('User',array('action'=>'modify_password'));?>
<?php
        echo $this->Form->input('id');
        echo $this->Form->input("vecchia password", array('size' => 20,
'type'=>'password'));
        echo $this->Form->input('nuova password', array('size' =>
20,'type'=>'password'));
        echo $this->Form->input('conferma password', array('size' =>
20,'type'=>'password'));
        echo $this->Form->submit('Cambia');?>
</form>

