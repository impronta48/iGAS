<style>
    table.ora-persona {
    page-break-after: always;
    width: 100% !important;
}
.evidenza {
    font-weight: bolder;
    border: 1px solid black;
    }
    
    table.ora-persona tr td {
    padding: 0 2em 0 0 !important;
    }

    table.ora-persona td {
        border-bottom: 1px solid gray;
    }
    
    table.ora-persona tr td,
    table.ora-persona tr th
    {
        padding: 0 2em 0 0 !important;
    }
    table {
    border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid silver;
    }
</style>
<div class="ore view">  
    <h3><?php echo Configure::read('iGas.NomeAzienda'); ?> - report ore del mese: <?php echo "$mese - $anno"; ?></h3>
    
        <?php foreach ($ore as $key => $value) {      
             echo '<div class="row">';
             echo "<h3>$key ($mese - $anno)</h3>".
                "<table class=\"ora-persona table table-bordered\" style=\"width:100%\" ><thead>";
        ?>       
       <tr class="thead-inverse">
           <th width="5%" style="text-align:right">Giorno</th>
		  <?php
		    $numElementi = count($value);

		    foreach($value as $k => $colAtt) {
				    $nome = $colAtt['nome'];
				    $dimensione = 65/$numElementi;

				    if(in_array($k, $special)) {
					    echo '<th class ="success" width="10%">'.$nome.'</th>';
				    }
				    else
				      echo '<th width="'.$dimensione.'%">'.$nome.'</th>';

				    $somma[$k] = 0;
			  } 
		  ?>       
       </tr>
       </thead>

    <?php 
        for ($d = 1; $d <= $giorni; $d++ ) {
            echo "<tr><td style=\"text-align:right\">$d</td>";

            foreach ($value as $k => $o) {
                if(in_array($k, $special))				
				            echo '<td class="success">' . $o['ore'][$d]. "</td>";
				        else
					          echo "<td>" . $o['ore'][$d]. "</td>";
				   
                $somma[$k] += $o['ore'][$d]; 
            }           
            echo "</tr>";
        }
    ?> 
       <tr class="evidenza">
           <td style="text-align:right"><b>Totale</b></td>
		   <?php
		    foreach($value as $k => $colAtt) {
				    echo '<Th width="15%">'.$somma[$k].'</TH>';	
			  } 
		   ?>   
       </tr>
</table> </div>      
       <?php } ?>   
  <i>Stampa del: <?php echo date('d-m-Y  H:m'); ?> </i>
</div>