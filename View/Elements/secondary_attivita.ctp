<nav class="navbar navbar-default">
  <div class="container-fluid">

    <ul class="nav navbar-nav top-navbar ">
        <li ><?php echo $this->Html->link('Attivit&agrave;', ['controller' => 'attivita', 'action'=>'edit', $aid], ['escape'=>false, ]); ?></li>
        <li ><?php echo $this->Html->link('Fatture Emesse', ['controller' => 'attivita', 'action'=>'fatture', $aid], ['escape'=>false, ]); ?></li>
        <li ><?php echo $this->Html->link('Documenti Ricevuti', ['controller' => 'fatturericevute', 'action'=>'index', 'attivita' => $aid], ['escape'=>false, ]); ?></li>
        <li ><?php echo $this->Html->link('Prima Nota', ['controller' => 'primanota', 'action'=>'index', $aid], ['escape'=>false, ]); ?></li>
        <li ><?php echo $this->Html->link('Fasi/Prodotti', ['controller' => 'faseattivita', 'action'=>'index', $aid], ['escape'=>false, ]); ?></li>
        <li ><?php echo $this->Html->link('Ore', ['controller' => 'ore', 'action'=>'detail', '?'=>['attivita[]' => "$aid"]], ['escape'=>false, ]); ?></li>
        <li ><?php echo $this->Html->link('Nota Spese', ['controller' => 'notaspese', 'action'=>'detail', '?'=>['attivita[]' => "$aid"]], ['escape'=>false, ]); ?></li>
        <li ><?php echo $this->Html->link('Avanzamento', ['controller' => 'attivita', 'action'=>'avanzamento', $aid], ['escape'=>false, ]); ?></li>
        <li class="pull-right" ><?php echo $this->Html->link('Merge', ['controller' => 'attivita', 'action'=>'merge', $aid], ['escape'=>false ]); ?></li>
    </ul>
</div>
</nav>
