<?php 
	$mesi[] = array();

	for($i = 1; $i <= 12; $i++) {
		$mesi[$i] = $i;
	}
?>

<div class="notaspese view">
<h2>Seleziona un Collaboratore Frequente</h2>
<br>
<table class="table table-striped">

<tr>
	<th>Persone</th>
	<th>Anno</th>
	<th>Mese</th>
	<th>Seleziona</th>
</tr>

<?php foreach ($persone as $p) { ?>
    <tr>
		<?php echo $this->Form->create('Notaspesa' , array('type' => 'get', 'url' => array('action' => 'add'))); ?>    	
    	<td><?php echo $p['Persona']['Nome'].' '.$p['Persona']['Cognome']; ?>
    		<?php echo $this->Form->hidden('persona', array('default'=>$p['Persona']['id'])) ?>
    	</td>

			<td><?php echo $this->Form->input(__('anno'), array('default' => date('Y'), 'label'=>false, 'class' => 'form-control')); ?></td>
			<td><?php echo $this->Form->input(__('mese'), array('options'=> $mesi, 'label' => false, 'default' => date('m'), 'class' => 'form-control')); ?></td>
     	<td><?php echo $this->Form->submit(__('Seleziona'), array('class' => 'btn btn-sm btn-primary', 'title' => 'Seleziona Collaboratore'));?></td>
     	</form>
    </tr>
<?php } ?>

</table>

<h2>Oppure uno dall'elenco</h2>

<?php  
	echo $this->Form->create('Notaspesa');
	echo $this->Form->input('eRisorsa', array('options'=> $eRisorsa, 'label'=>'Risorse', 'class' => 'chosen-select'));
	echo $this->Form->submit(__('Avanti'), array('class' => 'btn btn-sm btn-primary', 'title' => 'Seleziona Collaboratore'));
	//echo $this->Form->end(__('Avanti'), array('class' => 'btn btn-sm btn-primary', 'title' => 'Seleziona Collaboratore'));
?>
</div>
