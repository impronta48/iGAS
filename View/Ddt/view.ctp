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
        <a href="<?php echo $this->Html->url(array('action'=>'stampa', $ddt['Ddt']['id']))?>" class="btn btn-animate-demo btn-primary hidden-print"><i class="fa fa-file fa-2x"></i> Pdf</a>        
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
                    <h2 style="font-family: helvetica;">Documento di Trasporto</h2>
                    <div>Numero Univoco: <?php echo $ddt['Ddt']['id']; ?></div>
                    <div><small>Riferimento Interno Attività: <?php echo $ddt['Attivita']['id']; ?></small></div>                
                    <div>Causale del Trasporto: <?php echo $ddt['LegendaCausaleTrasporto']['name']; ?></div>
                    <div>Porto: <?php echo $ddt['LegendaPorto']['name']; ?></div>
                <div>Data Inizio Trasporto: <?php echo CakeTime::format($ddt['Ddt']['data_inizio_trasporto'], '%d-%m-%Y'); ?></div>
                </div>
                <hr>
                <h4>Destinatario</h4>
                <div><b><?php echo $ddt['Ddt']['destinatario']; ?></b></div>
                <div><?php echo $ddt['Ddt']['destinatario_via']; ?><br/><?php echo $ddt['Ddt']['destinatario_cap']; ?> <?php echo $ddt['Ddt']['destinatario_citta']; ?> ( <?php echo $ddt['Ddt']['destinatario_provincia']; ?> ) </div>
                <h4>Luogo di Consegna</h4>               
                <div><?php echo $ddt['Ddt']['luogo_via']; ?><br/><?php echo $ddt['Ddt']['luogo_cap']; ?> <?php echo $ddt['Ddt']['luogo_citta']; ?> ( <?php echo $ddt['Ddt']['luogo_provincia']; ?> ) </div>

            </div>
				
        </td>
        </tr>
    </table>
    
	<br><br>
    <?php if (!empty($ddt['Rigaddt'])):?>
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
		foreach ($ddt['Rigaddt'] as $riga):
		?>
		<?php if($riga['qta'] > 0):?>
		<tr>            
			<td><?php echo $riga['Descrizione'];?></td>
			<td align="right"><?php echo $riga['um'];?></td>			
            <td align="right"><?php echo $riga['qta'];?></td>
		</tr>
		<?php endif;?>
    	<?php endforeach; ?>        
        
        <tfoot>
        <tr class="totale">            
            <td class="bg-gray" align="right">Numero Colli</td>
			<td class="bg-gray" align="right" colspan="4"><?php echo $ddt['Ddt']['n_colli'];?> </td>
        </tr>       
        </tfoot>
	</table>
    <?php endif; ?>
    <hr>
    
    <table class="table table-condensed table-bordered" width="100%" style="border: 1px dotted gray">
    <tr>
        <td class="bg-gray">Vettore</td>
        <td class="bg-gray">Firma Vettore</td>
        <td class="bg-gray">Firma Conducente</td>
        <td class="bg-gray">Firma Destinatario</td>        
        <td class="bg-gray" width="40%">Note</td>        
    </tr>
    <tr>
        <td><?php echo $ddt['Vettore']['name']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $ddt['Ddt']['note']; ?></td>        
    </tr>
    </table>
                
    <br><br>
    
    <table>
        <tr class="footer-fattura">
            <td>
                <p><?php echo Configure::read('iGas.Footer') ?></p>
            </td>
        </tr>
    </table>
</div>
