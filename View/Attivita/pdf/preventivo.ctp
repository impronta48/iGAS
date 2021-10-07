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
    <div class="actions hidden-print">
        <a href="<?php echo $this->Html->url(array('action'=>'stampa', $attivita['Attivita']['id']))?>" class="btn btn-animate-demo btn-primary hidden-print"><i class="fa fa-file fa-2x"></i> Pdf</a>        
    </div>
    
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="clearfix">
                    <?php echo $this->Html->image(Configure::read('iGas.Logo'), array('class'=>'col-md-3', 'fullBase' => true)); ?>                        
                </div>

                <div class="invoice-from">
                    <p><b><?php echo $azienda['Persona']['DisplayName']; ?> </b></p>
                    <div><?php echo $azienda['Persona']['Indirizzo']; ?><br/><?php echo $azienda['Persona']['CAP']; ?> <?php echo $azienda['Persona']['Citta']; ?> ( <?php echo $azienda['Persona']['Provincia']; ?> ) </div>
                    <div><?php echo $azienda['Persona']['Nazione']; ?><br><br></div>
                    
                    <div>P.IVA: <?php echo $azienda['Persona']['piva']; ?></div>
                    <div class="sml">CF: <?php echo $azienda['Persona']['cf']; ?></div>						
                    <div class="sml">tel: <?php echo $azienda['Persona']['TelefonoUfficio']; ?></div>
                    <div class="sml">e-mail: <?php echo $azienda['Persona']['EMail']; ?></div>
                    <div class="sml">web: <?php echo $azienda['Persona']['SitoWeb']; ?></div>						
                </div>
                </td>
            
            <td width="50%">    
            <div class="invoice-to">
                <div style="text-align: right">
                    <h1 style="font-family: helvetica;">OFFERTA</h1>
                    <div><b>Offerta numero: <?php echo $attivita['Attivita']['id']; ?></b></div>                
                
                <div>Data: <?php echo CakeTime::format($attivita['Attivita']['DataPresentazione'], '%d-%m-%Y'); ?></div>
                </div>
                <hr>
                <div>Alla spett.le attenzione di</div>
                <div><b><?php echo $attivita['Persona']['DisplayName']; ?></b></div>
                <div><?php echo $attivita['Persona']['Indirizzo']; ?><br/><?php echo $attivita['Persona']['CAP']; ?> <?php echo $attivita['Persona']['Citta']; ?> ( <?php echo $attivita['Persona']['Provincia']; ?> ) </div>
                <div><?php echo $attivita['Persona']['Nazione']; ?><br><br></div>

                <?php if (!empty($attivita['Persona']['piva'])): ?>
                    <div>P.IVA: <?php echo $attivita['Persona']['piva']; ?></div>
                <?php endif; ?>
                <?php if (!empty($attivita['Persona']['cf'])): ?>
                    <div>CF: <?php echo $attivita['Persona']['cf']; ?></div>						
                <?php endif; ?>
            </div>
				
        </td>
        </tr>
        <tr>
            <td><br><br></td>
        </tr>
    <tr>
        <td colspan="2" style="border-bottom: 1px dotted gray; background: silver">
        Oggetto: <b><?php echo $attivita['Attivita']['name']; ?></b>
        </td>
    </tr>
    </table>
    
	<br><br>
    <?php if (!empty($attivita['Faseattivita'])):?>
	<table cellspacing="0" cellpadding="5" style="border: 1px dotted gray" width="100%">

		<tr style="border-bottom:1px dotted gray;">			            
			<td class="bg-gray" align="left"><b>Descrizione</b></td>			
			<td class="bg-gray" align="right"><b>Unità Misura</b></td>
            <td class="bg-gray" align="right"><b>Qta</b></td>
			<td class="bg-gray" align="right"><b>Venduto Unitario</b></td>			
			<td class="bg-gray" align="right"><b>Importo totale</b></td>
            <td class="bg-gray" align="right"><b>Iva</b></td>
		</tr>
        
        <?php
        //CICLO SULLE FASI o PRODOTTI
		$i = 0;
        $importo_tot = 0;
        $iva_tot = 0;        
		foreach ($attivita['Faseattivita'] as $riga):
            if ($riga['entrata'] == false):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
            $importo = $riga['qta'] * $riga['vendutou'] ;            
            $importo_tot += $importo;         
            if(isset($riga['legenda_codici_iva_id'])) { $iva_tot += $percentiva[$riga['legenda_codici_iva_id']]* $importo /100; }
		?>
		<tr<?php echo $class;?>>            
			<td><?php echo $riga['Descrizione'];?></td>
			<td align="right"><?php echo $riga['um'];?></td>			
            <td align="right"><?php echo $riga['qta'];?></td>
            <td align="right"><?php echo $this->Number->currency($riga['vendutou'],'EUR');?> </td>
            <td align="right" class="totale"><?php echo $this->Number->currency($importo,'EUR'); ?></td>			
            <td align="right"><?php if(isset($riga['legenda_codici_iva_id'])) {echo $legendacodiciiva[$riga['legenda_codici_iva_id']];};?></td>
		</tr>
        <?php endif; ?>
    	<?php endforeach; ?>        
        
        <tfoot>
        <tr class="totale">            
            <td class="bg-gray">Totale iva esclusa</td>
			<td class="bg-gray" align="right" colspan="4"><?php echo $this->Number->currency($importo_tot,'EUR'); ?> </td>
            <td class="bg-gray"></td>
        </tr>
        <tr class="totale">            
            <td class="bg-gray">Iva</td>
			<td class="bg-gray" align="right" colspan="4"><?php echo $this->Number->currency($iva_tot,'EUR'); ?> </td>
            <td class="bg-gray"></td>
        </tr>
        <tr class="totale">            
            <td class="bg-gray">Totale iva compresa</td>
			<td class="bg-gray" align="right" colspan="4"><?php echo $this->Number->currency($importo_tot+$iva_tot,'EUR'); ?> </td>
            <td class="bg-gray"></td>
        </tr>
        </tfoot>
	</table>
    <?php endif; ?>
    <hr>
    
	<?php if(!empty($attivita['Attivita']['Note'])): ?>        
                <?php echo $attivita['Attivita']['Note']; ?>        
				<hr/>
	<?php endif; ?>
	
    <br><br>
    
    <table>
        <tr class="footer-fattura">
            <td>
                <p><?php echo Configure::read('iGas.Footer') ?></p>
            </td>
        </tr>
    </table>
</div>
