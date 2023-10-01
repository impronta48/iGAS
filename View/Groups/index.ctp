  <p><?php echo $this->Html->link("Add Group", ['action'=>'add'], ['class'=>'btn btn-primary']); ?>
  <table class="table dataTable table-striped"  border="0" cellpadding="0" cellspacing="0">
  <tr>
  <th class="tableIndex" style="width: 30%;">Nome Gruppo</th>
  <th class="tableIndex" style="width: 30%;">Creato</th>
  <th class="tableIndex" style="width: 30%;">Modificato</th>
  <th class="tableIndex" style="width: 10%;"> </th>
  </tr>
  <!-- Here is where we loop through our $groups array, printing out group info -->
  <?php foreach ($groups as $group): ?>
  <tr>
	<td class="tableIndex"><?php echo $group['Group']['name']; ?></td>
	<td class="tableIndex"><?php echo $group['Group']['created']; ?></td>
	<td class="tableIndex"><?php echo $group['Group']['modified']; ?></td>
	<td class="tableIndex">
		<?php echo $this->Html->link('Add User to this group', ['controller' => 'users', 'action' => 'add', 'id'=>$group['Group']['id']],['class'=>'btn btn-default btn-xs']); ?>
	</td>
  </tr>
  <?php endforeach; ?>
  </table>
