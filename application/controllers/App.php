<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	function __construct()
		{
			parent::__construct();
			$this->load->model('App_model','apmo');


		}

	public function index()
	{
		$waktu= $this->apmo->set_waktu();
		if($waktu ==='mulai'){

		
		$data['kandidat1'] = $this->apmo->kandidat1(1);
		$data['kandidat2'] = $this->apmo->kandidat1(2);
		$data['kandidat3'] = $this->apmo->kandidat1(3);

		$this->load->view('landing_page',$data);
		}
		elseif ($waktu ==='belum') {
			$data['konten'] = 'app/belum_mulai';
			$this->load->view('app/close_page',$data);
		}
		else {
			$data['konten'] = 'app/waktu_habis';
			$this->load->view('app/close_page',$data);
		}
	}

  public function scan_barcode() {
		$kodebar = $this->input->post("barcode");
		 $this->apmo->getbarcode($kodebar);

  }

	public function voting(){
		if (!empty($this->session->userdata('nis'))){

		$data['kandidat1'] = $this->apmo->kandidat1(1);
		$data['kandidat2'] = $this->apmo->kandidat1(2);
		$data['kandidat3'] = $this->apmo->kandidat1(3);

		$this->load->view('front/voting_page',$data);
		}
		else {
				header('location:'.base_url().'app');
		}
	}

  public function getvote(){
	  if (!empty($this->session->userdata('nis'))){
		$key = $this->uri->segment(3);
		$nis = $this->session->userdata('nis');
		$data = array(
        'nis' => $nis,
        'pilihan' => $key
        );

		$this->db->insert('tbl_hasil', $data);
		$this->session->sess_destroy();
		$this->load->view('front/thankyou.php');
	  }
	  else {
				header('location:'.base_url().'app');
		}
	  
  }


} //end of App Controller
