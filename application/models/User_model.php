<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function authenticate_user($email,$password)
	{
		$password = hash('sha256', $password);
		$this->db->select('name,email,role');
		return $this->db->get_where('users', array('email' => $email,'password'=>$password))->row_array();
	}
	
}
