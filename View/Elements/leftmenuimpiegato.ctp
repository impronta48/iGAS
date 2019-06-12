<li>
    <a class="dropdown" href="#" data-original-title="Ore e Spese">
        <i class='fa fa-clock-o'></i><span class="hidden-minibar">Ore e Spese</span>
    </a>    
    <ul>
        <li><?php echo $this->Html->link("<i class='fa fa-bolt'></i><span class='hidden-minibar'> Inserisci Mie Ore</span>", '/ore/add/',array('escape' => false, 'data-original-title'=>'Inserici Ore')) ?></li>
    </ul>
</li>

<li>
    <a class="dropdown" href="#" data-original-title="Report">
        <i class='fa fa-bullseye'></i><span class="hidden-minibar">Report</span>
    </a>    
    <ul>
    <li>
    <?php
    if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)){ 
        echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Statistiche Ore', '/ore/stats?from='. date('Y-m-d', strtotime('first day of last month')), array('data-original-title'=>'Statistiche Ore','escape' => false));
    } else {
        echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Statistiche Ore', '/ore/stats?from='. date('Y-m-d', strtotime('first day of last month')).'&persone='.$this->Session->read('Auth.User.persona_id'), array('data-original-title'=>'Statistiche Ore','escape' => false));
    }
    ?>
    </li>
    </ul>
</li>    