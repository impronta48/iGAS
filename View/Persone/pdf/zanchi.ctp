<style>
    table.ora-persona {
    page-break-after: always;
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

</style>
<div class="ore view">
    
    <h3><?php echo Configure::read('iGas.NomeAzienda'); ?> - report ore del mese: <?php echo "$mese - $anno"; ?></h3>
    <i>Stampa del: <?php echo date('d-m-Y  H:m'); ?> </i>
    <div class="row">
        <?php foreach ($ore as $key => $value) 
            {      
             echo '<div class="row">';
             echo "<h3>$key ($mese - $anno)</h3>".
                  "<table class=\"ora-persona\"><thead>";
        ?>       
       <tr>
           <th width="40%" style="text-align:right">gg</th>
            <TH width="15%">Ferie</TH>
            <TH width="15%">Malattia</TH>
            <TH width="15%">Permesso</TH>
            <TH width="15%">Progetto</TH>             
       </tr>
       </thead>

    <?php 
        $somma =array('Ferie'=>0,'Malattia'=>0,'Permesso'=>0,'Progetto'=>0);
        for ($d = 1; $d<=31; $d++ )
        {
            echo "<TR><TD style=\"text-align:right\">$d</TD>";            
                foreach ($value as $k => $o)
                {                                
                    echo "<TD>" . $o[$d]. "</TD>";  
                    $somma[$k] += $o[$d];
                }
            echo "</TR>";
        }
    ?> 
       <tr class="evidenza">
           <td style="text-align:right"><b>Tot <?php echo $key ?></b></td>
           <td><?php echo $somma['Ferie']; ?></td>
           <td><?php echo $somma['Malattia']; ?></td>
           <td><?php echo $somma['Permesso']; ?></td>
           <td><?php echo $somma['Progetto']; ?></td>
       </tr>
       </table>
       </div>
       <?php } ?>   
    
</div>