<h2>Attività e Fasi</h2>

<?php foreach ($attivita as $a): ?>
	<?php echo $a['Attivita']['id'] . ' - ' . $a['Attivita']['name'] ?>
	<ul>
	<?php foreach ($a['Faseattivita'] as $f): ?>
	<li><?php echo $f['id'] . ' - ' .$f['Descrizione'] ?></li>
	<?php endforeach ?>
	</ul>
<?php endforeach ?>
