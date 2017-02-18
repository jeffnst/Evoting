<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
		{
			parent::__construct();
			$this->load->model('Admin_model','admin');
			$this->load->model('Kandidat_model','kandidat');
			$this->load->model('Pengguna_model','pengguna');
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->library('Pdf');
		}

	public function index()
		{
			
			$cek= $this->session->userdata('logged_in');
			$stts = $this->session->userdata('level');
			if(!empty($cek) && $stts=='admin'or $stts=='super')  
				{
					if ($stts=='super') {
					$data['menu'] = 'admin/admin_super_menu';
					}
					else {
					$data['menu'] = 'admin/admin_menu';
					}
					$data['ptitle'] = '';
					$data['box1'] = $this->admin->box(1);
					$data['box2'] = $this->admin->box(2);
					$data['box3'] = $this->admin->box(3);
					$data['paslon1'] = $this->admin->paslon(1);
					$data['paslon2'] = $this->admin->paslon(2);
					$data['paslon3'] = $this->admin->paslon(3);
					$data['konten'] = 'admin/admin_dashboard';
					$data['total_pemilih']=$this->db->count_all_results('tbl_hasil');
					$data['pemilih_kandidat1']=$this->admin->totalrows('tbl_hasil','pilihan','1');
					$data['pemilih_kandidat2']=$this->admin->totalrows('tbl_hasil','pilihan','2');
					$data['pemilih_kandidat3']=$this->admin->totalrows('tbl_hasil','pilihan','3');
					$data['total_dpt']=$this->db->count_all_results('tbl_dpt');
					$data['grafik'][]=$this->admin->totalrows('tbl_hasil','pilihan','1');
					$data['grafik'][]=$this->admin->totalrows('tbl_hasil','pilihan','2');
					$data['grafik'][]=$this->admin->totalrows('tbl_hasil','pilihan','3');
					$data['nama_sekolah']=$this->admin->info_sekolah();
					$data['tahun_pemilihan'] = $this->admin->info_tahun_pemilihan();


					$this->load->view('admin/admin_template',$data);

				}

			else
			{
				header('location:'.base_url().'login');
			}


		} // end of method

public function kosongkan_db(){
		$cek= $this->session->userdata('logged_in');
		$stts = $this->session->userdata('level');
		if(!empty($cek) && $stts=='super')
			{
				$data['menu'] = 'admin/admin_super_menu';
				$data['konten'] = 'admin/admin_empty_db';
				$data['msg'] 	='';
			
				$this->load->view('admin/admin_template',$data);
			}

			else
			{
				header('location:'.base_url().'login');
			}
}

public function get_empty_db(){
	$cek= $this->session->userdata('logged_in');
		$stts = $this->session->userdata('level');
		if(!empty($cek) && $stts=='super')
			{
				$table = $this->uri->segment(3);
				if ($this->db->empty_table($table)){

				$data['menu'] = 'admin/admin_super_menu';
				$data['konten'] = 'admin/admin_empty_db';
				$data['msg'] 	='Proses pengosongan Tabel <b>'.$table.'</b> berhasil';
			
				$this->load->view('admin/admin_template',$data);
				}

				
		
		
			}

			else
			{
				header('location:'.base_url().'login');
			}
}		

public function restore_db(){
	$cek= $this->session->userdata('logged_in');
		$stts = $this->session->userdata('level');
		if(!empty($cek) && $stts=='super')
			{
				$data['menu'] = 'admin/admin_super_menu';
				$data['konten'] = 'admin/admin_restore_db';
				$data['msg'] 	='';
			
				$this->load->view('admin/admin_template',$data);
			}

			else
			{
				header('location:'.base_url().'login');
			}

}

public function get_restore(){
				$filename = $this->input->post('file',True);
				$config['upload_path']          = 'backup/';
				$config['allowed_types']        = 'sql';
				$config['file_name'] = $filename;

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload('file')) //upload and validate
				{
					print_r($this->upload->display_errors());	
				}
				
				$media = $this->upload->data();
   				$inputFileName = 'backup/'.$media['file_name'];
				
				// $restore_file = $this->upload->data('file_name');
				// return $restore_file;
				print_r($filename);
				$isi_file = file_get_contents($inputFileName);
				$string_query = rtrim ($isi_file, "\n;");
				$array_query = explode(";",$string_query);
				foreach($array_query as $query)
					{
					$this->db->query($query);
					}
					
				$data['menu'] 	= 'admin/admin_super_menu';
				$data['konten'] = 'admin/admin_restore_db';
				$data['msg'] 	= "Proses pemulihan data berhasil";
				$this->load->view('admin/admin_template',$data);
				
				
					
}

