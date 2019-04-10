<?php

class UploadFilesComponent extends Component{

	/*
	Take as first parameter an int id (for now this is only used in generated file name)
	Take as second argument an uploaded file from a form and save it in CakePHP standard file paths
	The third argument is the folder in WWW_ROOT.'files/' that will contain saved file
	The fourth argument is a postfix string of the file name.
	Return an empty string if the upload was successful, return a string countaining the error if 
	the upload fail for some reasons.
	*/
	public function upload($id = null, $uploaded_file = null, $folder = null, $postfix = null){
		$errors = '';
		if(!empty($uploaded_file['tmp_name'])) {
			if ($uploaded_file['type'] != 'application/pdf') {
				//Questo crea errore se messo in un Component, in un Controller nessun problema
				//$this->Flash->error(__('Formato file non valido, sono amessi solo PDF'));
				$errors = 'Formato file non valido, sono amessi solo PDF';
			} else { // Salvo il file 
				if(!move_uploaded_file($uploaded_file['tmp_name'], WWW_ROOT.'files/'.$folder.'/'.$id.$postfix.'.pdf')) {
					//Questo crea errore se messo in un Component, in un Controller nessun problema
					//$this->Flash->error(__('Errore salvataggio file. Riprovare'));
					$errors = 'Errore salvataggio file. Riprovare';
				} 
			}
		}
		return $errors;
	}

}

?>