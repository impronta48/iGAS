<div class="ore view">  
    <h3><?php echo Configure::read('iGas.NomeAzienda'); ?> - report ore del mese: <?php echo "$mese - $anno"; ?></h3>
    <i>Stampa del: <?php echo date('d-m-Y  H:m'); ?> </i>
    <div class="row">
        <div class="actions">
        <?php echo $this->Html->link('PDF', ['ext'=>'pdf', $this->request->pass[0],$this->request->pass[1],$this->request->pass[2]],['class'=>'btn btn-info', 'escape'=>false]); ?>
        <?php echo $this->Html->link('XLS', ['ext'=>'xls', $this->request->pass[0],$this->request->pass[1], $this->request->pass[2]],['class'=>'btn btn-info', 'escape'=>false]); ?>
        </div>
    </div>
        <?php
        $proj_speciali[] = 'Progetto'; //Attenzione dev'essere scritto proprio così
        $proj_speciali[] = 'Totale'; //Attenzione dev'essere scritto proprio così
        $proj_speciali[] = 'Contratto';
        $proj_speciali[] = 'Eccesso';
        $ltd = 80/(count($proj_speciali)+1); ?>
    
        <?php foreach ($ore as $persona => $orePersona) 
            {      
             echo '<div class="row">';
             echo "<h3>$persona ($mese - $anno)</h3>".
                  "<table class=\"ora-persona table table-bordered\"><thead>";        
        ?>       
       <tr>           
           <th width="20%" style="text-align:right">gg</th>

           <?php 
                foreach ($proj_speciali as $s)
                {
                    echo "<TH width=\"$ltd%\">". $s ."</TH>";
                    //Inizializzo il totale
                    $somma[$s]=0;
                }
           ?>           
       </tr>
       </thead>

    <?php 

        $somma =array_merge($somma, ['Progetto'=>0,'Contratto'=>0,'Eccesso'=>0]);        
        for ($d = 1; $d<=cal_days_in_month(CAL_GREGORIAN, $mese, $anno); $d++ )
        {                                  
            echo "<TR><TD style=\"text-align:right\">" . date('D d', strtotime("$anno-$mese-$d")) . "</TD>";

            foreach ($proj_speciali as $s) {
                if (isset($orePersona[$s][$d])) {
                    $somma[$s] += $orePersona[$s][$d];
                    echo "<TD>" . $orePersona[$s][$d] . "</TD>";
                } else {
                    echo "<TD></TD>";
                }
            }
            ?>
            </TR>
            <?php
            } //Giorni
            ?> 

       <tr class="evidenza">
           <td style="text-align:right"><b>Tot <?php echo $persona ?></b></td>
           <?php 
                foreach ($proj_speciali as $s)
                {
                    echo "<td>". $somma[$s] ."</td>";                    
                }
           ?>
       </tr>
</table> </div>      
       <?php } ?>   
    
</div>