public function backup_db(){
	$cek= $this->session->userdata('logged_in');
		$stts = $this->session->userdata('level');
		if(!empty($cek) && $stts=='super')
			{

			$prefs = array(
							'tables'     => array('tbl_dpt', 'tbl_hasil','tbl_kandidat'),
							// Array table yang akan dibackup
							'ignore'     => array(),
							// Daftar table yang tidak akan dibackup
							'format'     => 'sql',
							// gzip, zip, txt format filenya
							'filename'   => 'evoting.sql',
							// Nama file
							'add_drop'   => TRUE, 
							// Untuk menambahkan drop table di backup
							'add_insert' => TRUE,
							// Untuk menambahkan data insert di file backup
							'newline'    => "\n"
							// Baris baru yang digunakan dalam file backup
						);
	

				// Load the DB utility class
			$this->load->dbutil();

			// Backup database dan dijadikan variable
			$backup = $this->dbutil->backup($prefs);

			// Load file helper dan menulis ke server untuk keperluan restore
			
			write_file('./backup/evoting.sql', $backup);

			// Load the download helper dan melalukan download ke komputer
			$this->load->helper('download');
			$name="evoting-".date('Ymd-His').".sql";
			force_download($name, $backup);

			}
}


  public function data_pemilih(){
		$cek= $this->session->userdata('logged_in');
		$stts = $this->session->userdata('level');
		if(!empty($cek) && $stts=='admin'or $stts=='super')
			{
				if ($stts=='super') {
					$data['menu'] = 'admin/admin_super_menu';
					}
					else {
					$data['menu'] = 'admin/admin_menu';
					}
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
		$stts = $this->session->userdata('level');
		if(!empty($cek) && $stts=='admin'or $stts=='super')
			{
				if ($stts=='super') {
					$data['menu'] = 'admin/admin_super_menu';
					}
					else {
					$data['menu'] = 'admin/admin_menu';
					}
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
				'nama_panggilan' => $this->input->post('nama_panggilan'),
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
				'nama_panggilan' => $this->input->post('nama_panggilan'),
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

		if($this->input->post('nama_panggilan') == '')
		{
			$data['inputerror'][] = 'nama_panggilan';
			$data['error_string'][] = 'Nama Panggilan is required';
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


public function pengguna(){
		$cek= $this->session->userdata('logged_in');
		$stts = $this->session->userdata('level');
		if(!empty($cek) && $stts=='super')
			{
				$data['menu'] = 'admin/admin_super_menu';
				$data['ptitle'] = '';
				$data['infobar'] = '';
				$data['konten'] = 'admin/admin_pengguna';

				$this->load->view('admin/admin_template',$data);

  }

}
 public	function pengguna_list()
	{
		$list = $this->pengguna->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			$no++;
			$row = array();
			$row[] = $user->username;
			$row[] = $user->nama;
			$row[] = $user->level;


			//add html for action
			$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$user->id."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pengguna->count_all(),
						"recordsFiltered" => $this->pengguna->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}



public function pengguna_add()
	{
		$this->_pengguna_validate();
		$data = array(
				'nama' => $this->input->post('nama'),
				'username' => $this->input->post('username'),
				'password' => md5("password"),
				'level' => $this->input->post('level'),

			);
		$insert = $this->pengguna->save($data);
		echo json_encode(array("status" => TRUE));
	}


	public function pengguna_delete($id)
	{
		$this->pengguna->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


 private function _pengguna_validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama is required';
			$data['status'] = FALSE;
		}


		if($this->input->post('username') == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'level is required';
			$data['status'] = FALSE;
		}



		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

public function sandi(){
			$cek= $this->session->userdata('logged_in');
			$stts = $this->session->userdata('level');
			if(!empty($cek) && $stts=='admin'or $stts=='super')  
				{
					if ($stts=='super') {
					$data['menu'] = 'admin/admin_super_menu';
					}
					else {
					$data['menu'] = 'admin/admin_menu';
					}
					$data['ptitle'] = '';
					$data['msg'] = '';
					$data['konten'] = 'admin/admin_sandi';
					$this->load->view('admin/admin_template',$data);

				}

			else
			{
				header('location:'.base_url().'login');
			}
}
 public function change_pass()
{	
	
	$id= $this->session->userdata('id');
	$newpass= md5($this->input->post('new_pass'));
	$this->db->where('id',$id);
	if($this->db->update('tbl_user', array('password'=>$newpass))){
			$stts = $this->session->userdata('level');
			if( $stts=='admin' or $stts=='super')  
				{
					if ($stts=='super') {
					$data['menu'] = 'admin/admin_super_menu';
					}
					else {
					$data['menu'] = 'admin/admin_menu';
					}
					
					$data['msg']= 'Sandi berhasil diubah, silahkan logout dan login kembali untuk menerapkan perubahan';
		
					$data['konten'] = 'admin/admin_sandi';
					$this->load->view('admin/admin_template',$data);

				}	
		
		
	}

}

public function info()
		{
			
			$cek= $this->session->userdata('logged_in');
			$stts = $this->session->userdata('level');
			if(!empty($cek) &&  $stts=='super')  
				{
					
					$data['menu'] = 'admin/admin_super_menu';
					
					$data['konten'] = 'admin/admin_info_aplikasi';
					$data['isi'] = $this->db->get('tbl_info')->result();

					$this->load->view('admin/admin_template',$data);

				}

			else
			{
				header('location:'.base_url().'login');
			}


		} // end of method

public function update_info(){
	
		$info = $this->db->get('tbl_info',1);
	if (count($info->result())>0){
		//fungsi update
		$data = array(
		
		'nama_sekolah' => $this->input->post('nama_sekolah'),
		'periode'=> $this->input->post('periode'),
		'tahun_pemilihan' => $this->input->post('tahun_pemilihan'),
		'mulai_pemilihan' => $this->input->post('mulai_pemilihan'),
		'selesai_pemilihan'=> $this->input->post('selesai_pemilihan')
		
		);	
		
		if($this->input->post('remove_kop')) // if remove photo checked
		{
			if(file_exists('uploads/'.$this->input->post('remove_kop')) && $this->input->post('remove_kop'))
				unlink('uploads/'.$this->input->post('remove_kop'));
			$data['kop_surat'] = '';
		}

		if(!empty($_FILES['kop_surat']['name']))
		{
			$upload = $this->_kop_do_upload();

			//delete file
			$filekop = $this->admin->get_id($this->input->post('id'));
			if(file_exists('uploads/'.$filekop->kop_surat) && $filekop->kop_surat)
				unlink('uploads/'.$filekop->kop_surat);

			$data['kop_surat'] = $upload;
		}


		$this->admin->update_info(array('id' => $this->input->post('id')), $data);
			$this->session->set_flashdata('msg_info', 'Data Berhasil Diupdate');
		}
		
	
	
	else {
		//fungsi insert
		$data = array(
		
		'nama_sekolah' => $this->input->post('nama_sekolah'),
		'periode'=> $this->input->post('periode'),
		'tahun_pemilihan' => $this->input->post('tahun_pemilihan'),
		'mulai_pemilihan' => $this->input->post('mulai_pemilihan'),
		'selesai_pemilihan'=> $this->input->post('selesai_pemilihan')
		);	
		if(!empty($_FILES['kop_surat']['name']))
		{
			$upload = $this->_kop_do_upload();
			$data['kop_surat'] = $upload;
		}
		$this->admin->save_info($data);
			$this->session->set_flashdata('msg_info', 'Data Berhasil Disimpan');
		
	}
	// var_dump($data);
	//var_dump($this->upload->display_errors('',''));
	  header('location:'.base_url().'admin/info');
}

private function _kop_do_upload()
	{
		$config['upload_path']          = './uploads/';
				$config['allowed_types']        = 'gif|jpg|png';
				$config['max_size']             = 1000; //set max size allowed in Kilobyte
				$config['max_width']            = 0; // set max width image allowed
				$config['max_height']           = 0; // set max height allowed
				$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

				$this->load->library('upload', $config);

				$this->upload->do_upload('kop_surat'); //upload and validate
				
			
		return $this->upload->data('file_name');
	}

public function laporan()
		{
			
			$cek= $this->session->userdata('logged_in');
			$stts = $this->session->userdata('level');
			if(!empty($cek) &&  $stts=='super' or $stts=='admin' )  
				{
					
					if ($stts=='super') {
					$data['menu'] = 'admin/admin_super_menu';
					}
					else {
					$data['menu'] = 'admin/admin_menu';
					}
					
					$data['konten'] = 'admin/admin_laporan';
					$data['nama_sekolah']=$this->admin->info_sekolah();
					$data['tahun_pemilihan'] = $this->admin->info_tahun_pemilihan();
					

					$this->load->view('admin/admin_template',$data);

				}

			else
			{
				header('location:'.base_url().'login');
			}


		} // end of method

 


	public function lapdpt()
	{
		$hasil=$this->db->get('tbl_dpt');
		$nama_sekolah =$this->admin->info_sekolah();
		$kop=$this->admin->info_kop();
		$tahun_pemilihan = $this->admin->info_tahun_pemilihan();
		$heading=array('NO','NIS','NAMA','KELAS');
		$objPHPExcel = new PHPExcel();
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$gdImage = imagecreatefromjpeg('./uploads/'.$kop);
		$objDrawing->setName('kop surat');
		$objDrawing->setDescription('kop surat');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing->setResizeProportional(true); 
		$objDrawing->setWidthAndHeight(350,200); 
		//$objDrawing->setHeight(100);
		//$objDrawing->setWidth(450);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

		$objPHPExcel->getActiveSheet()->setTitle('Lap_DPT');
		$judul='Daftar Pemilih Tetap Dalam Pemilihan Ketua dan Wakil Ketua OSIS SMA ' .$nama_sekolah. ' Tahun ' .$tahun_pemilihan;
		$objPHPExcel->getActiveSheet()->mergeCells('A6:D7')->getStyle('A6:D7')
    ->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A6',$judul);
		 



		$rowNumberH=10;
		$colH='A';
		foreach ($heading as $h) {
			$objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
			$colH++;
		}
				$totr = $hasil->num_rows();
		$maxr=$totr+1;
		$hsl=$hasil->result();
		$row=11;
		$no=1;
		foreach($hsl as $h){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$h->nis);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$h->nama);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$h->kelas);
			$row++;
			$no++;
		}
		$objPHPExcel->getActiveSheet()->freezePane('A4');

			// merubah style border pada cell yang aktif (cell yang terisi)
		$styleArray = array( 'borders' => 
			array( 'allborders' => 
				array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
					), 
				), 
			);
 
		// melakukan pengaturan pada header kolom
		$fontHeader = array( 
			'font' => array(
				'bold' => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_SOLID,
            	'color' => array('rgb' => '6CCECB')
        	)
		);

		$kop =  array( 
			
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_NONE
            	
        	)
		);

		$judul =  array( 
			
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'wrap' => TRUE
            	
        	
		);
		$objPHPExcel->getActiveSheet()->getStyle('A1:D9')->applyFromArray($kop);
		//$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($judul);		
		 $objPHPExcel->getActiveSheet()->getStyle('A10:D10')->applyFromArray($fontHeader);
		 $objPHPExcel->getActiveSheet()->getStyle('A11:D'.$row)->applyFromArray($styleArray);

		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan_DPT.xls"');
    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');
   
    exit();
	}


