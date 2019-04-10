<nav class="navbar navbar-default">
  <div class="container-fluid">

    <ul class="nav navbar-nav top-navbar ">
        <li ><?php echo $this->Html->link('Attivit&agrave;', array('controller' => 'attivita', 'action'=>'edit', $aid), array('escape'=>false, )); ?></li>
        <li ><?php echo $this->Html->link('Fatture Emesse', array('controller' => 'attivita', 'action'=>'fatture', $aid), array('escape'=>false, )); ?></li>
        <li ><?php echo $this->Html->link('Documenti Ricevuti', array('controller' => 'fatturericevute', 'action'=>'index', 'attivita' => $aid), array('escape'=>false, )); ?></li>
        <li ><?php echo $this->Html->link('Prima Nota', array('controller' => 'primanota', 'action'=>'index', $aid), array('escape'=>false, )); ?></li>
        <li ><?php echo $this->Html->link('Fasi/Prodotti', array('controller' => 'faseattivita', 'action'=>'index', $aid), array('escape'=>false, )); ?></li>
        <li ><?php echo $this->Html->link('Ore', array('controller' => 'ore', 'action'=>'detail', '?'=>array('attivita[]' => "$aid")), array('escape'=>false, )); ?></li>
        <li ><?php echo $this->Html->link('Nota Spese', array('controller' => 'notaspese', 'action'=>'detail', '?'=>array('attivita[]' => "$aid")), array('escape'=>false, )); ?></li>
        <li ><?php echo $this->Html->link('Avanzamento', array('controller' => 'attivita', 'action'=>'avanzamento', $aid), array('escape'=>false, )); ?></li>
        <li class="pull-right" ><?php echo $this->Html->link('Merge', array('controller' => 'attivita', 'action'=>'merge', $aid), array('escape'=>false )); ?></li>
    </ul>
</div>
</nav>
