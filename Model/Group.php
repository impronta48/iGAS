<?php class Group extends AppModel{
	var $name = 'Group';
	var $hasMany = array('User');
	var $actsAs = array('Acl' => array('requester'));
 
	function parentNode() {
		return null;
	}
	
}
?>