<div class="ore view">  
    <h3><?php echo Configure::read('iGas.NomeAzienda'); ?> - report ore del mese: <?php echo "$mese - $anno"; ?></h3>
    <i>Stampa del: <?php echo date('d-m-Y  H:m'); ?> </i>
    <div class="row">
        <div class="actions">
        <?php echo $this->Html->link('Stampa', array('mode'=>'print', $this->request->pass[0],$this->request->pass[1]),array('class'=>'btn btn-info', 'escape'=>false)); ?>
        <?php echo $this->Html->link('PDF', array('mode'=>'print', $this->request->pass[0],$this->request->pass[1], 'ext'=>'pdf', 0,'foglio_ore'), array('class'=>'btn btn-info', 'escape'=>false)); ?>
        </div>
    </div>
    
    
        <?php foreach ($ore as $key => $value) 
            {      
             echo '<div class="row">';
             echo "<h3>$key ($mese - $anno)</h3>".
                  "<table class=\"ora-persona table table-bordered\"><thead>";
        ?>       
       <tr>
           <th width="40%" style="text-align:right">gg</th>
            <TH width="15%">Ferie</TH>
            <TH width="15%">Malattia</TH>
            <TH width="15%">Permesso</TH>
            <TH width="15%">Lavoro</TH>             
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
</table> </div>      
       <?php } ?>   
    
</div>