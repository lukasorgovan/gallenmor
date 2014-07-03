<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User {

	  private $id;
	  private $username;
	  private $gems;
	  private $allowed_to_play;
	  private $birthday;
	  private $avatar;
	  private $forum_rank;
	  private $banned;

    public function set($data)
    {
    	foreach ($data as $prop) {
    		$this[$prop] = $data[$prop];
    	}
    }
}

/* End of file User.php */