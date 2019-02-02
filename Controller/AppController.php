<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {    
	public $helpers = array(
        'Session',
		'Time',
		'Js',    
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'Tools.Common', 
    );
	
     
	public $components = array(
            'Session',
            'RequestHandler',
            'Flash', 
            'Tools.Common',
            'Auth',
            'Cookie',
        );  

    //public $uses = array('User');

    /**
     * AppController::constructClasses()
     *
     * @return void
     */
    public function constructClasses() {
        if (CakePlugin::loaded('DebugKit') && Configure::read('debug')) {
            $this->components[] = 'DebugKit.Toolbar';
        }

        parent::constructClasses();
    }

    function beforeFilter() {
              
        //Configure AuthComponent
        //$this->theme = Configure::read('iGas.theme'); 
        $this->Auth->allow(); //Permetto tutto
        //permetto il verbno display sulle pagine statiche
        //$this->Auth->allow('display');
    
         // set cookie options
        //$this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
        //$this->Cookie->httpOnly = true;

/*         if (!$this->Auth->loggedIn() && $this->Cookie->read('remember_me_cookie')) {
            $cookie = $this->Cookie->read('remember_me_cookie');

            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $cookie['username'],
                    'User.password' => $cookie['password']
                )
            ));

            if ($user && !$this->Auth->login($user['User'])) {
                $this->redirect('/users/logout'); // destroy session & cookie
            }
        }    */

        //Configuro Auth
/*         $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'attivita', 'action' => 'index');
        $this->Auth->flash = array('element' => 'alert', 'key' => 'auth', 'params' => array('class' => 'alert-error'));
        $this->Auth->authenticate = array('Form' => array('passwordHasher' => 'Simple'),);
        $this->Auth->authError = "Non sei autorizzato ad accedere a questa sezione del sito"; 
        $this->Auth->authorize = array('Tools.Tiny'=>array('aclKey'=>'group_id'));
 */
        parent::beforeFilter();  
    }
}
