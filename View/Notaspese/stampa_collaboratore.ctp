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
        <a href="<?php echo $this->Html->url(array('ext'=>'pdf'))?>" class="btn btn-animate-demo btn-primary hidden-print"><i class="fa fa-file fa-2x"></i> Pdf</a>        
    </div>
    
    <br>

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
                    <h1 style="font-family: helvetica;">NOTA SPESE</h1>
                    <br>
                
                    <div>Data: <?php echo CakeTime::format('now', '%d-%m-%Y'); ?></div>                
                
                </div>
                <hr>
                <div>Nota Spese di</div>
                
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

        $rimborsabili_rimborsati = array();
        $rimborsabili_daRimborsare = array();
        $nonRimborsare = array();
        $fatturabili_fatturati = array();
        $fatturabili_daFatturare = array();
        $nonFatturabili = array();

        foreach ($notaspese as $ns) {

            if($ns['Notaspesa']['rimborsato'] == 1 && $ns['Notaspesa']['rimborsabile'] == 1)
                $rimborsabili_rimborsati[] = $ns;

            if($ns['Notaspesa']['rimborsato'] == 0 && $ns['Notaspesa']['rimborsabile'] == 1)
                $rimborsabili_daRimborsare[] = $ns;

            if($ns['Notaspesa']['rimborsabile'] == 0)
                $nonRimborsare[] = $ns;

            if($ns['Notaspesa']['fatturato'] == 1 && $ns['Notaspesa']['fatturabile'] == 1)
                $fatturabili_fatturati[] = $ns;

            if($ns['Notaspesa']['fatturato'] == 0 && $ns['Notaspesa']['fatturabile'] == 1)
                $fatturabili_daFatturare[] = $ns;

            if($ns['Notaspesa']['fatturabile'] == 0)
                $nonFatturabili[] = $ns;
            
        }

        if (!empty($fatturabili_fatturati)) {
            $importo_tot += $this->Table->create_table($fatturabili_fatturati, 'Fatturati');
        }
        if (!empty($fatturabili_daFatturare)) {
            $importo_tot += $this->Table->create_table($fatturabili_daFatturare, 'Da Fatturare');
        }
        if (!empty($nonFatturabili)) {
            $importo_tot += $this->Table->create_table($nonFatturabili, 'Non Fatturabili');
        }
        ?>    

        <br><br>
        
        <table>
            <tr class="totale">            
                <td class="bg-gray" colspan="2" >Totale</td>
                <td class="bg-gray" align="right"><?php echo $this->Number->currency($importo_tot,'EUR', array('negative'=>'-')); ?> </td>
                <td class="bg-gray" colspan="2">&nbsp;</td>
            </tr>
        </table>

        <hr>
        
</div>