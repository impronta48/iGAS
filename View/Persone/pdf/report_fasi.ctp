<style>
    table.ora-persona {
    page-break-after: always;
    width: 100%;
    }
.evidenza {
    font-weight: bolder;
    border: 1px solid black;
    }
    
    table.ora-persona tr td {
    padding: 0 0 0 0 !important;
    }

    table.ora-persona td {
        border-bottom: 1px solid gray;
    }
    
    table.ora-persona tr td,
    table.ora-persona tr th
    {
        padding: 0 0 0 0 !important;
    }
    table {
    border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }
    td {
      width:1em;
    }
</style>
<div class="ore view">  
    <h3><?php echo Configure::read('iGas.NomeAzienda'); ?> - report ore del mese: <?php echo "$mese - $anno"; ?></h3>
    <i>Stampa del: <?php echo date('d-m-Y  H:m'); ?> </i>  
    
    <?php foreach ($ore as $key => $value) {      
        echo '<div class="row">';
        echo "<h3>$key ($mese - $anno)</h3>".
        "<table class=\"ora-persona table table-bordered\"><thead>";

        $sommaday[] = [];

    ?>       
     <tr class="thead-inverse">
         <th>Attivit&agrave;</th>
	   <?php

     for ($d = 1; $d <= $giorni; $d++ ) {
        echo '<th>'.$d.'</th>';
        $sommaday[$d] = 0;
     }

		   ?>  

       <th class="evidenza">Totale</th>      
       </tr>
       </thead>

    <?php 

      foreach ($value as $k => $o) {

        echo "<tr style=\"background:silver\"><td style=\"text-align:right;\">".$o['nome']."</td>";

        for ($d = 1; $d <= $giorni; $d++ ) {
            echo "<td></td>";
        }

        echo "<td class=\"evidenza\">".$o['somma']."</td>";

        foreach ($o['fase'] as $fas) {
          echo "<tr><td style=\"text-align:right; font-size:small; color: gray\">".$fas['nome']."</td>";

          for ($d = 1; $d <= $giorni; $d++ ) {
            if ($fas['ore'][$d] == 0)
            {
              echo "<td>&nbsp;</td>";
            }
            else
            {
              echo "<td>" . $fas['ore'][$d]. "</td>";
            }
            $sommaday[$d] += $fas['ore'][$d];
          }

          echo "<td class=\"evidenza\">".$fas['somma']."</td>";
        }

       echo "</tr>";
      }
    ?> 
       <tr class="evidenza">
           <td><b>Totale</b></td>
		   <?php
		      for ($d = 1; $d <= $giorni; $d++ ) {
            echo "<td>" .$sommaday[$d]. "</td>";
          }
       echo "<td class=\"evidenza\"></td>";
		   ?>   
       </tr>
</table> </div>      
       <?php } ?>
  
</div>