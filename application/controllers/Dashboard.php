<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$userData = $this->session->userdata('login_user_data');
		$data['title'] = "Category Management";
		$data['btnName'] = "Add";
		$data['userName'] = $userData['name'];
		$data['userRole'] = $userData['role'];
		
		$this->load->view("template/header");
		$this->load->view("dashboard", $data);
		$this->load->view("template/footer");
	}

}
