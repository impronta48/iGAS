<h2>Riclassifica la prima nota
    <?php
        $anni = Configure::read('Fattureemesse.anni');  
        for ($i=date('Y')-$anni; $i<=date('Y'); $i++)
        {
            $condition['anno'] = $i;            
    ?>
        <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url($condition ) ?>">
            <?php echo $i ?>
        </a>        
    <?php
        }       
    ?>       
</h2>

<?php echo $this->Form->create(); ?>
<?php echo $this->Form->submit('Salva'); ?>

<table class="table dataTable table-striped display"> 
<thead>
	<tr>
		<th><?php echo $this->Paginator->sort('Primanota.data'); ?></th>
		<th>Descr</th>
		<th>importo</th>
		<th>attività</th>
		<th>contatto</th>
		<th>tipo</th>
		<th>banca</th>
	</tr>
</thead>

<tbody>
<?php $pn = $this->data; $i=0; foreach($pn as  $n) :  $i++?>
	<tr>
	<td width="10%"><?php echo $n['Primanota']['data'] ?></td>
	<td width="15%"><?php echo $n['Primanota']['Descr'] ?></td>

    <td width="10%" align="right">
            <?php
                echo $this->Number->Precision($n['Primanota']['importo'],2);
            ?>
    </td>

	<td width="15%">
                <?php     
                echo $this->Form->input("Primanota.$i.attivita_id", 
                array('options'=> $attivita, 
                      'label' =>false,
                      'selected' => $n['Primanota']['attivita_id'],
                      'class' => 'chosen-select',
                )); ?>

    </td>
	<td width="10%"><?php echo $n['Persona']['DisplayName'] ?></td>

	<td width="10%"><?php 
                echo $this->Form->hidden("Primanota.$i.id", array('value'=>$n['Primanota']['id'] ));
                echo $this->Form->input("Primanota.$i.legenda_cat_spesa_id", 
                array('options'=> $legenda_cat_spesa, 
                      'label' =>false,
                      'selected' => $n['Primanota']['legenda_cat_spesa_id'],
                )); ?>
    </td>
	<td width="10%"><?php echo $n['Provenienzasoldi']['name'] ?></td>

	</tr>
<?php endforeach; ?>
</tbody>
<tfoot>
	<tr>
		<th>data</th>
		<th>descr</th>
        <th>importo</th>
		<th>attività</th>
		<th>contatto</th>
		<th>tipo</th>
		<th>banca</th>
	</tr>
</tfoot>
</table>
<?php echo $this->Paginator->pagination(array(
    'ul' => 'pagination'
)); ?>
<?php echo $this->Form->end('Salva') ?>

