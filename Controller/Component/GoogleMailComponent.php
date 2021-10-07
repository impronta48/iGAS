<?php

/**
 * 
 * Classe usata per le Google Gmail API.
 * 
 * Non contiene metodi per connettersi alle API.
 * 
 * @version 1.0.0
 * 
 */

class GoogleMailComponent extends Component{
	
	/**
	 * Send Message through GMAIL
	 *
	 * @param Google_Service_Gmail $service Authorized Gmail API instance.
	 * @param string $userId User's email address. The special value 'me'
	 * can be used to indicate the authenticated user.
	 * @return string that contain if message was sent or an error.
	 * @todo Rendere dinamici $msgSubject, $msgBody, il from, il to ed eventuali
	 * CC e CCN magari passando il tutto come parametri singoli o array.
	 * @version 1.0.0
	 */
	function sendMessage($googleService, $userId) {
		try {
			$msgSubject="Foglio ore caricato";
			$msgBody="Foglio ore caricato<br />Best Regards";
			$strRawMessage="From: Me <tc.web.consultant@gmail.com>\r\n";
			$strRawMessage.="To: tcWeb <tc.web.consultant@gmail.com>\r\n";
			//$strRawMessage.="CC: anotherUser <another@gmail.com>\r\n";
			$strRawMessage.="Subject: =?utf-8?B?" . base64_encode($msgSubject)."?=\r\n";
			$strRawMessage.="MIME-Version: 1.0\r\n";
			$strRawMessage.="Content-Type: text/html; charset=utf-8\r\n";
			$strRawMessage.="Content-Transfer-Encoding: base64"."\r\n\r\n";
			$strRawMessage.=$msgBody."\r\n";
			// The message needs to be encoded in Base64URL
			$mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
			$message = new Google_Service_Gmail_Message();
			$message->setRaw($mime);
			$message = $googleService->users_messages->send($userId, $message);
			//$this->Session->setFlash(__('Message with ID: '.$message->getId().' sent.'));
			return 'Message with ID: '.$message->getId().' sent.';
		} catch (Exception $e) {
			//$this->Session->setFlash(__('An error occurred: '.$e->getMessage()));
			return 'An error occurred: '.$e->getMessage();
		}
	}

}

?>