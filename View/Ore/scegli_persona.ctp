<div class="ore view">
<h2>Scegli un collaboratore frequente</h2>
<table class="table table-striped">
<th>Persone</th>

<?php foreach ($persone as $p) { ?>
    <tr>
        <td>
    <?php echo $this->Html->link($p['Persona']['Nome'] . ' ' . $p['Persona']['Cognome'], array('action' => 'scegli_mese', $p['Persona']['id'])); ?>
        </td>
    </tr>
<?php } ?>

</table>

<h2>Oppure uno dall'elenco</h2>

<?php echo $this->Form->create('Ora');?>
	<?php	echo $this->Form->input('eRisorsa',array('options'=> $eRisorsa, 'label'=>'Risorse', 'class'=> 'chosen-select')); ?>
<?php echo $this->Form->end(__('Avanti'));?>
</div>
