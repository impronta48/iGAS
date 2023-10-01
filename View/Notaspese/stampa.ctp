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

<div class="notaspese view">   
    <div class="actions hidden-print">
        <a href="<?php echo $this->Html->url(['ext'=>'pdf'])?>" class="btn btn-animate-demo btn-primary hidden-print"><i class="fa fa-file fa-2x"></i> Pdf</a>        
        <a href="<?php echo $this->Html->url(['ext'=>'xls'])?>" class="btn btn-animate-demo btn-primary hidden-print"><i class="fa fa-file fa-2x"></i> Xls</a>
    </div>
    <br>
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="row">
                <div class="clearfix col-md-4 col-md-offset-1">
                    <?php echo $this->Html->image(Configure::read('iGas.Logo'), ['fullBase' => true,'style'=>'max-width:200px']); ?>                        
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
                    <h1 style="font-family: helvetica;">NOTA SPESE</h1>
                    <br>
                
					<div>Data: <?php echo CakeTime::format('now', '%d-%m-%Y'); ?></div>                
                
                </div>
                <hr>
                <div>Alla spett.le attenzione di</div>
				<?php if (!isset($cliente))
					{	
						echo "<div class=\"alert alert-danger\">Bisogna inserire il cliente nell'attività</div>";
					}
					else {
				?>
                <div><b>
                    <?php 
                        $rs = $cliente['Societa'];
                        if (empty($rs)) 
                        {
                                $rs = $cliente['DisplayName'];                                        
                        }
                        echo $rs ; 
                    ?>
                </b></div>
                <div><?php echo $cliente['Indirizzo']; ?><br/><?php echo $cliente['CAP']; ?> <?php echo $cliente['Citta']; ?> ( <?php echo $cliente['Provincia']; ?> ) </div>
                <div><?php echo $cliente['Nazione']; ?><br><br></div>

                <?php if (!empty($cliente['piva'])): ?>
                    <div>P.IVA: <?php echo $cliente['piva']; ?></div>
                <?php endif; ?>
                <?php if (!empty($cliente['cf'])): ?>
                    <div>CF: <?php echo $cliente['cf']; ?></div>						
                <?php endif; ?>
				
				<?php } ?>
            </div>
				
        </td>
        </tr>
        <tr>
            <td><br><br></td>
        </tr>
    <!-- <tr>
       <td colspan="2" style="border-bottom: 1px dotted gray; background: silver">
        Oggetto: <b>Notaspese</b>
        </td>
    </tr>-->
    </table>
    
	<br>
        
        <?php
        //CICLO SULLE RIGHE FATTURA
        $importo_tot = 0;

        $fatturabili_fatturati = [];
        $fatturabili_daFatturare = [];
        $nonFatturabili = [];

        foreach ($notaspese as $ns) {

            if($ns['Notaspesa']['fatturato'] == 1 && $ns['Notaspesa']['fatturabile'] == 1)
                $fatturabili_fatturati[] = $ns;

            if($ns['Notaspesa']['fatturato'] == 0 && $ns['Notaspesa']['fatturabile'] == 1)
                $fatturabili_daFatturare[] = $ns;

            if($ns['Notaspesa']['fatturabile'] == 0)
                $nonFatturabili[] = $ns;
        }
        
        if (!empty($fatturabili_fatturati)){
            $importo_tot += $this->Table->create_table($fatturabili_fatturati, 'Fatturati');
        }
        if (!empty($fatturabili_daFatturare)) {
        $importo_tot += $this->Table->create_table($fatturabili_daFatturare, 'Da Fatturare');
        }
        if (!empty($nonFatturabili)) {
            $importo_tot += $this->Table->create_table($nonFatturabili, 'Non Fatturabili');
        }

        $id_and_descriptions[$ns['Notaspesa']['id']]=$ns['Notaspesa']['descrizione'];

        ?>    

        <br><br>
        
        <table>
            <tr class="totale">            
                <td class="bg-gray" colspan="2" >Totale</td>
			    <td class="bg-gray" align="right"><?php echo $this->Number->currency($importo_tot,'EUR', ['negative'=>'-']); ?> </td>
			    <td class="bg-gray" colspan="2">&nbsp;</td>
            </tr>
        </table>

        <hr>

        <h2>Scontrini caricati</h2>

        <?php
        foreach($id_and_descriptions as $idNota => $descrizioneNota){
            if(file_exists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$idNota.'.pdf')){
                $this->PdfToImage->pdfToImageImagick(WWW_ROOT.'files'.DS.$this->request->controller.DS.$idNota.'.pdf');
                echo '<div class="row" style="height:450px; margin-bottom:15px">';
                echo '<img src="'.HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.'converted'.DS.$idNota.'.pdf.png" style="height:440px">';
                echo '</div>';
                echo '<strong>'.$descrizioneNota.'</strong>';
                echo '<hr />';
            }else if(file_exists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$idNota.'.gif')){
                echo '<div class="row" style="height:450px; margin-bottom:15px">';
                echo '<img src="'.HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$idNota.'.gif" style="height:440px">';
                echo '</div>';
                echo '<strong>'.$descrizioneNota.'</strong>';
                echo '<hr />';
            }else if(file_exists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$idNota.'.jpeg')){
                echo '<div class="row" style="height:450px; margin-bottom:15px">';
                echo '<img src="'.HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$idNota.'.jpeg" style="height:440px">';
                echo '</div>';
                echo '<strong>'.$descrizioneNota.'</strong>';
                echo '<hr />';
            }else if(file_exists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$idNota.'.png')){
                echo '<div class="row" style="height:450px; margin-bottom:15px">';
                echo '<img src="'.HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$idNota.'.png" style="height:440px">';
                echo '</div>';
                echo '<strong>'.$descrizioneNota.'</strong>';
                echo '<hr />';
            }
        }
        ?>
    	
</div>
