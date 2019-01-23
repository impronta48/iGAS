<?php $this->Html->addCrumb('Totale prima nota per mese', ''); ?>

<div class="fattureemesse index">
	<h2>Totali Incassi/Spese per mese, anno: <?php echo $anno; ?></h2>
    <div class="actions">
    <?php 
    $anni = Configure::read('Fattureemesse.anni');
    for ($i=date('Y')-$anni; $i<=date('Y'); $i++)
    {
    ?>
        <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url(array('action' => 'totalimese', $i)) ?>"><?php echo $i ?></a>        
    <?php
        }
    ?>      
    </div>
    <?php
    ////////// Disegno la tabella solo se ci sono fatture
        if ($primanota):
   ?>       
    
    <div class="table-responsive">
	<table class="table table-bordered table-hover table-condensed">
        <thead>
	<tr>
        <th>mese</th><th>dettaglio</th><th>banca</th><th>spese</th><th>incassi</th><th>margine</th>
    </tr>
    </thead>

    <tbody>    
	<?php
    $level = 0;
    $speso_tot = 0;
    $incassato_tot = 0;
	//Scrivo 12 colonne con dentro una tabellina    
    //Ciclo sui mesi
    for ($m = 1; $m <= 12; $m++)
    {
        $speso = 0;
        $incassato = 0;        
        echo "<tr>";
        if (isset($primanota[$m])) {                      
            foreach($primanota[$m] as $pm) {         
        ?>
            <tr>
                <td><?php echo $pm['Primanota']['data']; ?></td>
                <td>
                    <?php echo $this->Html->link($pm['Attivita']['name'], array('controller'=>'primanota', 'action' => 'index', $pm['Primanota']['attivita_id'])); ?>
                    - <small> <?php echo $pm['Primanota']['descr']?></small>
                </td>
                <td>
                    <?php echo $pm['Provenienzasoldi']['name']?>
                </td>
                
                <?php if($pm['Primanota']['importo']>=0): ?>
                <td>&nbsp;</td>
                <td style="text-align: right;">
                    <span><?php $importo = $this->Number->precision($pm['Primanota']['importo'],2); echo $this->Number->currency($importo,'EUR', array('negative'=>'-')); ?></span>
                </td>
                <?php else : ?>
                <td style="text-align: right;">
                    <span><?php $importo = $this->Number->precision($pm['Primanota']['importo'],2); echo $this->Number->currency($importo,'EUR', array('negative'=>'-')); ?></span>
                </td>
                <td>&nbsp;</td>
                <?php endif; ?>
                <td>&nbsp;</td>
            </tr>
            <?php                
                //Se è > 0 è incassato se no è speso
                if ($importo > 0)
                {
                    $incassato += $importo;       
                }
                else
                {                   
                    $speso -= $importo;
                }
                
                }  //foreach riga di primanota                              
                $incassato_tot +=$incassato;
                $speso_tot +=$speso;
            } //If
            ?>
            <tr style="text-align: right; font-weight: bold" class="bg-primary">
                <td colspan="3">Mese: <?php echo $m ?></td>
                <td><?php echo $this->Number->currency($this->Number->precision(-$speso,2), 'EUR', array('negative'=>'-')) ?></td>
                <td><?php echo $this->Number->currency($this->Number->precision($incassato,2), 'EUR', array('negative'=>'-'))?> </td>            
                <td><?php echo $this->Number->currency($this->Number->precision($incassato-$speso,2), 'EUR', array('negative'=>'-')) ?> </td>            
            </tr>
            <?php } //FOR MESE  ?>    
    </tbody>
    <tfoot class="bg-success-dark">
        <td colspan="3"><b>Totale Movimenti</b></td>
        <td><b><?php echo $this->Number->currency($this->Number->precision(-$speso_tot,2), 'EUR', array('negative'=>'-')) ?></b></td>
        <td><b><?php echo $this->Number->currency($this->Number->precision($incassato_tot,2), 'EUR', array('negative'=>'-')) ?></b></td>
        <td><b><?php echo $this->Number->currency($this->Number->precision($incassato_tot-$speso_tot,2), 'EUR', array('negative'=>'-')) ?></b></td>
    </tfoot>
	</table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
  <?php else: ?>
        <p>Nessuna fattura emessa.</p>
  <?php endif; ?>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
  $('.dropdown-menu').find('form').click(function (e) {
    e.stopPropagation();
  });  

<?php $this->Html->scriptEnd(); 