<?php if (isset($this->request->params['pass'][0]))
    {
      $id = $this->request->params['pass'][0];
      echo $this->element('secondary_attivita', ['aid'=>$id]); 
      $this->Html->addCrumb("Attività", "/attivita/");
      $this->Html->addCrumb("Attività [$id]", "/attivita/edit/$id");
      $this->Html->addCrumb("Merge", "");

    }
?>
<div id="merge" class="attivita form">
    <h2>Trasferisci tutti i dati dell'attività</h2>

    <?php echo $this->Form->create('Attivita',['action' => 'merge']);?>
        <?php echo $this->Form->input('source', ['label'=>'Attività sorgente (verrà cancellata)', 'type'=>'select', 'options'=>$attivita, 'class'=>'chosen-select', 'default'=>$source]); ?>
        <?php echo $this->Form->input('dest', ['label'=>'Attività destinazione (riceverà tutti i valori)', 'class'=>'chosen-select', 'type'=>'select', 'options'=>$attivita]); ?>
    <?php echo $this->Form->end(__('Merge'));?>
</div>

