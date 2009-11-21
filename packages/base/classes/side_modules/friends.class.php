<?php
    class SideModuleFriends extends Module
    {
	public $template = 'friends_online';
	public $id = 'friends';
	
	public $friends = array();
	
	public function __construct($user)
	{
	    $this->friends = $user->get('friends_online', true);
	}
    }
?>