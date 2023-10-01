<h2>Avanzamento Attivit&agrave;: <a href="<?php echo $this->Html->url('edit/'. $attivita['Attivita']['id']); ?>">
	<?php echo $attivita['Attivita']['name']; ?>
</a> <?php echo date('d-m-Y') ?></h2>

<i>In queste spese sono considerati solo i documenti pagati, e non quelli ricevuti</i>

<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% TABELLA 1 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<h3 class="text-center">Entrate (Avanzamento)</h3>

<p></p>

<?php 
	$tot = 0;
	$totIva = 0;
	$totspese = 0;
	$pnEntrate = 0;
	$pnUscite = 0;
	$totnumore = 0;
	$totcostoore= 0;
	$totnotaspese = 0;
	$totuscite = 0;
	$totavanzo = 0;
?>

<table class="table table-striped">

	<thead class="bg-info">

		<tr>
			<th width="30%">Fase</th>
			<th>Preventivo</th>
			<th>Preventivo(IVA Inclusa)</th>
			<th>Entrate Effettive</th>
			<th>Scostamento</th>
		</tr>

	</thead>

	<tbody>
		
	<?php	foreach($attivita['Faseattivita'] as $f): 
			if ($f['entrata']):
	?>

		<tr>
			<td><?php echo $f['Descrizione']?></td>
			<td><?php $preventivo = $f['costou']*$f['qta']; echo $this->Number->currency($preventivo); $tot += $preventivo; ?></td>
			<td><?php $preventivoIva = $f['costou']*$f['qta']*(1 + $LegendaCodiciIva[$f['legenda_codici_iva_id']]); echo $this->Number->currency($preventivoIva); $totIva += $preventivoIva; ?></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'primanota', 'action'=>'index', 'fase' => $f['id'], '?' => ['valore' => 'positivo']]) ?>">
			<?php
				if (isset($pn[$f['id']]['Entrate'])) {
					$speseEntrate = $pn[$f['id']]['Entrate'];
				} else {
					$speseEntrate = 0;
				}

				echo $this->Number->currency($speseEntrate);
				$pnEntrate += $speseEntrate ;?></a></td>

			<?php $avanzo = $speseEntrate - $preventivoIva;
				if ($avanzo >= 0) {
                    $cl = 'text-success';
            	} else {
                    $cl = 'text-danger';
            	}
				echo "<td class=\"$cl\"> ".$this->Number->currency($avanzo);
				$totavanzo += $avanzo;?></td>
		</tr>

	<?php 
			endif;
			endforeach;
	?>

		<tr>
			<td><b>Non attribuito a nessuna fase</b></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'primanota', 'action'=>'index/' . $attivita['Attivita']['id'], 'fase' => '', '?' => ['valore' => 'positivo']]) ?>">
		<?php   if (isset($pn['']['Entrate'])) {
					$speseEntrate = $pn['']['Entrate'];
				} else {
				$speseEntrate = 0;
				}

				echo $this->Number->currency($speseEntrate);
				$pnEntrate += $speseEntrate;
		?></a></td> <?php

			$avanzo = $speseEntrate;

			if ($avanzo >= 0) {
                        $cl = 'text-success';
            } else {
                        $cl = 'text-danger';
            }

			echo "<td class=\"$cl\"> ".$this->Number->currency($avanzo);
			$totavanzo += $avanzo;?></td>
		</tr>
		
	</tbody>

<?php if($totavanzo > 0) {
		$c = 'bg-success';
	} else {
		$c = 'bg-danger';
	} ?>

	<tfoot>

		<tr class="bg-success">
			<td width="30%">Totale</td>
			<td><?php echo  $this->Number->currency($tot); ?></td>
			<td><?php echo  $this->Number->currency($totIva); ?></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'primanota', 'action'=>'index/' . $attivita['Attivita']['id'], '?' => ['valore' => 'positivo']]) ?>"><?php echo  $this->Number->currency($pnEntrate); ?></a></td>
			<td class="<?php echo $c ?>"><b><?php echo  $this->Number->currency($totavanzo); ?></b></td>
		</tr>

	</tfoot>

</table>

<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% TABELLA 2 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->

