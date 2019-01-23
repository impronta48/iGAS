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
                    <h1 style="font-family: helvetica;">REPORT ORE</h1>
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
    </table>


	<br>
        
    <table cellspacing="0" cellpadding="5" style="border: 1px dotted gray" width="100%">
                            <tr style="border-bottom:1px dotted gray;">     
                                <td class="bg-gray"><b>Data</b></td>        
                                <td class="bg-gray"><b>Descrizione</b></td>
                                <td class="bg-gray"><b>Numero Ore</b></td>
                                <td class="bg-gray"><b>Attivit&agrave;</b></td>
                                <td class="bg-gray"><b>Consulente</b></td>
                            </tr>


        <?php
        //CICLO SULLE RIGHE FATTURA
        $i = 0;
        $ore_tot = 0;

        foreach ($ore as $o) {

            $class = null;

            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }

            echo "<tr".$class.">            
                    <td>".CakeTime::format($o['Ora']['data'], '%d-%m-%Y')."</td>
                    <td>".$o['Ora']['dettagliAttivita']."</td>
                    <td>".$o['Ora']['numOre']."</td>
                    <td>".$o['Attivita']['name']."</td>
                    <td>".$o['Persona']['DisplayName']."</td></tr>";

            $ore_tot += $o['Ora']['numOre'];

        }

        ?> 

        <tfoot>
            <tr class="totale">            
                <td class="bg-gray">Totale Ore</td>
                <td class="bg-gray">&nbsp;</td>
                <td class="bg-gray"><?php echo $ore_tot;?></td>
                <td class="bg-gray">&nbsp;</td>
                <td class="bg-gray">&nbsp;</td>
            </tr>
        </tfoot>   

    </table>
    	
</div>