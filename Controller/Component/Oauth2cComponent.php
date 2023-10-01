<?php
App::uses('AuthComponent', 'Controller/Component');
App::import('Core', ['HttpSocket','Component','Auth']);

class Oauth2cComponent extends AuthComponent {
    
    var $name = 'Oauth2c';
    var $components = ['Session'];
    var	$app_id = "308294376915";
    var	$app_secret = "37febc9862f78faf7c9cd1ef44df8438";
    var $my_url = "http://localhost/igas/oauth2/fblogin/";
    var $access_token = '';
    
    
    function initialize(Controller $controller) {
                // saving the controller reference for later use
                //$this->controller =& $controller;
                parent::initialize($controller);
    } 
        
    function fbLogin()
    {
        $code = $this->Session->read('code');

        if(empty($code)) {
        $this->Session->write('state', md5(uniqid(rand(), TRUE))); //CSRF protection
                    $dialog_url = "https://www.facebook.com/dialog/oauth?scope=email&client_id=" 
                            . $this->app_id . "&redirect_uri=" . urlencode($this->my_url) . "&state="
                            . $this->Session->read('state');

                    $this->controller->redirect($dialog_url);
        }
		           
        $token_url = "https://graph.facebook.com/oauth/access_token";                
            $params = [
                "client_id" => $this->app_id,
                "redirect_uri" => $this->my_url, 
                "client_secret" => $this->app_secret,
                "code" => $code,
            ];

        $HttpSocket = new HttpSocket();            
        $results = $HttpSocket->get($token_url,  http_build_query($params));
        parse_str($results, $params);

        $this->access_token =  $params['access_token'];

        $graph_url = "https://graph.facebook.com/me"; 
        $params = [
            "client_id" => $this->app_id,
            "redirect_uri" => $this->my_url, 
            "client_secret" => $this->app_secret,
            "fields" => 'id,username,email',
            "access_token" => $this->access_token,
        ];
        $results = $HttpSocket->get($graph_url,  http_build_query($params));
        $user= json_decode($results);
        $this->set('u', $user->email);	
    }
		
	function googleLogin()
	{
	        
        $code = $_REQUEST["code"];

		if(empty($code)) {
            $url = "https://accounts.google.com/o/oauth2/auth";
 
            $params = [
            "response_type" => "code",
            "client_id" => "345130892466.apps.googleusercontent.com",
            "redirect_uri" => "http://localhost/igas/oauth2/googlelogin/",
            "scope" => "https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/userinfo.email",
            ];

            $request_to = $url . '?' . http_build_query($params);
            $this->redirect($request_to);
		}
		else {
            //Raccolgo il token
            $url = 'https://accounts.google.com/o/oauth2/token';
            $params = [
                "code" => $code,
                "client_id" => "345130892466.apps.googleusercontent.com",
                "client_secret" => "7d15_xLUy-MvXdDC3x8zD7rZ",
                "redirect_uri" => "http://localhost/igas/oauth2/googlelogin/",
                "grant_type" => "authorization_code",
                
            ];

            $HttpSocket = new HttpSocket();
            $results = $HttpSocket->post($url, $params);
            $responseObj = json_decode($results);

            if (isset($responseObj->error))
            {
                //TODO: Non Autenticato
                return;
            }
            
            //Raccolgo la mail
            $url = 'https://www.googleapis.com/oauth2/v1/userinfo?';
            $params = [ 'access_token' => $responseObj->access_token ];
            $HttpSocket = new HttpSocket();
            $results = $HttpSocket->get($url,  http_build_query($params));
            $responseObj = json_decode($results);        
            $this->set('u', $responseObj->email);
            
            //TODO: Generalizzare
            //Controllo se la mail è nella lista delle mail degli utenti, se sì lo considero autenticato
            if ($responseObj->email == 'massimoi@gmail.com') 
            {
               $this->login();
            }
		}
	}
    
    function login($user = null) {
		$this->__setDefaults();
		$this->_loggedIn = false;

        $user = ['id' => 1, 'username'=> 'massimoi@nkoni.org'];
		$this->Session->write($this->sessionKey, $user);
		$this->_loggedIn = true;
		
		return $this->_loggedIn;
	}

	// Aggiunto per poter fare il logout di utenti non administrators
	function beforeFilter() 
	{
		 parent::beforeFilter(); 
		 $this->Auth->allow();
	}

}
