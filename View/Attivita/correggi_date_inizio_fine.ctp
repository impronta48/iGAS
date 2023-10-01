
<h1>Correggere le date di inizio e fine di queste attività</h1>

<?php echo $this->Form->create() ?>
<?php echo $this->Form->submit(); ?>
<table class="table dataTable table-striped display"> 
<thead>
	<tr>
		<th>Id</th>
		<th>Nome</th>
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
        <td width="10%"><?php echo $n['Attivita']['id']; echo $this->Form->hidden("Attivita.$i.id", ['value'=>$n['Attivita']['id'] ]); ?></td>
        <td width="15%"><?php echo $n['Attivita']['name'] ?></td>
        <td width="10%" align="right">
            <?php
                echo $this->Number->Precision($n['Attivita']['ImportoAcquisito'],0);
            ?>
        </td>        

        <?php if( empty($n['Attivita']['DataPresentazione']) )
            {
                if (isset($primadata[$n['Attivita']['id']]))
                {
                    $v = $primadata[$n['Attivita']['id']];
                    $c = 'input-red';
                }
                else
                {
                    $v ='';
                    $c ='';
                }
            }
            else
            {
                $v = $n['Attivita']['DataPresentazione'];
                $c ='';
            }
        ?>        
        <td width="15%"> <?php echo $this->Form->input("Attivita.$i.DataPresentazione", ['value'=>$v, 'type'=>'text', 'class'=>$c ]); ?>        </td>        
        
        <?php if( empty($n['Attivita']['DataApprovazione']) )
            {
                if (isset($primadata[$n['Attivita']['id']]))
                {
                    $v = $primadata[$n['Attivita']['id']];
                    $c = 'input-red';
                }
                else
                {
                    $v ='';
                    $c ='';
                }
            }
            else
            {
                $v = $n['Attivita']['DataApprovazione'];
                $c ='';
            }
        ?>
        <td width="15%"> <?php echo $this->Form->input("Attivita.$i.DataApprovazione", ['value'=>$v, 'type'=>'text', 'class'=>$c ]); ?>        </td>

        <?php if( empty($n['Attivita']['DataInizio']) )
            {
                if (isset($primadata[$n['Attivita']['id']]))
                {
                    $v = $primadata[$n['Attivita']['id']];
                    $c = 'input-red';
                }
                else
                {
                    $v ='';
                    $c ='';
                }
            }
            else
            {
                $v = $n['Attivita']['DataInizio'];
                $c ='';
            }
        ?>
        <td width="15%"> <?php echo $this->Form->input("Attivita.$i.DataInizio", ['value'=>$v, 'type'=>'text', 'class'=>$c]); ?>        </td>
        
        <?php if( empty($n['Attivita']['DataFinePrevista']) )
            {
                if (isset($ultimadata[$n['Attivita']['id']]))
                {
                    $v = $ultimadata[$n['Attivita']['id']];
                    $c = 'input-red';
                }
                else
                {
                    $v ='';
                    $c ='';
                }
            }
            else
            {
                $v = $n['Attivita']['DataFinePrevista'];
                $c ='';
            }
        ?>   
        <td width="15%"> <?php echo $this->Form->input("Attivita.$i.DataFinePrevista", ['value'=>$v, 'type'=>'text', 'class'=>$c ]); ?>        </td>
        
        <?php if( empty($n['Attivita']['DataFine']) )
            {
                if (isset($ultimadata[$n['Attivita']['id']]))
                {
                    $v = $ultimadata[$n['Attivita']['id']];
                    $c = 'input-red';
                }
                else
                {
                    $v ='';
                    $c ='';
                }
            }
            else
            {
                $v = $n['Attivita']['DataFine'];
                $c ='';
            }
        ?>        
        <td width="15%"> <?php echo $this->Form->input("Attivita.$i.DataFine", ['value'=>$v , 'type'=>'text', 'class'=>$c ]); ?>        </td>

    </tr>

<?php endforeach; ?>
</table>
<?php echo $this->Form->end('salva');


