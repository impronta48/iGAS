<div class="ore form">
<h2>Caricamento fogli ore</h2>

<?php echo $this->Form->create('Ora', ['type' => 'file'] );?>
<fieldset>
<legend>Seleziona i file da elaborare</legend>
<?php
    echo $this->Form->input('file.', ['type' => 'file', 'multiple']);
?>
</fieldset>
<?php echo $this->Form->end('Procedi');?>
</div>