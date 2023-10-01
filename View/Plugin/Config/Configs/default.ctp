<?php

	echo '<h1>Configurazione di Sistema</h1>';

	echo $this->Form->create('Config', ['url' => $this->here]);

	echo $this->Form->input('Config.Attivita.ferie', [
		'label' => __('Attività - ID Ferie', true), 'default' => 55]);

	echo $this->Form->input('Config.Attivita.malattia', [
		'label' => __('Attività - ID Malattia', true), 'default' => 56]);

	echo $this->Form->input('Config.Attivita.permessi', [
		'label' => __('Attività - ID Permessi', true), 'default' => '']);
	
	echo $this->Form->input('Config.iGas.bancaDefault', [
		'label' => __('ID Banca Default', true), 'default' => 8]);

		echo $this->Form->input('Config.iGas.idAzienda', [
		'label' => __('Default language', 8960)]);
	
	echo $this->Form->input('Config.iGas.NomeAzienda', [
		'label' => __('Nome Azienda', true), 'default' => '6']);
	
	echo $this->Form->input('Config.iGas.IvaDefault', [
		'label' => __('Iva Default', true)]);

	echo $this->Form->end(__('Save these settings', true));