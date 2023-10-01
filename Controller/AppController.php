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
class AppController extends Controller
{
  public $helpers = [
    'Session',
    'Time',
    'Js',
    'Html' => ['className' => 'BoostCake.BoostCakeHtml'],
    'Form' => ['className' => 'BoostCake.BoostCakeForm'],
    'Paginator' => ['className' => 'BoostCake.BoostCakePaginator'],
    'Tools.Common',
  ];


  public $components = [
    'Session',
    'RequestHandler',
    'Flash',
    'Auth',
    'Tools.Common',
    'Cookie',
  ];

  public $uses = ['User'];

  /**
   * AppController::constructClasses()
   *
   * @return void
   */
  public function constructClasses()
  {
    if (CakePlugin::loaded('DebugKit') && Configure::read('debug')) {
      $this->components[] = 'DebugKit.Toolbar';
    }

    parent::constructClasses();
  }

  public function beforeFilter()
  {
    // set cookie options
    $this->Cookie->key = 'tantovalagattaallardochecilascialozampino1234';
    $this->Cookie->httpOnly = true;

    if (!$this->Auth->loggedIn() && $this->Cookie->read('remember_me_cookie')) {
      $cookie = $this->Cookie->read('remember_me_cookie');
      if (isset($cookie['username']) && isset($cookie['password'])) {
        $user = $this->User->find('first', [
          'conditions' => [
            'User.username' => $cookie['username'],
            'User.password' => $cookie['password']
          ]
        ]);
      } else {
        $this->Cookie->delete('remember_me_cookie');
        $this->Auth->logout();
      }

      if (isset($user) && !$this->Auth->login($user['User'])) {
        $this->Cookie->delete('remember_me_cookie');
        $this->Auth->logout();
      }
    }

    //Configuro Auth
    $this->Auth->loginAction = ['controller' => 'users', 'action' => 'login'];
    $this->Auth->logoutRedirect = ['controller' => 'users', 'action' => 'login'];
    $this->Auth->loginRedirect = ['controller' => 'attivita', 'action' => 'index'];
    $this->Auth->flash = ['element' => 'alert', 'key' => 'auth', 'params' => ['class' => 'alert-error']];
    $this->Auth->authenticate = ['Basic', 'Form' => ['passwordHasher' => 'Simple'],];
    $this->Auth->authError = "Non sei autorizzato ad accedere a questa sezione del sito";
    $this->Auth->authorize = ['Tools.Tiny' => ['aclKey' => 'group_id']];

    parent::beforeFilter();
  }
}
