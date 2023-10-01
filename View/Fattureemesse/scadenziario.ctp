<?php $this->Html->addCrumb('Scadenziario Fatture Emesse', ''); ?>

<div class="fattureemesse index">
	<h2>Scadenziario Fatture Emesse <?php echo $anno; ?></h2>
    <div class="actions">
    <?php 
    $anni = Configure::read('Fattureemesse.anni');
    for ($i=date('Y')-$anni; $i<=date('Y'); $i++)
    {
    ?>
        <a class="btn btn-default btn-animate-demo btn-xs" href="<?php echo $this->Html->url(['controller' => 'fattureemesse','action' => 'scadenziario', $i]) ?>"><?php echo $i ?></a>        
    <?php
        }
    ?>      
    </div>
    <?php
    ////////// Disegno la tabella solo se ci sono fatture
        if ($fattureemesse):
   ?>       
    
    <div class="table-responsive">
	<table class="table table-bordered table-hover table-striped table-condensed">
        <thead>
	<tr>
        <th>mese</th><th>dettagli</th><th>fatturato</th><th>incassato</th><th>manca</th>
    </tr>
    </thead>

    <tbody>    
	<?php
    $level = 0;
    $fatturato_tot = 0;
    $incassato_tot = 0;
	//Scrivo 12 colonne con dentro una tabellina    
    //Ciclo sui mesi
    for ($m = 1; $m <= 12; $m++)
    {
        $fatturato = 0;
        $incassato = 0;        
        echo "<tr>";
        echo "<td>$m</td>";
        echo "<td>";
        if (isset($fattureemesse[$m])) {           
            echo "<table class=\"table-bordered\" width=\"100%\">";
            echo "<th width=\"25%\">Cliente</th>";
            echo "<th width=\"25%\">Attività</th>";
            echo "<th width=\"10%\">Progressivo</th>";
            echo "<th width=\"10%\">Data</th>";
            echo "<th width=\"10%\">Scadenza</th>";
            echo "<th width=\"10%\">Importo (i.c.)</th>";

                     
            //Ciclo su tutte le fatture emesse in quel mese e le scrivo nella colonna
            foreach ($fattureemesse[$m] as $fatturaemessa)
            {
               if ($fatturaemessa['Fatturaemessa']['Soddisfatta'])
                {                    
                    $level = 'success';
                }
                else
                {                    
                    $level = 'default';
                }
        ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($fatturaemessa['Attivita']['Persona']['DisplayName'], ['controller'=>'persone', 'action' => 'view', $fatturaemessa['Attivita']['cliente_id']]); ?>
                </td>                
                <td>
                    <?php echo $this->Html->link($fatturaemessa['Attivita']['name'], ['controller'=>'attivita', 'action' => 'edit', $fatturaemessa['Fatturaemessa']['attivita_id']]); ?>
                </td>
                <td>
                    <a href="<?php echo $this->Html->url(['controller'=>'fattureemesse', 'action' => 'edit', $fatturaemessa['Fatturaemessa']['id']]); ?>">
                    <?php echo $fatturaemessa['Fatturaemessa']['Progressivo']; ?>/<?php echo $fatturaemessa['Fatturaemessa']['AnnoFatturazione']; ?>
                    </a>
                </td>		
                <td><?php echo $fatturaemessa['Fatturaemessa']['data']; ?></td>
                <td><?php echo $fatturaemessa['Fatturaemessa']['DataScadenza']; ?></td>
                <td style="text-align: right;" class="bg-<?php echo ($level =='success'? $level:''); ?>">
                    <span><?php $importo = $this->Number->precision($fatturaemessa['Fatturaemessa']['TotaleLordo'],2); echo $this->Number->currency($importo,'EUR'); ?></span>
                </td>
            </tr>
        <?php            

                $fatturato += $importo;        
                $incassato += $fatturaemessa['Fatturaemessa']['Soddisfatta'];
                
                }  //foreach               
                echo "</table>";
                $fatturato_tot +=$fatturato;
                $incassato_tot +=$incassato;
            } //If
            echo "</td>";        
            echo "<td>" . $this->Number->currency($this->Number->precision($fatturato,2), 'EUR'). "</td>";
            echo "<td>" . $this->Number->currency($this->Number->precision($incassato,2), 'EUR'). "</td>";            
            echo "<td>" . $this->Number->currency($this->Number->precision($fatturato-$incassato,2), 'EUR'). "</td>";            
            echo "</tr>";        
        }
        ?>    
    </tbody>
    <tfoot class="bg-success-dark">
        <td colspan="2"><b>Totali</b></td>
        <td><b><?php echo $this->Number->currency($this->Number->precision($fatturato_tot,2), 'EUR') ?></b></td>
        <td><b><?php echo $this->Number->currency($this->Number->precision($incassato_tot,2), 'EUR') ?></b></td>
        <td><b><?php echo $this->Number->currency($this->Number->precision($fatturato_tot-$incassato_tot,2), 'EUR') ?></b></td>
    </tfoot>
	</table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
  <?php else: ?>
        <p>Nessuna fattura emessa.</p>
  <?php endif; ?>
</div>

<?php $this->Html->scriptStart(['inline' => false]); ?>
  $('.dropdown-menu').find('form').click(function (e) {
    e.stopPropagation();
  });
<?php $this->Html->scriptEnd(); 