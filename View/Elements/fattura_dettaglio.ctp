<?php echo $this->Html->script('fattura-righe-custom',['inline' => false]); ?>

<?php 
	if (empty($righe))
	{
		$righe = [];
	}
	
	//build up select options with additional info about VAT percentage
	foreach($codiciiva as $c) {
		$codiciiva_options[$c['LegendaCodiciIva']['id']] = [
			'name' => $c['LegendaCodiciIva']['Descrizione'],
			'value' => $c['LegendaCodiciIva']['id'],
			'percentuale' => $c['LegendaCodiciIva']['Percentuale']
		];
	}

	$field_id = $this->Form->input('id', ['type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'id-field', 'value' => '']);
    //Todo: Togliere field_fattura_id
	$field_fattura_id = '';//$this->Form->input('fattura_id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'fattura_id-field', 'value' => $fattura_id));
	$field_ordine = $this->Form->input('Ordine', ['label' => false, 'div' => false, 'class' => 'ordine-field']);
	$field_descr = $this->Form->input('DescrizioneVoci', ['label' => false, 'div' => false, 'class' => 'descr-field']);	
	$field_importo = $this->Form->input('Importo', ['label' => false, 'div' => false, 'class' => 'importo-field euro']);
	$field_codiceiva = $this->Form->input('codiceiva_id', ['default'=> Configure::read('iGas.IvaDefault'), 'options' => $codiciiva_options, 'label' => false, 'div' => false, 'class' => 'codiceiva-field selectBox', 'showParents' => false]);
   	
	$field_codiceiva = preg_replace( "/\r|\n/", "", $field_codiceiva );
?>	

<?php $this->Html->scriptStart(['inline' => false]); ?>

	function getRigaFatturaRow() {
		return  [
			'<?php echo $field_id.$field_fattura_id;?>',
			'<?php echo $field_ordine;?>',
			'<?php echo $field_descr;?>',
			'<?php echo $field_importo;?>',
			'<?php echo $field_codiceiva;?>',
			'<a href="#" class="datatables-row-delete btn btn-primary btn-xs">Elimina</a>'
		];
	}

	ajaxDeleteURL = "<?php echo $this->Html->url(['controller' => 'Righefatture', 'action' => 'delete']);?>";
    
<?php $this->Html->scriptEnd(); ?>

<fieldset>
<legend>Dettaglio Fattura</legend>
<div class="actions">
<a class="datatables-create btn btn-animate-demo btn-primary btn-sm" href="#"><i class="fa fa-plus-circle"></i> Aggiungi riga fattura</a>
</div>

<div class="row">
<div class="col-md-11 table-responsive">
<table class="dataTable table table-bordered table-hover table-striped display" id="fattura-righe" >
    <thead>
        <tr>
			<th class="invisible"></th>
			<th class="col-ordine">Ordine</th>
            <th class="col-descr">Descrizione</th>
          	<th class="col-importo euro">Importo</th>
          	<th class="col-codiceiva">Codice Iva</th>
          	<th class="col-azioni">Azioni</th>
        </tr>
    </thead>

	<tbody>
		<?php $counter = 0;?>		
		<?php foreach ($righe as $r):?>
        <tr>   
			<td class="invisible"><?php 
				echo $this->Form->input("Rigafattura.$counter.id", ['type' => 'hidden', 'label' => false, 'div' => false, 'value' => $r['id'], 'class' => 'id-field']);	
				//echo $this->Form->input("Rigafattura.$counter.fattura_id", array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'fattura_id-field', 'value' => $fattura_id));           	
			?></td> 		
			<td><?php 
				echo $this->Form->input("Rigafattura.$counter.Ordine", ['label' => false, 'div' => false, 'value' => $r['Ordine'], 'class' => 'ordine-field']);	
           	?></td>        
        	<td><?php 
				echo $this->Form->input("Rigafattura.$counter.DescrizioneVoci", ['label' => false, 'div' => false, 'value' => $r['DescrizioneVoci'], 'class' => 'descr-field']);	
           	?></td>
           	<td><?php 
				echo $this->Form->input("Rigafattura.$counter.Importo", ['label' => false, 'div' => false, 'value' => CakeNumber::precision($r['Importo'], 2), 'class' => 'importo-field']);
				?>
			</td>
           	<td><?php
					$field_codiceiva = $this->Form->input("Rigafattura.$counter.codiceiva_id", ['default'=> $r['codiceiva_id'], 'options' => $codiciiva_options, 'label' => false, 'div' => false, 'class' => 'codiceiva-field']);
   					$field_codiceiva = preg_replace( "/\r|\n/", "", $field_codiceiva ); 
					echo $field_codiceiva;
				?>
			</td>
           	<td><a href="#" class="datatables-row-delete btn btn-primary btn-xs">Elimina</a></td>
			<?php $counter++;?>
      	</tr>
      	<?php endforeach; ?>
	</tbody>
</table>
</div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="info-box  bg-success text-white totale-fattura-outer-container">
            <div class="info-icon bg-success-dark">
                <i class="fa fa-keyboard-o fa-4x"></i>
            </div>
            <div class="info-details">
                <div class="invoice-total fattura-imponibile">
                    <h4>Imponibile
                    <span class="value pull-right"></span>
                    </h4>
                </div>

                <p class="invoice-total fattura-totale">
                    Totale
                    <span class="pull-right value"></span>
                </p>
            </div>

        </div>
    </div>
</div>

</fieldset>


