<?php echo $this->Form->create('Group', array('action' => 'add')); ?>
<table class="tableIndexSmall"  border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <th class="tableIndexSmall"  style="width: 250px;"><?php echo $this->Form->input('name');?></th>
    </tr>
    <tr>
      <th class="tableIndexSmall" style="width: 250px;"><?php echo $this->Form->end('Salva Gruppo');?></th>
    </tr>
  </tbody>
</table>