<?php
	$totIva = 0; 
	$totspese = 0;
	$pnUscite = 0;
	$totnumore = 0;
	$totcostoore= 0;
	$totnotaspese = 0;
	$totuscite = 0;
	$totavanzo = 0;
?>
<br>

<h3 class="text-center">Uscite (Avanzamento rispetto alle Spese Previste)</h3>

<p></p>

<table class="table table-striped">

	<thead>

		<tr class="bg-info">
			<th width="30%">Fase</th>
			<th>Preventivo<br>(IVA inclusa)</th>
			<th>Primanota</th>
			<th>Notaspese<br>(Da pagare)</th>
			<th>Spese Ore</th>
			<th>Risultato</th>
		</tr>

	</thead>

	<tbody>
		
	<?php	foreach($attivita['Faseattivita'] as $f):
			if (!$f['entrata']):
	?>

		<tr>
			<td><?php echo $f['Descrizione']?></td>
			<td><?php $preventivoIva = $f['costou']*$f['qta']*(1 + $LegendaCodiciIva[$f['legenda_codici_iva_id']]); echo $this->Number->currency($preventivoIva); $totIva += $preventivoIva; ?></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'primanota', 'action'=>'index', 'fase' => $f['id'], '?' => ['valore' => 'negativo']]) ?>">
			<?php
				if (isset($pn[$f['id']]['Uscite'])) {
					$speseUscite = -1*$pn[$f['id']]['Uscite'];
				} else {
					$speseUscite = 0;
				}

				echo $this->Number->currency($speseUscite);
				$pnUscite += $speseUscite ;?></a></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'notaspese', 'action'=>'detail', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .",", 'as_values_faseattivita' => $f['id'].","]]) ?>">
			<?php 
				if(isset($notaspese[$f['id']])) {
						$ns = $notaspese[$f['id']];
					} else {
						$ns = 0;
					} 

					$totnotaspese += $ns;
					echo $this->Number->currency($ns);?></a></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'ore', 'action'=>'stats', '?'=>['fase' => $f['id'] .","]]) ?>"><?php 	
				        //Estraggo le ore
						if(isset($hh[$f['id']])) {
							$numore = $hh[$f['id']];
						} else {
							$numore = 0;
						}

						$costoore = 0;

            			//Moltiplico e scrivo
            			if ($f['um']=='ore') {
							$costoore = $f['costou'] * $numore;
							echo $this->Number->currency($costoore).'</a><small class="text-muted"> ('.$numore.'<small>h</small> x '.$this->Number->currency($f['costou']).')</small>';
							$totcostoore += $costoore;
						} else if ($f['um']=='gg') {
                			$costoore = $f['costou']/8 * $numore;
							echo $this->Number->currency($costoore).'</a><small class="text-muted"> ('.$numore.'<small>h</small> x '.$this->Number->currency($f['costou']).')</small>';
							$totcostoore += $costoore;
    					} else {
    						echo $this->Number->currency(0);
    					}

            			$totnumore += $numore; ?></td>
			<?php $avanzo= $preventivoIva - $costoore - $ns - $speseUscite;

				if ($avanzo >= 0) {
                    $cl = 'text-success';
            	} else {
                    $cl = 'text-danger';
            	}
				echo "<td class=\"$cl\"> ".$this->Number->currency($avanzo);
				$totavanzo += $avanzo;?></td>
		</tr>

	<?php endif;
		 endforeach; 
	?>

		<tr>
			<td><b>Non attribuito a nessuna fase</b></td>
			<td>&nbsp;</td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'primanota', 'action'=>'index/' . $attivita['Attivita']['id'], 'fase' => '', '?' => ['valore' => 'negativo']]) ?>">
		<?php   if (isset($pn['']['negativo'])) {
					$speseEntrate = -1*$pn['']['negativo'];
				} else {
				$speseUscite = 0;
				}

				echo $this->Number->currency($speseUscite);
				$pnUscite += $speseUscite;
		?></a></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'notaspese', 'action'=>'detail', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .",", 'as_values_faseattivita' => ''.","]]) ?>">
			<?php if (isset($notaspese['']) && isset($notaspese[0])) {
							$ns = $notaspese[''] + $notaspese[0];
						} else if (isset($notaspese[''])){
							$ns = $notaspese[''];
						} else if (isset($notaspese[0])){
							$ns = $notaspese[0];
						} else {
							$ns = 0;
						}
						echo  $this->Number->currency($ns); $totnotaspese += $ns;?></a></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'ore', 'action'=>'stats', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .","]]) ?>"><?php 	
				        //Estraggo le ore
						if(isset($hh['']) && isset($hh[0])) {
							$numore = $hh[''] + $hh[0];
						} else if (isset($hh[''])) {
							$numore = $hh[''];
						} else if (isset($hh[0])) {
							$numore = $hh[0];
						} else {
							$numore = 0;
						}

            			//Moltiplico e scrivo
            			//Do per scontato che non vi siano giorni per le NON-Fasi
						$costoore = 30 * $numore;
						echo $this->Number->currency($costoore).'</a><small class="text-muted"> ('.$numore.'<small>h</small> x '.$this->Number->currency(30).')</small>';
						$totcostoore += $costoore;
            			$totnumore += $numore; ?></td>
				<?php $avanzo = 0 - $costoore - $ns - $speseUscite;

					if ($avanzo >= 0) {
                    	$cl = 'text-success';
            		} else {
                    	$cl = 'text-danger';
            		}
					echo "<td class=\"$cl\"> ".$this->Number->currency($avanzo);
					$totavanzo += $avanzo;?></td>
		</tr>
		
	</tbody>

