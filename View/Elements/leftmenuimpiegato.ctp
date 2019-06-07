<li>
    <a class="dropdown" href="#" data-original-title="Attività">
        <i class='fa fa-bullseye'></i><span class="hidden-minibar">Attività</span>
    </a>    
    <ul>
        <li id="menu-attivita">
        <?php echo $this->Html->link("<i class='fa fa-book'></i><span class='hidden-minibar'>Lista Attività</span>", '/attivita',array('escape' => false, 'data-original-title'=>'Attività')) ?>
        </li>
    </ul>
</li>

<li>
    <a class="dropdown" href="#" data-original-title="Contatti">
        <i class='fa fa-user'></i><span class="hidden-minibar">Contatti</span>
    </a>    
    <ul>
        <li><?php echo $this->Html->link("<i class='fa fa-user'></i><span class='hidden-minibar'> Contatti</span>", '/persone',array('escape' => false, 'data-original-title'=>'Contatti')) ?></li>
        <li><?php echo $this->Html->link("<i class='fa fa-user'></i><span class='hidden-minibar'> Impiegati</span>", '/impiegati',array('escape' => false, 'data-original-title'=>'Impiegati')) ?></li>        
    </ul>
</li>

<li>
    <a class="dropdown" href="#" data-original-title="Ore e Spese">
        <i class='fa fa-clock-o'></i><span class="hidden-minibar">Ore e Spese</span>
    </a>    
    <ul>
        <li><?php echo $this->Html->link("<i class='fa fa-bolt'></i><span class='hidden-minibar'> Inserisci Mie Ore</span>", '/ore/add/',array('escape' => false, 'data-original-title'=>'Inserici Ore')) ?></li>
        <li><?php echo $this->Html->link("<i class='fa fa-clock-o'></i><span class='hidden-minibar'> Inserisci Ore</span>", '/ore/scegli_persona',array('escape' => false, 'data-original-title'=>'Inserici Ore')) ?></li>
    </ul>
</li>

<li>
    <a class="dropdown" href="#" data-original-title="Report">
        <i class='fa fa-bullseye'></i><span class="hidden-minibar">Report</span>
    </a>    
    <ul>
        <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Statistiche Note Spese', '/notaspese/stats?from='. date('Y-m-d', strtotime('first day of last month')), array('data-original-title'=>'Statistiche Note Spese','escape' => false)) ?></li>
    </ul>
</li>    