<li>
    <a class="dropdown" href="#" data-original-title="Ore e Spese">
        <i class='fa fa-clock-o'></i><span class="hidden-minibar">Ore e Spese</span>
    </a>    
    <ul>
        <li><?php echo $this->Html->link("<i class='fa fa-bolt'></i><span class='hidden-minibar'> Inserisci Mie Ore</span>", '/ore/add/',['escape' => false, 'data-original-title'=>'Inserici Ore']) ?></li>
        <li><?php echo $this->Html->link("<i class='fa fa-clock-o'></i><span class='hidden-minibar'> Inserisci Ore</span>", '/ore/scegli_persona',['escape' => false, 'data-original-title'=>'Inserici Ore']) ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-table'></i><span class='hidden-minibar'> Gestione Foglio Ore</span>", '/ore/riassuntocaricamenti/'. date("Y"),['escape' => false, 'data-original-title'=>'Gestione Foglio Ore']) ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-table'></i><span class='hidden-minibar'> Check Ore</span>", '/ore/check/'. date("Y"),['escape' => false, 'data-original-title'=>'Check Ore']) ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-briefcase'></i><span class='hidden-minibar'> Nota Spese</span>", '/notaspese/scegli_persona',['escape' => false, 'data-original-title'=>'Nota Spese']) ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-mobile'></i><span class='hidden-minibar'> Inserici Ore (Mobile)</span>", '/ore/addMobile',['escape' => false, 'data-original-title'=>'Inserici Ore Mobile']) ?></li>

    </ul>
</li>

<li>
    <a class="dropdown" href="#" data-original-title="Report">
        <i class='fa fa-bullseye'></i><span class="hidden-minibar">Report</span>
    </a>    
    <ul>
    <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Statistiche Note Spese', '/notaspese/stats?from='. date('Y-m-d', strtotime('first day of last month')), ['data-original-title'=>'Statistiche Note Spese','escape' => false]) ?></li>
    <li>
    <?php
    if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)){ 
        echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Statistiche Ore', '/ore/stats?from='. date('Y-m-d', strtotime('first day of last month')), ['data-original-title'=>'Statistiche Ore','escape' => false]);
    } else {
        echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Statistiche Ore', '/ore/stats?from='. date('Y-m-d', strtotime('first day of last month')).'&persone='.$this->Session->read('Auth.User.persona_id'), ['data-original-title'=>'Statistiche Ore','escape' => false]);
    }
    ?>
    </li>
    </ul>
</li>    