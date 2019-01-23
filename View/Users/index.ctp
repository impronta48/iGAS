  <h1>Elenco utenti che possono accedere al sistema</h1>
<?php echo $this->Html->link('Aggiungi Utente', 'add', array('class' => 'btn btn-primary')); ?>
  <br>
  <table  class="table dataTable">
  <tr>
  <th>User Name</th>
  <th>Gruppo</th>
  <th>Contatto</th>
  <th>Creato</th>
  <th>Modificato</th>
  <th>Azioni</th>
  </tr>
  <!-- Here is where we loop through our $users array, printing out user info -->
  <?php foreach ($users as $user): ?>
  <tr>
	<td ><?php echo $this->Html->link($user['User']['username'], 'edit'. '/'. $user['User']['id'] ); ?></td>
	<td ><?php echo $role[ $user['User']['group_id'] ]; ?>
  </td>
  <td ><?php echo $user['Persona']['DisplayName']; ?></td>
	<td ><?php echo $user['User']['created']; ?></td>
	<td ><?php echo $user['User']['modified']; ?></td>
	<td>
            <?php echo $this->Html->link('Edit', 'edit'. '/'. $user['User']['id'] ); ?>
            <?php echo $this->Html->link('Del',array('controller'=>'users', 'action'=>'delete',$user['User']['id']), null, "Sei sicuro?", false);?>
        </td>
  </tr>
  <?php endforeach; ?>
  </table>