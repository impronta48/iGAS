<?php echo $this->element('secondary_attivita',  ['aid'=>$this->request->params['pass'][0]]); ?>
<div class="fattureemesse form">
<?php echo $this->Form->create('Fatturaemessa');?>
	<fieldset>
		<legend>Aggiungi una fattura</legend>
	<?php
		echo $this->Form->input('attivita_id', ['disabled'=>true,'selected'=>$this->request->params['pass'][0]]);
        //TODO: Aggiungi la possibilità di sbloccare l'attività (per editing)
        echo '<fieldset class="progressivo"><legend>Progressivo</legend>';
    	echo $this->Form->input('Progressivo', ['default'=>$progressivoLibero, 'div'=>'false']);
		echo $this->Form->input('AnnoFatturazione', ['default'=> date('Y'), 'div'=>'false']);
        echo '</fieldset>';
		echo $this->Form->input('Serie', ['options'=>$serieOptions, 'label'=>'Serie']);
		echo $this->Form->input('data', ['dateFormat' => 'DMY']);
		echo $this->Form->input('Motivazione');
		echo $this->Form->input('CondPagamento');
		echo $this->Form->input('provenienzasoldi_id');
		echo $this->Form->input('ScadPagamento');
		echo $this->Form->input('AnticipoFatture');
		echo $this->Form->input('FineMese');
		echo $this->Form->input('Competenza');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
   
</div>
