<?php

/**
 * 
 * Questa classe contiene metodi utili per usare le API di Google Drive.
 * 
 * Non contiene metodi per connettersi alle API, quelli per adesso sono 
 * presenti nei controller, ad esempio su NotaspeseController.php. 
 * In futuro, per astrarre e migliorare il tutto si potrebbe creare il 
 * component per connettersi alle API di Google prendendo spunto dalle 
 * funzioni presenti in NotaspeseController.php
 * 
 * @version 1.0.3
 * 
 */
class GoogleDriveComponent extends Component{
	
	public const DEBUG = false; // false = no Debug, true = Debug active 
	public const DEBUGFILE = APP.'googleDebug.log';

	function echoCurrentUrl(){
		return Router::url(null, true);
	}
	
	public function getController(Controller $controller) {
		$this->Controller = $controller;
	}

	/**
	 * Google Directory Tree Generator
	 * @param Google_Service_Drive $service Authorized Drive API instance.
	 * @param array that contain as first argument the parent Drive folder ID and other subdir names.
	 * @return mixed string with the last created child folder ID or false in case of errors.
	 * @version 1.0.0
	 */
	function dirTreeGen($googleService,$folderParams){
		$parentFolderId=$folderParams[0];
		$driveDestFolder=null;
		for($i=1;$i<count($folderParams);$i++){
			$fileList = [];
			$fileList = $this->checkIfIsInDrive($googleService,$folderParams[$i],$parentFolderId);
			if(count($fileList)<=0){
				$fileMetadata = new Google_Service_Drive_DriveFile([
					'parents' => [$parentFolderId],
					'name' => $folderParams[$i],
					'mimeType' => 'application/vnd.google-apps.folder']);
				$driveDestFolder = $googleService->files->create($fileMetadata, [
					'fields' => 'id']);
				$parentFolderId=$driveDestFolder->id;
			} else {
				$parentFolderId=$fileList[0]->id;
			}
			//debug($parentFolderId);debug($fileList);
		}
		return $parentFolderId;
	}

	/**
	 * Google Drive Duplicates
	 * 
	 * @param Google_Service_Drive $googleService Authorized Drive API instance.
	 * @param string containing the file or directory name that must be checked
	 * @param string containing the Drive folder ID in witch should be checked the presence of given file or dir
	 * @return array empty if there aren't already uploaded files or an array containing Drive objects.
	 * @version 1.0.0
	 */
	function checkIfIsInDrive($googleService,$entityName,$parentFolder=null){
		$fileList = [];
		$pageToken = null;
		do{
			try{
				$parameters = [];
				if($pageToken){
					$parameters['pageToken'] = $pageToken;
				}
				$parameters['q'] = [
								"name = '$entityName'",
								"trashed = false",
								//"mimeType = 'application/vnd.google-apps.folder'",
								"'$parentFolder' in parents"];
				$files = $googleService->files->listFiles($parameters);
				//debug($files->files);
				//$file = $googleService->files->get($files[0]->id, array('fields' => 'parents'));
				//debug($file->parents);
				//$previousParents = join(',', $file->parents);
				$fileList = array_merge($fileList, $files->files);
				$pageToken = $files->getNextPageToken();
			} catch(Exception $e){
				print "An error occurred: " . $e->getMessage();
				$pageToken = null;
			}
		}while($pageToken);
		return $fileList;
	}
	
	/**
	 * Google Drive Upload
	 *
	 * @param Google_Service_Drive $googleService Authorized Drive API instance.
	 * @param string that contain the local server path of the file that you want upload.
	 * @param array that contain the Drive folder ID in witch should be saved the file and other dir names for create Drive subfolders.
	 * @return string that contain if file was successfully uploaded or an error, if the file is successfully uploaded it will
	 * be returned the Google Drive file id
	 * @version 1.0.1
	 */
	function upload($googleService,$fileToUpload,$folderParams=null){
		$folderId=$this->dirTreeGen($googleService,$folderParams);
		//debug($folderId);//DEBUG
		$fileName=explode('.',basename($fileToUpload));	
		//Controllo se ci sono file analoghi già caricati
		$fileList=$this->checkIfIsInDrive($googleService,Router::getRequest(true)->param('controller').$fileName[0],$folderId);
		//Se non è già stato caricato un file analogo procedo con il download
		if(count($fileList)<=0){
			try {
				//Upload con metadata ed usando multipart (così invio metadata e file contemporaneamente)
				//$file = new Google_Service_Drive_DriveFile();
				$file = new Google_Service_Drive_DriveFile([
					'title' => basename($fileToUpload),
					'parents' => [$folderId]
				]);

				$file->setName(Router::getRequest(true)->param('controller').$fileName[0]);
				$file->setDescription(Router::getRequest(true)->param('controller').' - '.basename($fileToUpload));
				$result = $googleService->files->create(
					$file,[
						'data' => file_get_contents($fileToUpload),
						'mimeType' => mime_content_type($fileToUpload),
						'uploadType' => 'multipart',
						'fields' => 'id'
						]
				);
				//debug($result);
				//return 'File caricato con successo, l\'id del file su Google Drive è '.$result->id;
				return $result->id;
			}
			catch (Exception $e) {
				//$this->Session->setFlash(__('An error occurred: '.$e->getMessage()));
				return 'An error occurred: '.$e->getMessage();
			}
		}else{
			return 'Su Google Drive è già presente uno scontrino correllato alla fattura '.$fileName[0];
		}
	}

	/**
	 * Google Drive Delete
	 * 
	 * @param Google_Service_Drive $googleService Authorized Drive API instance.
	 * @param integer the LOCAL file id, not the DRIVE file id.
	 * @return string containing success or error message. The success message should be start with SUCCESS string
	 * @version 1.0.1
	 */
	function deleteFile($googleService,$scontrinoIdToDelete){
		$fileList = [];
		$fileList=$this->checkIfIsInDrive($googleService,Router::getRequest(true)->param('controller').$scontrinoIdToDelete);
		if(count($fileList)<=0){
			return 'No file to erase from Google Drive';
		}
		try {
			$googleService->files->delete($fileList[0]['id']);
			return 'SUCCESS: File erased from Google Drive';
		} catch (Exception $e) {
			return "An error occurred when deleting the file on Google Drive: " . $e->getMessage();
		}
	}
}

?>