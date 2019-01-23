<?php
App::uses('AppHelper', 'View/Helper');

class TableHelper extends AppHelper {

    public $helpers = array('Number');
    
    //Genera una tabella per ogni input 
    public function create_table($notaspese, $titolo) { 

        if(count($notaspese) == 0)
            return "";

        echo "<h2 class=\"text-center\">".$titolo."</h2>";

        $array_rimborsi = array();
        $importo_return = 0;

        foreach ($notaspese as $ns) {

            if($ns['Notaspesa']['rimborsato'] == 1 && $ns['Notaspesa']['rimborsabile'] == 1)
                $array_rimborsi['Rimborsati'][] = $ns;

            if($ns['Notaspesa']['rimborsato'] == 0 && $ns['Notaspesa']['rimborsabile'] == 1)
                $array_rimborsi['Rimborsabili'][] = $ns;

            if($ns['Notaspesa']['rimborsabile'] == 0)
                $array_rimborsi['Non Rimborsabili'][] = $ns;
        }

        foreach ($array_rimborsi as $key => $ar) {

            if(count($ar) > 0) {

                $i = 0;
                $importo_tot = 0;
                $iva_tot = 0;
                $tot_km=0;

                echo "<h4>".$key."</h4>";

                echo    "<table cellspacing=\"0\" cellpadding=\"5\" style=\"border: 1px dotted gray\" width=\"100%\">
                            <tr style=\"border-bottom:1px dotted gray;\">     
                                <td class=\"bg-gray\"><b>Data</b></td>        
                                <td class=\"bg-gray\"><b>Descrizione</b></td>
                                <td class=\"bg-gray\" align=\"right\"><b>Km</b></td>
                                <td class=\"bg-gray\" align=\"right\"><b>Importo €</b></td>
                                <td class=\"bg-gray\" align=\"right\"><small>Valuta</small></td>
                                <td class=\"bg-gray\" align=\"right\"><small>Id Giustificativo</small></td>
                            </tr>";

                foreach ($ar as $ns) {
            
                    $class = null;

                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }

                    $tasso = $ns['Notaspesa']['tasso'];
                    $importo = $ns['Notaspesa']['importo'] * $tasso;                     
                    $importo_tot += $importo;
                    $tot_km += $ns['Notaspesa']['km'];
                    $importo_return += $importo;


                    echo    "<tr".$class.">            
                                <td>".CakeTime::format($ns['Notaspesa']['data'], '%d-%m-%Y')."</td>
                                <td>".$ns['Notaspesa']['descrizione']."<small class=\"gray\">";

                                if(isset($ns['LegendaMezzi']['name'])) {
                                    echo '[' . $ns['LegendaMezzi']['name'] . ']';
                                }                  
                    echo       "</small></td> 

                                <td align=\"right\">".$this->Number->precision($ns['Notaspesa']['km'],0)."</td>           
                                <td align=\"right\">".$this->Number->currency($importo,'EUR', array('negative'=>'-'))."</td>           
                                <td align=\"right\"><small>".$ns['Notaspesa']['valuta']."";

                            if($tasso != 1) {
                                echo $ns['Notaspesa']['importo'];
                            }   

                    echo       "</small></td>
                                <td align=\"right\"><small>".$ns['Notaspesa']['id']."</small></td>
                            </tr>";

                }

                echo        "<tfoot>
                                <tr class=\"totale\">            
                                    <td class=\"bg-gray\" colspan=\"2\">Totale</td>
                                    <td class=\"bg-gray\" align=\"right\">". $this->Number->precision($tot_km,0) ."</td>
                                    <td class=\"bg-gray\" align=\"right\">".$this->Number->currency($importo_tot,'EUR', array('negative'=>'-'))."</td>
                                    <td class=\"bg-gray\" colspan=\"2\">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table><br>";
            
            }

        }

        if(isset($importo_tot))
            return $importo_return;
        else
            return '';
    }
}
