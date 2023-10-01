<?php class Group extends AppModel{
	var $name = 'Group';
	var $hasMany = ['User'];
	var $actsAs = ['Acl' => ['requester']];
 
	function parentNode() {
		return null;
	}
	
}
?>