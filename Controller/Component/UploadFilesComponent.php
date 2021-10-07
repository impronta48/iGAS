<?php

class UploadFilesComponent extends Component{

	public function _constructor(){
	}

	/**
	 * @param array of string containing file extensions that must be removed from given whitelist
	 * @return array maybe multidimensional containing as keys extensions and as 
	 * values related mime type(s)
	 */
	private function whitelistSetter($blacklist = null){
		$wl = Configure::read('iGas.commonFiles');
		if($blacklist and (count($blacklist) >= 1)){
			foreach($blacklist as $ext){
				unset($wl[$ext]);
			}
		}
		return $wl;
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
		foreach($haystack as $key => $item){
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
	* @param boolean if true $folder it will be ignored and the file will be saved in WWW_ROOT.img/profiles/
	* @return string empty if the upload was successful, return string countaining the error if 
	* the upload fail for some reasons.
	*/
	public function upload($id = null, $uploaded_file = null, $folder = null, $postfix = null, $isAvatar = false){
		$errors = '';
		$tooBig = false;
		//debug($uploaded_file['type']);
		//debug($this->whitelistSetter());
		//debug($this->in_array_multi($uploaded_file['type'],$this->whitelistSetter()));
		//die();
		if($isAvatar){
			//Gli avatar non possono essere più grandi di 500 kb
			$maxSize = 500000;
			if(filesize(@$uploaded_file['tmp_name']) and filesize(@$uploaded_file['tmp_name']) > $maxSize){
				$tooBig = true;
			}
			$pathWithoutExt = WWW_ROOT.'img'.DS.'profiles'.DS.$id.$postfix;
			$extBl = ['pdf'];
		} else {
			$pathWithoutExt = WWW_ROOT.'files'.DS.$folder.DS.$id.$postfix;
			$extBl = [];
		}
		$fileExt = $this->in_array_multi($uploaded_file['type'],$this->whitelistSetter($extBl));
		if(!empty($uploaded_file['tmp_name'])) {
			if(!$fileExt){
				//$errors = 'Formato file non valido, sono amessi solo PDF GIF JPEG PNG';
				$errors = 'Formato file non valido, sono amessi solo '.strtoupper(implode(' ',array_keys($this->whitelistSetter($extBl))));
			} elseif($tooBig){
				$errors = 'File non salvato, il file non può essere più grande di '.((float)$maxSize/1000000).'MB';
			} else { // Salvo il file 
				foreach($this->whitelistSetter() as $ext => $mime){
					if(file_exists($pathWithoutExt.'.'.$ext)){
						unlink($pathWithoutExt.'.'.$ext);
					}
				}

				if(!move_uploaded_file($uploaded_file['tmp_name'], $pathWithoutExt.'.'.$fileExt)) {
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