<?php if($totavanzo > 0) {
		$c = 'bg-success';
	} else {
		$c = 'bg-danger';
	} ?>

	<tfoot>

		<tr class="bg-success">
			<td width="30%">Totale</td>
			<td><?php echo  $this->Number->currency($totIva); ?></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'primanota', 'action'=>'index/' . $attivita['Attivita']['id'], '?' => ['valore' => 'negativo']]) ?>"><?php echo  $this->Number->currency($pnUscite); ?></a></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'notaspese', 'action'=>'detail', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .","]]) ?>"><?php echo  $this->Number->currency($totnotaspese); ?></a></td>
			<td><a href="<?php echo $this->Html->url(['controller'=>'ore', 'action'=>'stats', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .","]]) ?>"><?php echo $this->Number->currency($totcostoore); ?></a></td>
			<td class="<?php echo $c ?>"><b><?php echo  $this->Number->currency($totavanzo); ?></b></td>
		</tr>

	</tfoot>

</table>


<!-------- fine spese effettivamente sostenute ------> 
<br>
<hr>
<br>
<!-------- inizio spese da documenti ricevuti ------> 

<h3 class="text-center">Incassi Previsti (da Documenti)</h3>
<i>In queste spese sono considerati solo i documenti ricevuti, e non quelli pagati</i>
<table class="table table-striped">
<thead>
<tr class="bg-info">
	<th width="30%">Fase</th>
	<th>Preventivo<br>(A - IVA Inclusa)</th>
	
	<th>Documenti Emessi<br>(B)</th>
	
	<th><small>Ore</small></th>
	<th><small>Costo Orario</small></th>
	<th>Costo Ore<br>(C)</th>	
	<th>NoteSpese<br>(D)</th>
	
	<th>Entrate<br></th>	
	<th>Mancanza<br>(A-B)</th>
</tr>
</thead>

