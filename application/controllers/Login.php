<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
		{
			parent::__construct();
			$this->load->model('Login_model');
		}


		public function index()
		{
			$cek = $this->session->userdata('logged_in');
			if(empty($cek))
			{
				$this->load->view('login');
			}
			else
			{
				$st = $this->session->userdata('status');
				if($st=='admin')
				{
					header('location:'.base_url().'admin');
				}
				else if($st=='operator')
				{
					header('location:'.base_url().'operator');
				}

			}


		}

		public function getlogin()
		{
			$usr = $this->input->post('username');
			$pwd = $this->input->post('password');
			$this->Login_model->getLoginData($usr,$pwd);
		}

		public function logout()
		{
			$cek = $this->session->userdata('logged_in');
			if(empty($cek))
			{
				header('location:'.base_url().'login');
			}
			else
			{
				$this->session->sess_destroy();
				header('location:'.base_url().'login');

			}
	}




} //end of Admin Controller
