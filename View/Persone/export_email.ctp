<h1>Elenco email esportate</h1>
<h6>Puoi fare copia-incolla nel tuo programma di posta</h6>

<div class="well">
<?php
	$elenco = [];
	foreach ($persone as $p)
	{
		if (!empty($p['Persona']['email']))
		{
			$elenco[] = $p['Persona']['email'];
			
		}
	}
	$elenco = implode(', ', $elenco);
	echo $elenco;
?>
</div>

<h2>Invia mail ai destinatari (in chiaro) </h2>
<a href="mailto:<?php echo $elenco ?>" class="btn btn-primary"><i class="fa fa-mail-forward "></i> Apri una mail con questi destinatari con il tuo programma di posta</a>

<h2>Invia mail ai destinatari (in copia nascosta) </h2>
<a href="mailto:?bcc=<?php echo $elenco ?>" class="btn btn-primary"><i class="fa fa-mail-forward "></i> Apri una mail con questi destinatari in COPIA NASCOSTA / BCC con il tuo programma di posta</a>
