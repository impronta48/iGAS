<style>
    .footer-fattura {        
            font-size: smaller;
            color: darkgray;    
            margin-top: 1em;    
    }
    
    .sml {
        font-size: smaller;
    }
    .bg-gray {
        background-color: silver;
    }
    .gray {
        color: gray;
    }
    .totale {
        font-weight: bold;
    }
    
    * {
       font-family: "Century Gothic", sans-serif;
    }
</style>
<style media="print">
    .hidden-print {display:none}
</style>
<div class="fattureemesse view">      
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="row">
                <div class="clearfix col-md-4 col-md-offset-1">
                    <?php echo $this->Html->image(Configure::read('iGas.Logo'), array('fullBase' => true,'style'=>'max-width:200px')); ?>                        
                </div>
                </div>
                <div class="row">
                <div class="invoice-from col-md-offset-2">
					<?php if (!isset($azienda['Persona']['DisplayName']))
					{	
						echo "<div class=\"alert alert-danger\">Controllare che sia impostata correttamente la prorpia azienda nella configurazione</div>";
					}
					else {
					?>
                    <p><b><?php echo $azienda['Persona']['DisplayName']; ?> </b></p>
                    <div><?php echo $azienda['Persona']['Indirizzo']; ?><br/><?php echo $azienda['Persona']['CAP']; ?> <?php echo $azienda['Persona']['Citta']; ?> ( <?php echo $azienda['Persona']['Provincia']; ?> ) </div>
                    <div><?php echo $azienda['Persona']['Nazione']; ?><br><br></div>
                    
                    <div>P.IVA: <?php echo $azienda['Persona']['piva']; ?></div>
                    <div class="sml">CF: <?php echo $azienda['Persona']['cf']; ?></div>						
                    <div class="sml">tel: <?php echo $azienda['Persona']['TelefonoUfficio']; ?></div>
                    <div class="sml">e-mail: <?php echo $azienda['Persona']['EMail']; ?></div>
                    <div class="sml">web: <?php echo $azienda['Persona']['SitoWeb']; ?></div>						
					<?php } ?>
                </div>
                </div>
            </td>
            
            <td width="50%">    
            <div class="invoice-to">
                <div style="text-align: right">
                
                <?php $progressivo = $fatturaemessa['Fatturaemessa']['Progressivo'] . '/'. $fatturaemessa['Fatturaemessa']['AnnoFatturazione']; ?> 
                <?php if ($fatturaemessa['Fatturaemessa']['Progressivo'] > 0): ?>
                    <h1 style="font-family: helvetica;">FATTURA</h1>
                    <br>
			    
                <?php $progressivo = $fatturaemessa['Fatturaemessa']['Progressivo'] . '/'. $fatturaemessa['Fatturaemessa']['AnnoFatturazione']; 
				    if(!empty($fatturaemessa['Fatturaemessa']['Serie'])) $progressivo .= ' - '. strtoupper($fatturaemessa['Fatturaemessa']['Serie']);
				?>
                    <div><b>Fattura numero <?php echo $progressivo; ?></b></div>
                <?php else : ?>
                    <?php $progressivo = -$fatturaemessa['Fatturaemessa']['Progressivo'] . '/'. $fatturaemessa['Fatturaemessa']['AnnoFatturazione']; ?> 
                    <h1 style="font-family: helvetica;">NOTA DI CREDITO</h1>
                    <br>
                    <div><b>Nota numero <?php echo $progressivo; ?></b></div>
                <?php endif; ?>
                
                <div>Data: <?php echo CakeTime::format($fatturaemessa['Fatturaemessa']['data'], '%d-%m-%Y'); ?></div>
                <div>Scadenza: <?php echo $fatturaemessa['Fatturaemessa']['ScadPagamento']; ?> gg.
                    <?php if ($fatturaemessa['Fatturaemessa']['FineMese'])
                    {
                        echo "d.f.f.m.";
                    }
                    ?>
                </div>
                <div><small><i>Codice Interno Attivit&agrave;: <?php echo $fatturaemessa['Attivita']['id']; ?></i></small></div>
                </div>
                <hr>
                <div>Alla spett.le attenzione di</div>
				<?php if (!isset($fatturaemessa['Attivita']['Persona']))
					{	
						echo "<div class=\"alert alert-danger\">Bisogna inserire il cliente nell'attività</div>";
					}
					else {
				?>
                <div><b>
                    <?php 
                        $rs = $fatturaemessa['Attivita']['Persona']['Societa'];
                        if (empty($rs)) 
                        {
                                $rs = $fatturaemessa['Attivita']['Persona']['DisplayName'];                                        
                        }
                        echo $rs ; 
                    ?>
                </b></div>
                <div><?php echo $fatturaemessa['Attivita']['Persona']['Indirizzo']; ?><br/><?php echo $fatturaemessa['Attivita']['Persona']['CAP']; ?> <?php echo $fatturaemessa['Attivita']['Persona']['Citta']; ?> ( <?php echo $fatturaemessa['Attivita']['Persona']['Provincia']; ?> ) </div>
                <div><?php echo $fatturaemessa['Attivita']['Persona']['Nazione']; ?><br><br></div>

                <?php if (!empty($fatturaemessa['Attivita']['Persona']['piva'])): ?>
                    <div>P.IVA: <?php echo $fatturaemessa['Attivita']['Persona']['piva']; ?></div>
                <?php endif; ?>
                <?php if (!empty($fatturaemessa['Attivita']['Persona']['cf'])): ?>
                    <div>CF: <?php echo $fatturaemessa['Attivita']['Persona']['cf']; ?></div>						
                <?php endif; ?>
				
				<?php } ?>
            </div>
				
        </td>
        </tr>
        <tr>
            <td><br><br></td>
        </tr>
    <tr>
        <td colspan="2" style="border-bottom: 1px dotted gray; background: silver">
        Oggetto: <b><?php echo $fatturaemessa['Fatturaemessa']['Motivazione']; ?></b>
        </td>
    </tr>
    </table>
    
	<br><br>
    <?php if (!empty($fatturaemessa['Rigafattura'])):?>
	<table cellspacing="0" cellpadding="5" style="border: 1px dotted gray" width="100%">

		<tr style="border-bottom:1px dotted gray;">			
            <td class="bg-gray"><b>Voce</b></td>
			<td class="bg-gray" align="right"><b>Imponibile</b></td>
			<td class="bg-gray" align="right"><b>% IVA</b></td>
			<td class="bg-gray" align="right"><b>IVA</b></td>
			<td class="bg-gray" align="right"><b>Importo totale</b></td>
		</tr>
        
        <?php
        //CICLO SULLE RIGHE FATTURA
		$i = 0;
        $importo_tot = 0;
        $iva_tot = 0;
		foreach ($fatturaemessa['Rigafattura'] as $rigafattura):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}            
            $importo = $rigafattura['Importo'] ;
            $iva = $rigafattura['Importo'] * $rigafattura['Codiceiva']['Percentuale'] / 100;
            $importo_tot += $importo;
            $iva_tot += $iva;
		?>
		<tr<?php echo $class;?>>            
			<td><?php echo $rigafattura['DescrizioneVoci'];?></td>
			<td align="right"><?php echo $this->Number->currency($importo,'EUR', array('negative'=>'-')); ?></td>
			<td align="right"><small class="gray"><?php echo $rigafattura['Codiceiva']['Percentuale']; ?>%</small></td>
            <td align="right"><?php echo $this->Number->currency($iva,'EUR');?> </td>
			<td align="right" class="totale"><?php echo $this->Number->currency($iva+$importo,'EUR', array('negative'=>'-'));?></td>
		</tr>
    	<?php endforeach; ?>        
        
        <tfoot>
        <tr class="totale">            
            <td class="bg-gray">Totale</td>
			<td class="bg-gray" align="right"><?php echo $this->Number->currency($importo_tot,'EUR', array('negative'=>'-')); ?> </td>
			<td class="bg-gray" align="right" colspan="2"><?php echo $this->Number->currency($iva_tot,'EUR', array('negative'=>'-')); ?> </td>
			<td class="bg-gray" align="right"><b><?php echo $this->Number->currency($importo_tot+$iva_tot,'EUR', array('negative'=>'-')); ?> </b></td>

        </tr>
        </tfoot>
	</table>
    <?php endif; ?>
    <hr>
    
	<?php if(!empty($fatturaemessa['Fatturaemessa']['CondPagamento'])): ?>        
                <?php echo $fatturaemessa['Fatturaemessa']['CondPagamento']; ?>        
				<hr/>
	<?php endif; ?>
	
    <?php echo $fatturaemessa['ProvenienzaSoldi']['ModoPagamento']; ?>
    <br><br>
    
    <table>
        <tr class="footer-fattura">
            <td>
                <p><?php echo Configure::read('iGas.Footer') ?></p>
            </td>
        </tr>
    </table>
</div>