<tbody>
<?php 
	$tot = 0;
	$totspese = 0;
	$totnumore = 0;
	$totcostoore= 0;
	$totnotaspese = 0;
	$totuscite = 0;
	$totavanzo = 0;
	foreach($attivita['Faseattivita'] as $f) : 
		if ($f['entrata']):
	?>
	<tr>
		<td><?php echo $f['Descrizione']?>  <small>[<?php echo $f['qta']?> <?php echo $f['um']?> * <?php echo $f['costou']?> &euro;]</small>
		
		</td>
		<td><?php $preventivo = $f['costou']*$f['qta']*(1 + $LegendaCodiciIva[$f['legenda_codici_iva_id']]); echo $this->Number->currency($preventivo); $tot +=$preventivo; ?></td>
		
		<td>
           <a href="<?php echo $this->Html->url(['controller'=>'primanota', 'action'=>'index', 'fase' => $f['id']]) ?>">
		<?php
            
			//Devo  estrarre le spese (prima nota) per questa fase e questa attività
			if (isset($dr[$f['id']]))
			{
				$spese = $dr[$f['id']];
			}
			else
			{
				$spese = 0;
			}
			echo $this->Number->currency($spese);
			$totspese += $spese;
		?>
            </a>
		</td>
		
		<td><small>
		<?php
			//Devo  estrarre il numero di ore per questa fase e questa attività
			if (isset($hh[$f['id']]))
			{
				$numore = $hh[$f['id']];
			}
			else
			{
				$numore = 0;
			}			
            if ($numore > 0)
            {
                echo $this->Html->link("$numore (" . $numore/8 ."gg)", ['controller'=>'ore', 
                                                      'action'=>'stats', 
                                                      '?'=>['fase' => $f['id']]]);   
            }
            else {
                echo $numore;
            }
            
			$totnumore += $numore;
		?>
		</small></td>
		
		<td><small>
		<?php
			//Il costo orario di questa fase
			if ($f['um']=='ore')
			{
				echo $this->Number->currency($f['costou']);
			}
            else if($f['um']=='gg')
            {
                echo $this->Number->currency($f['costou']/8);
            }
		?>
		</small></td>
		
		<td>
		<?php
			$costoore=0;
			//Moltiplico il numero di ore per il corsto orario
			if ($f['um']=='ore')
			{
				$costoore = $f['costou'] * $numore;
				echo $this->Number->currency($costoore);
				$totcostoore += $costoore;
			}
            else if ($f['um']=='gg')
            {
                $costoore = $f['costou']/8 * $numore;
				echo $this->Number->currency($costoore);
				$totcostoore += $costoore;
            }
		?>
		</td>
		
		<td>
		<?php
			//Devo  estrarre il totale delle note spese per questa fase e questa attività
			$ns = 0;
		?>
		</td>
		
		<td>
		<?php
			//Scrivo il totale delle spese per questa fase
			$uscite = $costoore + $ns + $spese;
			echo $this->Number->currency($uscite);
			$totuscite += $uscite;
		?>
		</td>

		<?php
			//Devo  estrarre il totale delle note spese per questa fase e questa attività
			$avanzo= $preventivo - $uscite;

			if ($avanzo >= 0) {
                        $cl = 'text-success';
            } else {
                        $cl = 'text-danger';
            }

			echo "<td class=\"$cl\"> ".$this->Number->currency($avanzo);
			
			$totavanzo += $avanzo;
		?>
		</td>
	</tr>
<?php endif; 
	endforeach; 
?>

	
</tbody>

<tfoot>
    <?php 
			if  ($totavanzo > 0)
			{
				$c = 'bg-success';
			}
			else
			{
				$c = 'bg-danger';
			}
    ?>
	<tr class="bg-success">
		<td class="bg-success" width="30%">Totale</td>
		<td class="bg-success"><?php echo  $this->Number->currency($tot); ?></td>
		<td class="bg-success"> 
            
            <a href="<?php echo $this->Html->url(['controller'=>'fatturericevute', 'action'=>'index/attivita:' . $attivita['Attivita']['id']]) ?>">
                    <?php echo  $this->Number->currency($totspese); ?>
            </a>
        </td>   
		<td class="bg-success">
            <small>
            <a href="<?php echo $this->Html->url(['controller'=>'ore', 'action'=>'stats', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .","]]) ?>">
                <?php echo "$totnumore (" . $totnumore/8 ."gg)"; ?>
            </a>
            </small>
        </td>
		<td class="bg-success"></td>
		<td class="bg-success"><?php echo  $this->Number->currency($totcostoore); ?></td>
		<td class="bg-success">
            <a href="<?php echo $this->Html->url(['controller'=>'notaspese', 'action'=>'stats', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .","]]) ?>">
            <?php echo  $this->Number->currency($totnotaspese); ?>
            </a>
        </td>
		<td class="bg-success"><?php echo  $this->Number->currency($totuscite); ?></td>
		<td class="<?php echo $c ?>"><b><?php echo  $this->Number->currency($totavanzo); ?></b></td>
	</tr>
</tfoot>
</table>



