	<?php echo $this->Html->script('jquery-1.10.2.min.js',false);?>		
	<?php echo $this->Html->script('tariffa.js',false); ?>
	<?php echo $this->Html->script('trasferte.js',false);?>				
	<?php echo $this->Html->css('add-trasf-generico'); ?>

	<h1>Modulo per gestione delle trasferte</h1>
	<?php echo $this->Form->create('Trasferta', array('action'=>'add')) ?>
	<?php echo $this->Form->input('trasferta_id', array('type'=>'hidden')) ?>
	<label for="TrasfertaPartenza">Origine Trasferta <input type="textbox" width="30" value="Asti" name="data[Trasferta][partenza]"  id="TrasfertaPartenza" />
	<br/><small>Es: Torino o Villanova AT</small>
	</label>
	<label for="TrasfertaDestinazione">Destinazione Trasferta <input type="textbox" width="30" value="" name="data[Trasferta][destinazione]"  id="TrasfertaDestinazione" />
	<br/><small>Es: Milano o Novello CN</small>
	</label>
	<a href="javascript:calcolaPercorso();"> <?php echo $this->Html->image('refresh_48.png'); ?> Scegli il Mezzo</a>, e visualizza i Costi le Emissioni e i Punti che guadagni
	<div id="area-calcoli">
	<div id="maps">
		<div id="map" class="map"></div>
	</div>
	
	<div id="container">
	<h1>Scegli il mezzo che intendi usare</h1>
	<em>In questa sezione devi fare click sul mezzo che intenti usare (i calcoli economici e di emissioni
		potrebbero aiutarti nella scelta), e poi <b>scegliere CONFERMA per generare il modulo di trasferta</b>.</em>
	<label for="data[mezzo]">
	<?php echo $this->Form->hidden('veicolo'); ?>
	<?php echo $this->Form->hidden('punti'); ?>
	<?php echo $this->Form->hidden('co2'); ?>
	<?php echo $this->Form->hidden('costo'); ?>
	<?php echo $this->Form->hidden('distanza'); ?>
	</label>
	
	<TABLE>
		<tr class="riga-distanza">
			<th class="riga-distanza">
				DISTANZA
			</th>
			<td class="riga-distanza" id="id-distanza" colspan="3">
			</td>
		</tr>
		<TR>
			<td>&nbsp;</td>
			<TD><a href="javascript:sceltoMezzo('auto');"><?php echo $this->Html->image('auto.gif') ?></a></TD>
			<TD><a href="javascript:sceltoMezzo('treno');"><?php echo $this->Html->image('treno.gif') ?></a></TD>
			<TD><a href="javascript:sceltoMezzo('aereo');"><?php echo $this->Html->image('aereo.gif') ?></a></TD>
		</TR>
		<TR class="riga-emissioni">
			<Th class="riga-emissioni">Emissioni di CO2</Th>
			<td class="riga-emissioni" id="emissioni-auto"></td>
			<td class="riga-emissioni" id="emissioni-treno"></td>
			<td class="riga-emissioni" id="emissioni-aereo"></td>
		</TR>
		<TR class="riga-costi">
			<Th class="riga-costi">Costo</Th>
			<td id="costo-auto" class="riga-costi"></td>
			<td id="costo-treno" class="riga-costi"></td>
			<td id="costo-aereo" class="riga-costi">Non disponibile</td>
		</TR>
		<TR class="riga-punti">
			<Th class="riga-punti"><?php echo $this->Html->image('add_16.png') ?> Punti</Th>
			<td id="punti-auto" class="riga-punti">0</td>
			<td id="punti-treno" class="riga-punti"></td>
			<td id="punti-aereo" class="riga-punti">0</td>
		</TR>
	</TABLE>
	</div>
	
	<div id="area-conferma">
			Hai Scelto il mezzo
			<div id="area-mezzo"></div>
			ti verranno accreditati <div id="area-punti"></div> punti
			<button type="submit">Conferma</button>
	</div>
	
	</div>
	<?php echo $this->Form->end() ?>