public function lapkandidat(){
 // NO urut, NIS, NAMA , Kelas, Posisi, Foto

		$kandidat=$this->db->get('tbl_kandidat');
		$nama_sekolah =$this->admin->info_sekolah();
		$kop=$this->admin->info_kop();
		$tahun_pemilihan = $this->admin->info_tahun_pemilihan();
		$heading=array('NO. Urut','NIS','NAMA','KELAS','POSISI', 'FOTO');
		$objPHPExcel = new PHPExcel();
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$gdImage = imagecreatefromjpeg('./uploads/'.$kop);
		$objDrawing->setName('kop surat');
		$objDrawing->setDescription('kop surat');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing->setResizeProportional(true); 
		$objDrawing->setWidthAndHeight(380,200); 
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

		$objPHPExcel->getActiveSheet()->setTitle('Lap_Kandidat');


		$judul='Daftar Calon Ketua dan Wakil Ketua OSIS SMA ' .$nama_sekolah. ' Tahun ' .$tahun_pemilihan;
		$objPHPExcel->getActiveSheet()->mergeCells('A6:F7')->getStyle('A6:F7')
    ->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A6',$judul);


		$rowNumberH=10;
		$colH='A';
		foreach ($heading as $h) {
			$objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
			$colH++;
		}

		$totr = $kandidat->num_rows();
		$maxr=$totr+1;
		$hsl=$kandidat->result();
		$row=11;
		
		foreach($hsl as $h){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$h->no_urut);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$h->nis);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$h->nama);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$h->kelas);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$h->posisi);
			$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(80);

			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$foto = imagecreatefromjpeg('./uploads/'.$h->foto);
			$objDrawing->setImageResource($foto);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setWidthAndHeight(60,100);
			$objDrawing->setOffsetX(2);
			$objDrawing->setOffsetY(2);
			$objDrawing->setCoordinates('F'.$row);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			
			$row++;
			
		} // end foreach
		$endrow=$row-1;
		// merubah style border pada cell yang aktif (cell yang terisi)
		$styleArray = array( 'borders' => 
			array( 'allborders' => 
				array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
					), 
				), 
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_NONE
            	),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,

			),
			'wrap' => TRUE,
			);
 
		// melakukan pengaturan pada header kolom
		$fontHeader = array( 
			'font' => array(
				'bold' => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_SOLID,
            	'color' => array('rgb' => '6CCECB')
        	)
		);

		$kop =  array( 
			
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_NONE
            	
        	)
		);

		
		 $objPHPExcel->getActiveSheet()->getStyle('A1:D9')->applyFromArray($kop);
		 $objPHPExcel->getActiveSheet()->getStyle('A10:F10')->applyFromArray($fontHeader);
		 $objPHPExcel->getActiveSheet()->getStyle('A11:F'.$endrow)->applyFromArray($styleArray);

		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    	
		
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');	
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan_Kandidat.xls"');
    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');
   
    exit(); 

}