<h3 class="text-center">Consuntivo Spese (da Documenti Ricevuti)</h3>
<i>In queste spese sono considerati solo i documenti ricevuti, e non quelli pagati</i>
<table class="table table-striped">
<thead>
<tr class="bg-info">
	<th width="30%">Fase</th>
	<th>Preventivo<br>(A - IVA Inclusa)</th>
	
	<th>Documenti Ricevuti<br>(B)</th>
	
	<th><small>Ore</small></th>
	<th><small>Costo Orario</small></th>
	<th>Costo Ore<br>(C)</th>
	
	<th>NoteSpese<br>(D)</th>
	
	<th>Totale Uscite <br>(B+C+D)</th>	
	<th>Avanzo<br>(A+B+C+D)</th>
</tr>
</thead>

<tbody>
<?php 
	$tot = 0;
	$totspese = 0;
	$totnumore = 0;
	$totcostoore= 0;
	$totnotaspese = 0;
	$totuscite = 0;
	$totavanzo = 0;
	foreach($attivita['Faseattivita'] as $f) : 
		if (!$f['entrata']):
	?>
	<tr>
		<td><?php echo $f['Descrizione']?>  <small>[<?php echo $f['qta']?> <?php echo $f['um']?> * <?php echo $f['costou']?> &euro;]</small>
		
		</td>
		<td><?php $preventivo = $f['costou']*$f['qta']*(1 + $LegendaCodiciIva[$f['legenda_codici_iva_id']]); echo $this->Number->currency($preventivo); $tot +=$preventivo; ?></td>
		
		<td>
           <a href="<?php echo $this->Html->url(['controller'=>'primanota', 'action'=>'index', 'fase' => $f['id']]) ?>">
		<?php
            
			//Devo  estrarre le spese (prima nota) per questa fase e questa attività
			if (isset($dr[$f['id']]))
			{
				$spese = $dr[$f['id']];
			}
			else
			{
				$spese = 0;
			}
			echo $this->Number->currency($spese);
			$totspese += $spese;
		?>
            </a>
		</td>
		
		<td><small>
		<?php
			//Devo  estrarre il numero di ore per questa fase e questa attività
			if (isset($hh[$f['id']]))
			{
				$numore = $hh[$f['id']];
			}
			else
			{
				$numore = 0;
			}			
            if ($numore > 0)
            {
                echo $this->Html->link("$numore (" . $numore/8 ."gg)", ['controller'=>'ore', 
                                                      'action'=>'stats', 
                                                      '?'=>['fase' => $f['id']]]);   
            }
            else {
                echo $numore;
            }
            
			$totnumore += $numore;
		?>
		</small></td>
		
		<td><small>
		<?php
			//Il costo orario di questa fase
			if ($f['um']=='ore')
			{
				echo $this->Number->currency($f['costou']);
			}
            else if($f['um']=='gg')
            {
                echo $this->Number->currency($f['costou']/8);
            }
		?>
		</small></td>
		
		<td>
		<?php
			$costoore=0;
			//Moltiplico il numero di ore per il corsto orario
			if ($f['um']=='ore')
			{
				$costoore = $f['costou'] * $numore;
				echo $this->Number->currency($costoore);
				$totcostoore += $costoore;
			}
            else if ($f['um']=='gg')
            {
                $costoore = $f['costou']/8 * $numore;
				echo $this->Number->currency($costoore);
				$totcostoore += $costoore;
            }
		?>
		</td>
		
		<td>
		<?php
			//Devo  estrarre il totale delle note spese per questa fase e questa attività
			$ns = 0;
		?>
		</td>
		
		<td>
		<?php
			//Scrivo il totale delle spese per questa fase
			$uscite = $costoore + $ns + $spese;
			echo $this->Number->currency($uscite);
			$totuscite += $uscite;
		?>
		</td>		
		<?php
			//Devo  estrarre il totale delle note spese per questa fase e questa attività
			$avanzo= $preventivo - $uscite;
			if ($avanzo >= 0) {
                        $cl = 'text-success';
            } else {
                        $cl = 'text-danger';
            }

			echo "<td class=\"$cl\"> ".$this->Number->currency($avanzo);			
			$totavanzo += $avanzo;
		?>
		</td>
	</tr>
