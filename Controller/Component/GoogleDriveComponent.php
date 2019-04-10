<?php

class GoogleDriveComponent extends Component{
	
	function echoCurrentUrl(){
		return Router::url(null, true);
	}
	
	public function getController(Controller $controller) {
		$this->Controller = $controller;
	}
	
	/**
	 * Google Drive Upload
	 *
	 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
	 * @param  string that contain the local server path of the file that you want upload.
	 * @param  string that contain the Drive folder ID in whitch should be saved the file.
	 * @return string that contain if message was sent or an error.
	 */
	function upload($googleService,$fileToUpload,$folderId=null){
		//Controllo se ci sono file analoghi già caricati
		$fileName=explode('.',basename($fileToUpload));	
		$fileList = Array();
		$pageToken = null;
		do{
			try{
				$parameters = array();
				if($pageToken){
					$parameters['pageToken'] = $pageToken;
				}
				$parameters['q'] = array(
								'name = \''.$fileName[0].'\'',
								'trashed = false',
								'\'.$folderId.\' in parents');
				$files = $googleService->files->listFiles($parameters);
				$fileList = array_merge($fileList, $files->files);
				$pageToken = $files->getNextPageToken();
			} catch(Exception $e){
				print "An error occurred: " . $e->getMessage();
				$pageToken = null;
			}
		}while($pageToken);
		//Se non è già stato caricato un file analogo procedo con il download
		if(count($fileList)<=0){
			try {
				//Upload con metadata ed usando multipart (così invio metadata e file contemporaneamente)
				//$file = new Google_Service_Drive_DriveFile();
				$file = new Google_Service_Drive_DriveFile(array(
					'title' => basename($fileToUpload),
					'parents' => array($folderId)
				));

				$file->setName($fileName[0]);
				$file->setDescription(Router::getRequest(true)->param('controller').' - '.basename($fileToUpload));
				$result = $googleService->files->create(
					$file,array(
						'data' => file_get_contents($fileToUpload),
						'mimeType' => mime_content_type($fileToUpload),
						'uploadType' => 'multipart',
						'fields' => 'id'
						)
				);
				//debug($result);
				return 'File caricato con successo, l\'id del file su Google Drive è '.$result->id;
			}
			catch (Exception $e) {
				//$this->Session->setFlash(__('An error occurred: '.$e->getMessage()));
				return 'An error occurred: '.$e->getMessage();
			}
		}else{
			return 'Su Google Drive è già presente uno scontrino correllato alla fattura '.$fileName[0];
		}
	}
	
}

?>