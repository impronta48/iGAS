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
    
    .table-bordered table, .table-bordered th, .table-bordered td 
    {
        border: 1px dotted gray;
    }
    
    table {
        border-collapse: collapse;
    }
</style>
<style media="print">
    .hidden-print {display:none}
</style>
<div class="fattureemesse view">   
    <div class="actions hidden-print">
        <a href="<?php echo $this->Html->url(array('action'=>'stampa', $ordine['Ordine']['id']))?>" class="btn btn-animate-demo btn-primary hidden-print"><i class="fa fa-file fa-2x"></i> Pdf</a>        
    </div>
    
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="clearfix">
                    <?php echo $this->Html->image(Configure::read('iGas.Logo'), array('class'=>'col-md-3', 'fullBase' => true)); ?>                        
                </div>

                <div class="invoice-from">
                    <p><b><?php echo $azienda['Fornitore']['DisplayName']; ?> </b></p>
                    <div><?php echo $azienda['Fornitore']['Indirizzo']; ?><br/><?php echo $azienda['Fornitore']['CAP']; ?> <?php echo $azienda['Fornitore']['Citta']; ?> ( <?php echo $azienda['Fornitore']['Provincia']; ?> ) </div>
                    <div><?php echo $azienda['Fornitore']['Nazione']; ?><br><br></div>
                    
                    <div>P.IVA: <?php echo $azienda['Fornitore']['piva']; ?></div>
                    <div class="sml">CF: <?php echo $azienda['Fornitore']['cf']; ?></div>						
                    <div class="sml">tel: <?php echo $azienda['Fornitore']['TelefonoUfficio']; ?></div>
                    <div class="sml">e-mail: <?php echo $azienda['Fornitore']['EMail']; ?></div>
                    <div class="sml">web: <?php echo $azienda['Fornitore']['SitoWeb']; ?></div>						
                </div>
                </td>
            
            <td width="50%">    
            <div class="invoice-to">
                <div style="text-align: right">
                    <h2 style="font-family: helvetica;">ORDINE</h2>
                    <div>Numero Ordine: <?php echo $ordine['Ordine']['id']; ?></div>
                    <div><small>Riferimento Interno Attività: <?php echo $ordine['Attivita']['id']; ?></small></div>                
                </div>
                <hr>
                <h4>Fornitore</h4>
                <div><b><?php echo $ordine['Fornitore']['DisplayName']; ?></b></div>
                <div><?php echo $ordine['Fornitore']['Indirizzo']; ?><br/><?php echo $ordine['Fornitore']['CAP']; ?> <?php echo $ordine['Fornitore']['Citta']; ?> ( <?php echo $ordine['Fornitore']['Provincia']; ?> ) </div>
                
                <?php if (!empty($ordine['Ordine']['co'])):?>
                <br>
                <div><b>c/o:</b> <?php echo $this->Text->autoParagraph($ordine['Ordine']['co']); ?></div>
                <?php endif; ?>
            </div>
				
        </td>
        </tr>
    </table>
    
	<br><br>
    <?php if (!empty($ordine['Rigaordine'])):?>
	<table cellspacing="0" cellpadding="5" width="100%" class="table-striped">

		<tr style="border-bottom:1px dotted gray;">			            
			<td class="bg-gray" align="left"><b>Descrizione</b></td>			
			<td class="bg-gray" align="right"><b>Unità Misura</b></td>
            <td class="bg-gray" align="right"><b>Qta</b></td>
		</tr>
        
        <?php
        //CICLO SULLE FASI o PRODOTTI
		$i = 0;
        $importo_tot = 0;
        $iva_tot = 0;
		foreach ($ordine['Rigaordine'] as $riga):
		?>
		<?php if($riga['qta'] > 0):?>
		<tr>            
			<td><?php echo $riga['Descrizione'];?></td>
			<td align="right"><?php echo $riga['um'];?></td>			
            <td align="right"><?php echo $riga['qta'];?></td>
		</tr>
		<?php endif;?>
    	<?php endforeach; ?>                
	</table>
    <?php endif; ?>
    <hr>
    
    <?php if (!empty($ordine['Ordine']['note'])) : ?>
    <div><b>Note:</b> <?php echo $ordine['Ordine']['note']; ?></div>
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