<?php endif; 
	endforeach; 
?>

	<tr>
		<td><b>Non attribuito a nessuna fase</b></td>
		<td>&nbsp;</td>
		
		<td>
            <a href="<?php echo $this->Html->url(['controller'=>'fatturericevute', 'action'=>'index/attivita:' . $attivita['Attivita']['id'], 'fase' => '']) ?>">
		<?php
			//Devo  estrarre le spese (documenti ricevuti) per questa fase e questa attività
			if (isset($dr['']))
			{
				$spese = $dr[''];
				
			}
			else
			{
				$spese = 0;
			}			
			echo $this->Number->currency($spese);
			$totspese += $spese;
		?>
            </a>
		</td>
		<td><small>
             <a href="<?php echo $this->Html->url(['controller'=>'ore', 'action'=>'stats', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] . ",", 'fase'=> 0]]) ?>">   
		<?php		
			//Devo  estrarre il numero di ore non associate a nessuna attivita
            $numore = 0;
			if(isset($hh['']) && isset($hh[0])) {
				$numore = $hh[''] + $hh[0];
			} else if (isset($hh[''])) {
				$numore = $hh[''];
			} else if (isset($hh[0])) {
				$numore = $hh[0];
			} else {
				$numore = 0;
			}
			echo "$numore (" . $numore/8 ."gg)";
			$totnumore += $numore;
		?>
            </a>
		</small></td>
		
		<td><small>
			30€
		</small></td>
		
		<td>
		<?php 
			$costoore = 30 * $numore;
			echo $this->Number->currency($costoore);
			$totcostoore +=$costoore;
		?>
		</td>
				
		<td><?php 
			if(!empty($notaspese)) {
				$ns = $notaspese[''];
			} else {
				$ns= 0;
			}

                  echo  $this->Number->currency($ns) ; 
                  $totnotaspese +=$ns; 
            ?>
		</td>
		<td>
		<?php
			//Scrivo il totale delle spese per questa fase
			$uscite = $costoore + $ns + $spese;
			echo  $this->Number->currency($uscite);
			$totuscite += $uscite;
		?>
		</td>		
		<?php
			//Devo  estrarre il totale delle note spese per questa fase e questa attività
			$avanzo= - $uscite;			
			if ($avanzo >= 0) {
                        $cl = 'text-success';
            } else {
                        $cl = 'text-danger';
            }

			echo "<td class=\"$cl\"> ".$this->Number->currency($avanzo);			
			$totavanzo += $avanzo;
		?>
		</td>
	</tr>
</tbody>

<tfoot>
    <?php 
			if  ($totavanzo > 0)
			{
				$c = 'bg-success';
			}
			else
			{
				$c = 'bg-danger';
			}
    ?>
	<tr class="bg-success">
		<td class="bg-success" width="30%">Totale</td>
		<td class="bg-success"><?php echo  $this->Number->currency($tot); ?></td>
		<td class="bg-success"> 
            
            <a href="<?php echo $this->Html->url(['controller'=>'fatturericevute', 'action'=>'index/attivita:' . $attivita['Attivita']['id']]) ?>">
                    <?php echo  $this->Number->currency($totspese); ?>
            </a>
        </td>   
		<td class="bg-success">
            <small>
            <a href="<?php echo $this->Html->url(['controller'=>'ore', 'action'=>'stats', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .","]]) ?>">
                <?php echo "$totnumore (" . $totnumore/8 ."gg)"; ?>
            </a>
            </small>
        </td>
		<td class="bg-success"></td>
		<td class="bg-success"><?php echo  $this->Number->currency($totcostoore); ?></td>
		<td class="bg-success">
            <a href="<?php echo $this->Html->url(['controller'=>'notaspese', 'action'=>'stats', '?'=>['as_values_attivita' => $attivita['Attivita']['id'] .","]]) ?>">
            <?php echo  $this->Number->currency($totnotaspese); ?>
            </a>
        </td>
		<td class="bg-success"><?php echo  $this->Number->currency($totuscite); ?></td>
		<td class="<?php echo $c ?>"><b><?php echo  $this->Number->currency($totavanzo); ?></b></td>
	</tr>
</tfoot>
</table>