<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $aliases = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'attivita_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $aree = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $aros = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $aros_acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'aro_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'aco_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'_create' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'_read' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'_update' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'_delete' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $attivita = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'progetto_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'cliente_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'DataPresentazione' => array('type' => 'date', 'null' => true, 'default' => null),
		'DataApprovazione' => array('type' => 'date', 'null' => true, 'default' => null),
		'DataInizio' => array('type' => 'date', 'null' => true, 'default' => null),
		'DataFine' => array('type' => 'date', 'null' => true, 'default' => null),
		'DataFinePrevista' => array('type' => 'date', 'null' => true, 'default' => null),
		'NumOre' => array('type' => 'float', 'null' => true, 'default' => null),
		'NumOreConsuntivo' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'OffertaAlCliente' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,2'),
		'ImportoAcquisito' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,2'),
		'NettoOra' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,2'),
		'OreUfficio' => array('type' => 'integer', 'null' => true, 'default' => null),
		'MotivazioneRit' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Utile' => array('type' => 'float', 'null' => true, 'default' => null),
		'Note' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'area_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'azienda_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'chiusa' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'alias' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'NomeAttivitā' => array('column' => 'name', 'unique' => 1),
			'AziendeAttivitā' => array('column' => 'azienda_id', 'unique' => 0),
			'NumOreConsuntivo' => array('column' => 'NumOreConsuntivo', 'unique' => 0),
			'ProgettoAttivitā' => array('column' => 'progetto_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $aziende = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Indirizzo' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PathLogo' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PathLogoReport' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDAzienda' => array('column' => 'id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $citta = array(
		'IDCitta' => array('type' => 'integer', 'null' => false, 'default' => null),
		'Citta' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Provincia' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CAP' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $clienti = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'TipoCliente' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'EntePubblico' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'AltraSede' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Citta1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Provincia1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CAP1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'NumeroTelefono1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'NumeroFax1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PartitaIVA' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'persona_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $costiattivita = array(
		'IDCostoAttivita' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'eAttivita' => array('type' => 'integer', 'null' => true, 'default' => null),
		'Descrizione' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Preventivo' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'IDCS' => array('type' => 'integer', 'null' => true, 'default' => null),
		'Importo' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDCostoAttivita', 'unique' => 1),
			'idCostoAttivitā' => array('column' => 'IDCostoAttivita', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $fattureemesse = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'attivita_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'Progressivo' => array('type' => 'integer', 'null' => false, 'default' => null),
		'AnnoFatturazione' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'Motivazione' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'provenienzasoldi_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'ScadPagamento' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'data' => array('type' => 'date', 'null' => true, 'default' => null),
		'AnticipoFatture' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'CondPagamento' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'FineMese' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'Competenza' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $fatturepreviste = array(
		'IDFatturaPrevista' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'eAttivita' => array('type' => 'integer', 'null' => true, 'default' => null),
		'Motivazione' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Provenienza' => array('type' => 'integer', 'null' => true, 'default' => null),
		'ScadPagamento' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'Importo' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'data' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Soddisfatto' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDFatturaPrevista', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $fatturericevute = array(
		'IDFatturaRicevuta' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'eAttivita' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'Progressivo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'AnnoFatturazione' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'Motivazione' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Provenienza' => array('type' => 'integer', 'null' => true, 'default' => null),
		'ScadPagamento' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'Importo' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'data' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'eFornitore' => array('type' => 'integer', 'null' => true, 'default' => null),
		'TipoSpesa' => array('type' => 'integer', 'null' => true, 'default' => null),
		'Imponibile' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'IVA' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'FuoriIva' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDFatturaRicevuta', 'unique' => 1),
			'AttivitāFattureRicevute' => array('column' => 'eAttivita', 'unique' => 0),
			'IDFatturaRicevuta' => array('column' => 'IDFatturaRicevuta', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $fornitori = array(
		'IDPersona' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'TipoFornitura' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'PartitaIVA_CF' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'NomeBanca' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'NumConto' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CoordBancarie' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'AltraSede' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Citta1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Provincia1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CAP1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'NumeroTelefono1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'NumeroFax1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDPersona', 'unique' => 1),
			'IDPersona' => array('column' => 'IDPersona', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $impiegati = array(
		'persona_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'TipoImpiegato' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'NumeroAssistenzaSociale' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'NumeroLibrettoDiLavoro' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'DataAssunzione' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Stipendio' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'LuogoDiNascita' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CodiceFiscale' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'username' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CostoAziendale' => array('type' => 'float', 'null' => true, 'default' => null),
		'Venduto' => array('type' => 'float', 'null' => true, 'default' => null),
		'Disattivo' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'DataModifica' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'ModificatoDa' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'persona_id', 'unique' => 1),
			'Reference6' => array('column' => 'TipoImpiegato', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $impiegati_attivita = array(
		'Data' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Forfait' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'IDLavoro' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'IDImpiegato' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'IDAttivita' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'NumOre' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'Compenso' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDLavoro', 'unique' => 1),
			'Reference1' => array('column' => 'IDImpiegato', 'unique' => 0),
			'Reference2' => array('column' => 'IDAttivita', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $legenda_cat_spesa = array(
		'IdCS' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'NomeCS' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IdCS', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $legenda_codici_iva = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary'),
		'Percentuale' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'Descrizione' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $legenda_condizioni_pagamento = array(
		'idCP' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Descr' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'idCP', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $legenda_tipi_clienti = array(
		'IDTipoCliente' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'TXTipoCliente' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDTipoCliente', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $legenda_tipi_forniture = array(
		'IDTipoFornitura' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'TXTipoFornitura' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDTipoFornitura', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $legenda_tipi_impiegati = array(
		'TipoImpiegato' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'IDTipoImpiegato' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDTipoImpiegato', 'unique' => 1),
			'IDTipoImpiegato' => array('column' => 'IDTipoImpiegato', 'unique' => 1),
			'TipoImpiegato' => array('column' => 'TipoImpiegato', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $legenda_tipi_persone = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'NomeTipologia' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $legenda_tipi_scadenze = array(
		'IDScadenza' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Descrizione' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDScadenza', 'unique' => 1),
			'idScadenza' => array('column' => 'IDScadenza', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $notaspese = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'eAttivita' => array('type' => 'integer', 'null' => false, 'default' => null),
		'eRisorsa' => array('type' => 'integer', 'null' => false, 'default' => null),
		'data' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'eCatSpesa' => array('type' => 'integer', 'null' => false, 'default' => null),
		'daRimborsare' => array('type' => 'integer', 'null' => false, 'default' => null),
		'importo' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'fatturabile' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'rimborsabile' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $oauth2s = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $ore = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'eRisorsa' => array('type' => 'integer', 'null' => false, 'default' => null),
		'eAttivita' => array('type' => 'integer', 'null' => false, 'default' => null),
		'data' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'numGiornate' => array('type' => 'float', 'null' => true, 'default' => null),
		'dettagliAttivita' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'LuogoTrasferta' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Trasferta' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'Pernottamento' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'statoApprovazione' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $partecipanti = array(
		'IDPartecipante' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'IDAttivita' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'IDPersona' => array('type' => 'integer', 'null' => true, 'default' => null),
		'Quota' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'Pagato' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDPartecipante', 'unique' => 1),
			'IDAttivitā' => array('column' => 'IDAttivita', 'unique' => 0),
			'Reference12' => array('column' => 'IDAttivita', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $persone = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Nome' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Cognome' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 75, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Indirizzo' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Citta' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Provincia' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Nazione' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CAP' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'TelefonoDomicilio' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'TelefonoUfficio' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'DataDiNascita' => array('type' => 'date', 'null' => true, 'default' => null),
		'UltimoContatto' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Nota' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Titolo' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Carica' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Societa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'SitoWeb' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ModificatoDa' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'EMail' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Fax' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Cellulare' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'IM' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Categorie' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'DisplayName' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'piva' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cf' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'iban' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'NomeBanca' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'altroIndirizzo' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'altraCitta' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'altroCap' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'altraProv' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'altraNazione' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'EntePubblico' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'Cognome' => array('column' => 'Cognome', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $persone_extra = array(
		'IDPersona' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Nome' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Cognome' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 75, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Indirizzo' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'IDCitta' => array('type' => 'integer', 'null' => true, 'default' => null),
		'CAP' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'TelefonoDomicilio' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'TelefonoUfficio' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'DataDiNascita' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Tipologia' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'UltimoContatto' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Nota' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDPersona', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $primanota = array(
		'IDNota' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Data' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Descr' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Importo' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'eAttivita' => array('type' => 'integer', 'null' => true, 'default' => null),
		'eCatSpesa' => array('type' => 'integer', 'null' => true, 'default' => null),
		'eProvenienza' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'eFattura' => array('type' => 'integer', 'null' => true, 'default' => null),
		'TipoFattura' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Assegno' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDNota', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $progetti = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'DescrizioneProgetto' => array('type' => 'binary', 'null' => true, 'default' => null),
		'area_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'PercentualeIVA' => array('type' => 'float', 'null' => true, 'default' => null),
		'Nota' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'Aree_ProgettiProgetto' => array('column' => 'area_id', 'unique' => 0),
			'NomeProgetto' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $provenienzesoldi = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary'),
		'azienda_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'ModoPagamento' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $righefatture = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'fattura_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'DescrizioneVoci' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Ordine' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'Importo' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '19,4'),
		'codiceiva_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $scadenze = array(
		'IDScadenza' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'eAttivita' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'IDTipoScadenza' => array('type' => 'integer', 'null' => true, 'default' => null),
		'data' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'descrizione' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'percCompletamento' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'Soddisfatto' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'IDScadenza', 'unique' => 1),
			'AttivitāScadenze' => array('column' => 'eAttivita', 'unique' => 0),
			'IDScadenza' => array('column' => 'IDScadenza', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'azienda_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'username' => array('column' => 'username', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

}
