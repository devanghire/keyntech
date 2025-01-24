<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index()
	{
		$this->load->view("login");	
	}

	public function authenticate_user()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
     
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('password', 'Password', 'required');
      if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
            redirect(base_url());
		} else {
         $loginUserData = $this->User_model->authenticate_user(trim($email),trim($password));
         if(!empty($loginUserData)){
            $this->session->set_userdata('login_user_data', $loginUserData);
            redirect(base_url('dashboard'));
         }else{
            $this->session->set_flashdata('error','User Not Found');
            redirect(base_url());
         }
      }
		
	}
   public function logout(){
      $this->session->sess_destroy();
      redirect(base_url());
   }
}
