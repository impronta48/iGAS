<?php echo $this->Form->create('User',['action'=>'modify_password']);?>
<?php
        echo $this->Form->input('id');
        echo $this->Form->input("vecchia password", ['size' => 20,
'type'=>'password']);
        echo $this->Form->input('nuova password', ['size' =>
20,'type'=>'password']);
        echo $this->Form->input('conferma password', ['size' =>
20,'type'=>'password']);
        echo $this->Form->submit('Cambia');?>
</form>

