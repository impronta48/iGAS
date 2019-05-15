Gentile <?php echo $personaDisplayName;?>, 

ricevi questa mail perchè non hai caricato tutte le ore del mese.

Per favore completa il tuo foglio ore collegandoti all'indirizzo:
<?= Router::url(['controller'=>'ore','action'=>'add', 'persona'=>$personaId, 'mese'=>$mese, 'anno'=>$anno ], true); ?>

Grazie,
Lo staff di <?= Configure::read('iGas.NomeAzienda') ?>


