<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
		{
			parent::__construct();
			$this->load->model('Admin_model','admin');
			$this->load->model('Kandidat_model','kandidat');
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		}

	public function index()
		{
			$cek= $this->session->userdata('logged_in');
			$stts = $this->session->userdata('status');
			if(!empty($cek) && $stts=='admin')
				{
					$data['menu'] = 'admin/admin_menu';
					$data['ptitle'] = '';
					$data['infobar'] = '';
					$data['konten'] = 'admin/admin_dashboard';
					$data['total_pemilih']=$this->db->count_all_results('tbl_hasil');
					$data['pemilih_kandidat1']=$this->admin->totalrows('tbl_hasil','pilihan','1');
					$data['pemilih_kandidat2']=$this->admin->totalrows('tbl_hasil','pilihan','2');
					$data['pemilih_kandidat3']=$this->admin->totalrows('tbl_hasil','pilihan','3');
					$data['grafik'][]=$this->admin->totalrows('tbl_hasil','pilihan','1');
					$data['grafik'][]=$this->admin->totalrows('tbl_hasil','pilihan','2');
					$data['grafik'][]=$this->admin->totalrows('tbl_hasil','pilihan','3');


					$this->load->view('admin/admin_template',$data);

				}

			else
			{
				header('location:'.base_url().'login');
			}


		} // end of method




  public function data_pemilih(){
		$cek= $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='admin')
			{
				$data['menu'] = 'admin/admin_menu';
				$data['ptitle'] = '';
				$data['infobar'] = '';
				$data['konten'] = 'admin/admin_dpt';

				$this->load->view('admin/admin_template',$data);

  }

}
 public	function ajax_list()
	{
		$list = $this->admin->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $siswa) {
			$no++;
			$row = array();
			$row[] = $siswa->nis;
			$row[] = $siswa->nama;
			$row[] = $siswa->kelas;


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$siswa->id."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
					<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$siswa->id."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->admin->count_all(),
						"recordsFiltered" => $this->admin->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->admin->get_by_id($id);

		echo json_encode($data);
	}

