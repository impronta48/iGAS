<?php
class Notaspesa extends AppModel
{
	public $name = 'Notaspesa';
	public $displayField = 'ID';
	public $actsAs = ['Containable'];

	public $uploadPattern = WWW_ROOT . "files/notaspese/:persona/:anno/:mese/";

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = [
		'Persona' => [
			'className' => 'Persona',
			'foreignKey' => 'eRisorsa',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'Attivita' => [
			'className' => 'Attivita',
			'foreignKey' => 'eAttivita',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'LegendaCatSpesa' => [
			'className' => 'LegendaCatSpesa',
			'foreignKey' => 'eCatSpesa',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'LegendaMezzi' => [
			'className' => 'LegendaMezzi',
			'foreignKey' => 'legenda_mezzi_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'Provenienzasoldi' => [
			'className' => 'Provenienzasoldi',
			'foreignKey' => 'provenienzasoldi_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'Faseattivita'
	];
	public function getPersone()
	{
		$persone = Cache::read('persone_list', 'short');
		if (!$persone) {
			$persone = $this->find('list', [
				'fields' => ['Persona.id', 'Persona.DisplayName'],
				'contain' => ['Persona'],
				'order' => 'Persona.DisplayName'
			]);
			Cache::write('persone_list', $persone, 'short');
		}

		return $persone;
	}

	public function upload($id, $file, $persona, $anno, $mese)
	{
		//Upload del file allegato (se c'è) - uploadFi, $persona, $anno, $mesele
		// Get the uploaded file data
		$maxUploadSize = ini_get('upload_max_filesize');

		if ($file['error'] != 0) {
			return false;
		}

		// Create a unique file name
		$fileName = $id . '_' . $file['name'];
		$uploadPath = CakeText::insert($this->uploadPattern, ['persona' => $persona, 'anno' => $anno, 'mese' => $mese]);

		// Full path to upload folder
		$uploadDir = new Folder($uploadPath, true, 0755);

		// Check if the file was uploaded successfully
		if (move_uploaded_file($file['tmp_name'], $uploadPath . DS . $fileName)) {
			return true;
		} else {
			return false;
		}
	}

	public function getAttachments($id, $persona, $mese, $anno)
	{
			//Search for all files in the folder $uploadPattern
			$uploadPath = CakeText::insert($this->uploadPattern, ['persona' => $persona, 'anno' => $anno, 'mese' => $mese]);
			$files = glob("$uploadPath{$id}_*");
			$results = [];

			//Add files in forlder $uploadPattern to results
			foreach ($files as $f) {
				$l = str_replace(WWW_ROOT, '', $f);
				$results[] = $l;
			}
		return $results;
	}
}