public function laphasil(){
 // No urut, Nama Pasangan Calon, Jumlah suara, 
	// total suara, total dpt, selisih

		$nama_sekolah =$this->admin->info_sekolah();
		$kop=$this->admin->info_kop();
		$tahun_pemilihan = $this->admin->info_tahun_pemilihan();
		$heading=array('NO. Urut','NAMA PASANGAN CALON','JUMLAH SUARA');
		$objPHPExcel = new PHPExcel();
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$gdImage = imagecreatefromjpeg('./uploads/'.$kop);
		$objDrawing->setName('kop surat');
		$objDrawing->setDescription('kop surat');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing->setResizeProportional(false); 
		//$objDrawing->setWidthAndHeight(10,5);
		$objDrawing->setWidth(200);
		$objDrawing->setHeight(100); 
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

		$objPHPExcel->getActiveSheet()->setTitle('Lap_Kandidat');


		$judul='Tabel Hasil Pemilihan Ketua dan Wakil Ketua OSIS SMA  ' .$nama_sekolah. ' Tahun ' .$tahun_pemilihan;
		$objPHPExcel->getActiveSheet()->mergeCells('A6:C7')->getStyle('A6:C7')
														   ->getAlignment()
														   ->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A6',$judul);

		$pemilih_kandidat1=$this->admin->totalrows('tbl_hasil','pilihan','1');
		$pemilih_kandidat2=$this->admin->totalrows('tbl_hasil','pilihan','2');
		$pemilih_kandidat3=$this->admin->totalrows('tbl_hasil','pilihan','3');
		$total_dpt=$this->db->count_all_results('tbl_dpt');
		$total_pemilih =  $pemilih_kandidat1+$pemilih_kandidat2+$pemilih_kandidat3;
		$selisih=$total_dpt-$total_pemilih;

		$paslon1 = $this->admin->paslon(1);
		$paslon2 = $this->admin->paslon(2);
		$paslon3 = $this->admin->paslon(3);

		$rowNumberH=10;
		$colH='A';
		foreach ($heading as $h) {
			$objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
			$colH++;
		}

			$objPHPExcel->getActiveSheet()->setCellValue('A11','1');
			$objPHPExcel->getActiveSheet()->setCellValue('B11',$paslon1);
			$objPHPExcel->getActiveSheet()->setCellValue('C11',$pemilih_kandidat1);

			$objPHPExcel->getActiveSheet()->setCellValue('A12','2');
			$objPHPExcel->getActiveSheet()->setCellValue('B12',$paslon2);
			$objPHPExcel->getActiveSheet()->setCellValue('C12',$pemilih_kandidat2);

			$objPHPExcel->getActiveSheet()->setCellValue('A13','3');
			$objPHPExcel->getActiveSheet()->setCellValue('B13',$paslon2);
			$objPHPExcel->getActiveSheet()->setCellValue('C13',$pemilih_kandidat3);

			$objPHPExcel->getActiveSheet()->mergeCells('A14:B14')->setCellValue('A14','Total Suara');
			$objPHPExcel->getActiveSheet()->mergeCells('A15:B15')->setCellValue('A15','Total DPT');
			$objPHPExcel->getActiveSheet()->mergeCells('A16:B16')->setCellValue('A16','Selisih');

			$objPHPExcel->getActiveSheet()->setCellValue('C14',$total_pemilih);
			$objPHPExcel->getActiveSheet()->setCellValue('C15',$total_dpt);
			$objPHPExcel->getActiveSheet()->setCellValue('C16',$selisih);
		
		$objPHPExcel->getActiveSheet()->getRowDimension(11)->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getRowDimension(13)->setRowHeight(20);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

    	
		// merubah style border pada cell yang aktif (cell yang terisi)
		$styleArray = array( 'borders' => 
			array( 'allborders' => 
				array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
					), 
				), 
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_NONE
            	),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,

			),
			'wrap' => TRUE,
			);
 
		// melakukan pengaturan pada header kolom
		$fontHeader = array( 
			'font' => array(
				'bold' => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_SOLID,
            	'color' => array('rgb' => '6CCECB')
        	)
		);

		$kop =  array( 
			
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_NONE
            	
        	)
		);

		$bawah =  array( 
			
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_NONE,
            	'color' => array('rgb' => '6CCECB'
            	
        	)
            		),
            'borders' => 
			array( 'allborders' => 
				array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
					), 
				), 
		);

		
		 $objPHPExcel->getActiveSheet()->getStyle('A1:D9')->applyFromArray($kop);
		 $objPHPExcel->getActiveSheet()->getStyle('A10:C10')->applyFromArray($fontHeader);
		 $objPHPExcel->getActiveSheet()->getStyle('A11:C13')->applyFromArray($styleArray);
		 $objPHPExcel->getActiveSheet()->getStyle('A14:C16')->applyFromArray($bawah);


    	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment;filename="Laporan_Hasil_Pemilihan.xls"');
	    header('Cache-Control: max-age=0');
	    $objWriter->save('php://output');
	   
	    exit(); 
}

