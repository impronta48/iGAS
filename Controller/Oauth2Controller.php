<?php

class Oauth2Controller extends Controller {

    var $components = ['Oauth2c','Auth','Session'];
    
    function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->Oauth2c->allow();
    }

    function index()
    {
    
    }
    
    function fbLogin()
    {
        $this->Session->write('state');
        $this->Session->write('code');
        $this->Oauth2c->fbLogin();
        $this->autoRender = false;
    }

    function googleLogin()
    {
        $this->Session->write('state');
        $this->Session->write('code');
        $this->Oauth2c->googleLogin();
        $this->autoRender = false;
    }


}
