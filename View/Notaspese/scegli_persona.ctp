<?php 
	$mesi[] = [];

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

<?php foreach ($persone as $p => $name) { ?>
    <tr>
		<?= $this->Form->create('Notaspesa' , ['type' => 'get', 'url' => ['action' => 'add']]); ?>    	
    	<td><?= $name ?>
    		<?= $this->Form->hidden('persona', ['default'=>$p]) ?>
    	</td>

			<td><?= $this->Form->input(__('anno'), ['default' => date('Y'), 'label'=>false, 'class' => 'form-control']); ?></td>
			<td><?= $this->Form->input(__('mese'), ['options'=> $mesi, 'label' => false, 'default' => date('m'), 'class' => 'form-control']); ?></td>
     	<td><?= $this->Form->submit(__('Seleziona'), ['class' => 'btn btn-sm btn-primary', 'title' => 'Seleziona Collaboratore']);?></td>
     	</form>
    </tr>
<?php } ?>

</table>
</div>
