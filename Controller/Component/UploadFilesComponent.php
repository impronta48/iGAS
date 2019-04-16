<?php

class UploadFilesComponent extends Component{

	public function _constructor(){
	}

	/**
	 * @return array maybe multidimensional containing as keys extensions and as 
	 * values related mime type(s)
	 */
	private function whitelistSetter(){
		return Configure::read('iGas.commonFiles');
	}

	/**
	 * like built in in_array() but multidimensional
	 *
	 * @param mixed $needle
	 * @param array $haystack
	 * @param boolean $strict
	 * @return string with extension related to found mime or false if nothing found
	 */
	private function in_array_multi($needle, $haystack, $strict = false){
		foreach($this->whitelistSetter() as $key => $item){
			if(in_array($needle,$item)){
				return $key;
			}
		}
		return false;
	}

	/**
	 * @return array list of allowed mime types
	 */
	private function getWlMimes(){
		$wlMimesArray = [];
		foreach($this->whitelistSetter() as $ext => $mimes){
			if(is_array($this->whitelistSetter()[$ext])){
				foreach($this->whitelistSetter()[$ext] as $mime){
					array_push($wlMimesArray,$mime);
				}
			}
		}
		return $wlMimesArray;
	}
	
	/**
	* @param int id (for now this is only used in generated file name)
	* @param uploaded_file file from a form that you want save in CakePHP standard file paths
	* @param string that contain folder in WWW_ROOT.'files/' that will contain saved file
	* @param string that is used as the file name postfix.
	* @return string empty if the upload was successful, return string countaining the error if 
	* the upload fail for some reasons.
	*/
	public function upload($id = null, $uploaded_file = null, $folder = null, $postfix = null){
		$errors = '';
		//debug($uploaded_file['type']);
		//debug($this->whitelistSetter());
		//debug($this->in_array_multi($uploaded_file['type'],$this->whitelistSetter()));
		//die();
		$fileExt = $this->in_array_multi($uploaded_file['type'],$this->whitelistSetter());
		if(!empty($uploaded_file['tmp_name'])) {
			if(!$fileExt){
				$errors = 'Formato file non valido, sono amessi solo PDF GIF JPEG PNG';
			} else { // Salvo il file 
				foreach($this->whitelistSetter() as $ext => $mime){
					if(file_exists(WWW_ROOT.'files'.DS.$folder.DS.$id.$postfix.'.'.$ext)){
						unlink(WWW_ROOT.'files'.DS.$folder.DS.$id.$postfix.'.'.$ext);
					}
				}
				if(!move_uploaded_file($uploaded_file['tmp_name'], WWW_ROOT.'files'.DS.$folder.DS.$id.$postfix.'.'.$fileExt)) {
					//Questo crea errore se messo in un Component, in un Controller nessun problema
					//$this->Flash->error(__('Errore salvataggio file. Riprovare'));
					$errors = 'Errore salvataggio file. Riprovare';
				} 
			}
		}
		return $errors;
	}

	/**
	 * @param string file path without extension (EG: /some/path/file)
	 * @return string empty if isn't found given file or file extension if given file is found
	 */
	public function checkIfFileExists($filePath){
		$fileExt='';
		//Qua non uso pathinfo() perchè fa scherzi con i file che hanno dei punti nel nome
		foreach($this->whitelistSetter() as $ext => $mime){
			if(file_exists($filePath.$ext)){
				$fileExt=$ext;
			}
		}
		return $fileExt;
	}

}

?>