public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nis' => $this->input->post('nis'),
				'nama' => $this->input->post('nama'),
				'kelas' => $this->input->post('kelas'),

			);
		$insert = $this->admin->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nis' => $this->input->post('nis'),
				'nama' => $this->input->post('nama'),
				'kelas' => $this->input->post('kelas'),

			);
		$this->admin->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->admin->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


 private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nis') == '')
		{
			$data['inputerror'][] = 'nis';
			$data['error_string'][] = 'NIS is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama is required';
			$data['status'] = FALSE;
		}


		if($this->input->post('kelas') == '')
		{
			$data['inputerror'][] = 'kelas';
			$data['error_string'][] = 'Please select kelas';
			$data['status'] = FALSE;
		}



		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function kandidat(){
		$cek= $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='admin')
			{
				$data['menu'] = 'admin/admin_menu';
				$data['ptitle'] = '';
				$data['infobar'] = '';
				$data['konten'] = 'admin/admin_kandidat';

				$this->load->view('admin/admin_template',$data);

	}

	}

	public function kandidat_list()
	{


		$list = $this->kandidat->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = $person->no_urut;
			$row[] = $person->nis;
			$row[] = $person->nama;
			$row[] = $person->kelas;
			$row[] = $person->posisi;
			if($person->foto)
				$row[] = '<a href="'.base_url('uploads/'.$person->foto).'" target="_blank"><img src="'.base_url('uploads/'.$person->foto).'" class="img-responsive" style="width:100px;height:150px"/></a>';
			else
				$row[] = '(No photo)';

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kandidat->count_all(),
						"recordsFiltered" => $this->kandidat->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function kandidat_edit($id)
	{
		$data = $this->kandidat->get_by_id($id);

		echo json_encode($data);
	}

	public function kandidat_add()
	{
		$this->_kandidat_validate();

		$data = array(
				'no_urut' => $this->input->post('no_urut'),
				'nis' => $this->input->post('nis'),
				'nama' => $this->input->post('nama'),
				'kelas' => $this->input->post('kelas'),
				'posisi' => $this->input->post('posisi'),
			);

		if(!empty($_FILES['foto']['name']))
		{
			$upload = $this->_do_upload();
			$data['foto'] = $upload;
		}

		$insert = $this->kandidat->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function kandidat_update()
	{
		$this->_kandidat_validate();
		$data = array(
				'no_urut' => $this->input->post('no_urut'),
				'nis' => $this->input->post('nis'),
				'nama' => $this->input->post('nama'),
				'kelas' => $this->input->post('kelas'),
				'posisi' => $this->input->post('posisi'),
			);

		if($this->input->post('remove_foto')) // if remove photo checked
		{
			if(file_exists('uploads/'.$this->input->post('remove_foto')) && $this->input->post('remove_foto'))
				unlink('uploads/'.$this->input->post('remove_foto'));
			$data['foto'] = '';
		}

		if(!empty($_FILES['foto']['name']))
		{
			$upload = $this->_do_upload();

			//delete file
			$person = $this->kandidat->get_by_id($this->input->post('id'));
			if(file_exists('uploads/'.$person->foto) && $person->foto)
				unlink('uploads/'.$person->foto);

			$data['foto'] = $upload;
		}

		$this->kandidat->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function kandidat_delete($id)
	{
		//delete file
		$person = $this->kandidat->get_by_id($id);
		if(file_exists('uploads/'.$person->foto) && $person->foto)
			unlink('uploads/'.$person->foto);

		$this->kandidat->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$config['upload_path']          = 'uploads/';
				$config['allowed_types']        = 'gif|jpg|png';
				$config['max_size']             = 100; //set max size allowed in Kilobyte
				$config['max_width']            = 1000; // set max width image allowed
				$config['max_height']           = 1000; // set max height allowed
				$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload('foto')) //upload and validate
				{
						$data['inputerror'][] = 'foto';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

	private function _kandidat_validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nis') == '')
		{
			$data['inputerror'][] = 'nis';
			$data['error_string'][] = 'NIS is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('no_urut') == '')
		{
			$data['inputerror'][] = 'no_urut';
			$data['error_string'][] = 'no_urut is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('kelas') == '')
		{
			$data['inputerror'][] = 'kelas';
			$data['error_string'][] = 'Please select kelas';
			$data['status'] = FALSE;
		}

		if($this->input->post('posisi') == '')
		{
			$data['inputerror'][] = 'posisi';
			$data['error_string'][] = 'posisi is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}


public function upload(){
  $fileName = $this->input->post('userfile',True);

  $config['upload_path'] = 'uploads/'; 
  $config['file_name'] = $fileName;
  $config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
  $config['max_size'] = 10000;

  $this->load->library('upload', $config);
  // $this->upload->initialize($config); 
  
  if (!$this->upload->do_upload('userfile')) {
   $error = array('error' => $this->upload->display_errors());
   $this->session->set_flashdata('msg','Ada kesalah dalam upload'); 
   redirect('admin/data_pemilih'); 
  } else {
   $media = $this->upload->data();
   $inputFileName = 'uploads/'.$media['file_name'];
   
   try {
    $inputFileType = IOFactory::identify($inputFileName);
    $objReader = IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
   } catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
   }

   $sheet = $objPHPExcel->getSheet(0);
   $highestRow = $sheet->getHighestRow();
   $highestColumn = $sheet->getHighestColumn();

   for ($row = 2; $row <= $highestRow; $row++){  
     $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
       NULL,
       TRUE,
       FALSE);
     $data = array(
     "id"=> $rowData[0][0],
     "nis"=> $rowData[0][1],
     "nama"=> $rowData[0][2],
     "kelas"=> $rowData[0][3]
     
    );
    $this->db->insert("tbl_dpt",$data);
   } 
   $this->session->set_flashdata('msg','Berhasil upload ...!!'); 
   redirect('admin/data_pemilih');
  }  
 } 

  public function export_excel()
 {
	 $data[output]=$this->db->get('tbl_dpt');
	 $this->load->view('admin/admin_export_excel',$data);
 }

} //end of Admin Controller