public function lapdptpdf(){

	$data['dpt']=$this->db->get('tbl_dpt')->result();
	$data['nama_sekolah']=$this->admin->info_sekolah();
	$data['tahun_pemilihan'] = $this->admin->info_tahun_pemilihan();
	$data['kop']=$this->admin->info_kop();
	$this->load->view('admin/admin_lapdpt_pdf',$data);

}
public function lapkandidatpdf(){

	$data['kandidat']=$this->db->get('tbl_kandidat')->result();
	$data['nama_sekolah']=$this->admin->info_sekolah();
	$data['tahun_pemilihan'] = $this->admin->info_tahun_pemilihan();
	$data['kop']=$this->admin->info_kop();
	$this->load->view('admin/admin_lapkandidat_pdf',$data);

}

public function laphasilpdf(){

	$data['kandidat']=$this->db->get('tbl_kandidat')->result();
	$data['nama_sekolah']=$this->admin->info_sekolah();
	$data['tahun_pemilihan'] = $this->admin->info_tahun_pemilihan();
	$data['pemilih_kandidat1']=$this->admin->totalrows('tbl_hasil','pilihan','1');
	$data['pemilih_kandidat2']=$this->admin->totalrows('tbl_hasil','pilihan','2');
	$data['pemilih_kandidat3']=$this->admin->totalrows('tbl_hasil','pilihan','3');
	$data['total_dpt']=$this->db->count_all_results('tbl_dpt');
		
	$data['paslon1'] = $this->admin->paslon(1);
	$data['paslon2'] = $this->admin->paslon(2);
	$data['paslon3'] = $this->admin->paslon(3);
	$data['kop']=$this->admin->info_kop();
	$this->load->view('admin/admin_laphasil_pdf',$data);

}

} //end of Admin Controller
