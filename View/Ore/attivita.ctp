<?php $this->Html->addCrumb('Ore per Commessa', ''); ?>

<div class="table-responsive">
<table class="table table-condensed table-striped dataTable">
    <thead >
    <tr>
        <th>Attivit&agrave;</th>
        <th>Importo Acquisito</th>
        <th>Ore Usate</th>
        <th>Costo Orario Risultante</th>
        <th>Costo GG Risultante</th>
    </tr>
    </thead>
    
    <tbody>
        <?php 
            $ricavoTot = 0;
            $oreBuone = 0;
            $oreZero = 0;  //Include le ore delle commesse a zero ricavo
        ?>
        <?php foreach($r as $attivita) : ?>        
        <tr>
        <td><?php echo $attivita['Attivita']['name']; ?></td>
        <td><?php echo $attivita['Attivita']['ImportoAcquisito']; ?></td>
        <td><?php echo $this->Number->precision($attivita[0]['S'],2); ?></td>               
        <?php 
                if ($attivita[0]['S'] > 0 &&  $attivita['Attivita']['ImportoAcquisito'] > 0) {
                    $ricavoOrario = $attivita['Attivita']['ImportoAcquisito'] / $attivita[0]['S'];                    
                    echo "<td>" . $this->Number->currency( $ricavoOrario,'EUR') . "</td>"; 
                    echo "<td>" . $this->Number->currency( $ricavoOrario*8,'EUR') . "</td>"; 
                    $ricavoTot += $attivita['Attivita']['ImportoAcquisito'];
                    $oreBuone +=$attivita[0]['S'];
                }                
                else
                {
                    echo '<td>---</td>';
                    echo '<td>---</td>';
                    $oreZero +=$attivita[0]['S'];
                }
                
             ?>

        </tr>
        <?php endforeach; ?>
        
    <tfoot>
        <tr class="bg-success-dark" style="font-weight: bold">
            <td>Media Ricavi (solo commesse remunerate)</td>
            <td><?php echo $this->Number->currency($ricavoTot,'EUR') ?></td>
            <td><?php echo $this->Number->format($oreBuone, 0); ?></td>
            <td><?php echo $this->Number->currency($ricavoTot / $oreBuone, 'EUR'); ?></td>
            <td><?php echo $this->Number->currency($ricavoTot / $oreBuone *8, 'EUR'); ?></td>                     
        </tr>
        <tr class="bg-success-dark" style="font-weight: bold">
            <td>Media Ricavi (tutte le ore)</td>
            <td><?php echo $this->Number->currency($ricavoTot,'EUR') ?></td>
            <td><?php echo $this->Number->format($oreBuone+$oreZero, 0); ?></td>
            <td><?php echo $this->Number->currency($ricavoTot / ($oreZero+$oreBuone), 'EUR'); ?></td>
            <td><?php echo $this->Number->currency($ricavoTot / ($oreZero+$oreBuone) *8, 'EUR'); ?></td>                     
        </tr>
    </tfoot>
    </tbody>
        
    
</table>
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
  
  $('document').ready(function(){
	//data table
	$('.dataTable').dataTable({
        aaSorting: [[ 1, 'asc' ]],
		
        "iDisplayLength" : 1000
        
		//"bFilter": true,
		//"bPaginate": false
	});
});
<?php $this->Html->scriptEnd(); 