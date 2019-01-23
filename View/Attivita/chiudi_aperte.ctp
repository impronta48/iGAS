
<h1>Attività da chiudere</h1>

<?php echo $this->Form->create() ?>
<?php echo $this->Form->submit(); ?>
<table class="table dataTable table-striped display"> 
<thead>
	<tr>
		<th>Id</th>
		<th>Nome</th>
		<th>Chiusa</th>
		<th>importo acquisito</th>
		<th>data presentazione</th>
		<th>data approvazione</th>
		<th>data inizio</th>
		<th>data fine prevista</th>
		<th>data fine</th>
	</tr>
</thead>

<tbody>
<?php $attivita = $this->data; $i=0; foreach($attivita as  $n) :  $i++?>
    <tr>
        <td width="10%"><?php echo $n['Attivita']['id']; echo $this->Form->hidden("Attivita.$i.id", array('value'=>$n['Attivita']['id'] )); ?></td>
        <td width="15%"><?php echo $n['Attivita']['name'] ?></td>
        <td width="10%" align="right">
            <?php
                echo $this->Number->Precision($n['Attivita']['ImportoAcquisito'],0);
            ?>
        </td>        
        <td><?php echo $this->Form->input("Attivita.$i.chiusa", array('checked'=>'checked')); ?></td>
        <td><?php echo $n['Attivita']['DataPresentazione'] ?></td>
        <td><?php echo $n['Attivita']['DataApprovazione'] ?></td>
        <td><?php echo $n['Attivita']['DataInizio'] ?></td>
        <td><?php echo $n['Attivita']['DataFinePrevista'] ?></td>
        <td><?php echo $n['Attivita']['DataFine'] ?></td>
    </tr>

<?php endforeach; ?>
</table>
<?php echo $this->Form->end('salva');


