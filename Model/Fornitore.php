<?php
//Classe che esiste per ragioni storiche, è un alias di Persone
class Fornitore extends AppModel {	
    public $displayField = 'DisplayName';
    public $useTable = 'persone';    
    public $order = 'DisplayName';    
}
?>