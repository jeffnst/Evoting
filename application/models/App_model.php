<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_Model {

public function kandidat1($urut)
	{
		$ketua1= $this->db->get_where('tbl_kandidat',array('no_urut'=>$urut, 'posisi'=>'ketua'));
		if (count($ketua1->result())>0)
		{
				foreach ($ketua1->result() as $hasil)

						$urut_ketua = $hasil->no_urut;
						$nis_ketua = $hasil->nis;
						$nama_ketua = $hasil->nama;
						$kelas_Ketua = $hasil->kelas;

						$foto_ketua=  $hasil->foto ;


		}
		$wakil1= $this->db->get_where('tbl_kandidat',array('no_urut'=>$urut, 'posisi'=>'wakil'));
		if (count($wakil1->result())>0)
		{
				foreach ($wakil1->result() as $hasil)

						$urut_wakil = $hasil->no_urut;
						$nis_wakil = $hasil->nis;
						$nama_wakil = $hasil->nama;
						$kelas_wakil = $hasil->kelas;

						$foto_wakil= $hasil->foto;

		}
$kandidat = '<div class="col-md-4">
		<!-- Widget: user widget style 1 -->
		<div class="box box-widget widget-user-2">
			<!-- Add the bg color to the header using any of the bg-* classes -->
			<div class="widget-user-header bg-yellow">
			 <div class="text-bold" style="text-align:center; "> <span class="badge bg-blue" style="font-size:20px">' . $urut . ' </span> </div>
			<div> </div>
				<div class="col-md-6 bg-yellow">
					<img class="img-square" src="'.base_url("uploads/".$foto_ketua).'" style="width:110px;height:120px" alt="Ketua">
					<h5 class="text-bold">'.$nama_ketua.'</h5>
					<h4 class="text-bold">Ketua</h4>

			</div>

				<div class="col-md-6 bg-yellow">
					<img class="img-square" src="'.base_url("uploads/".$foto_wakil).'" style="width:110px;height:120px" alt="Wakil">
					<h5 class="text-bold">'.$nama_wakil.'</h5>
					<h4 class="text-bold">Wakil</h4>
				</div>

				<!-- /.widget-user-image -->

			</div>

			<div class="box-footer no-padding">

			</div>
		</div>
		<!-- /.widget-user -->
	</div> ';

		return $kandidat;
	}

public function getbarcode($data){
	   $cek_kodebar = $this->db->get_where('tbl_dpt', array('nis'=>$data));
	  if(count($cek_kodebar->result())>0)
			  {
					$cek_voting = $this->db->get_where('tbl_hasil',array('nis'=>$data));
					if(count($cek_voting->result())>0)
					{
						// user udah pernah voting, kasi alert
						$msg = '<script>
                                swal({
                                    title: "Peringatan",
                                    text: "ID Card sudah pernah digunakan ",
                                    html: true,

                                    
                                    showConfirmButton: true,
                                    type: "warning"
                                });
            				</script>' ;	
													
						$this->session->set_flashdata('info',$msg);
						header('location:'.base_url().'app');
					}
					else {
						// arahkan kehalaman voting
						$sess_data['nis'] 		  = $data;
						$this->session->set_userdata($sess_data);

						header('location:'.base_url().'app/voting');
					}
				}
				else {
					// user tidak terdaftar, kasi alert
						$msg = '<script>
                                swal({
                                    title: "Maaf",
                                    text: "ID Card anda tidak terdaftar, silakan hubungi panitia ",
                                    html: true,
                                 
                                    showConfirmButton: true,
                                    type: "error"
                                });
            				</script>' ;	
													
						$this->session->set_flashdata('info',$msg);
						header('location:'.base_url().'app');
				}
}

public function set_waktu() {
$cek_waktu = $this->db->get('tbl_info');
	  if(count($cek_waktu->result())>0)
			  {
			  	foreach ($cek_waktu->result() as $hasil) {
			  		$mulai = $hasil->mulai_pemilihan;
			  		$selesai = $hasil->selesai_pemilihan;
			  		}

				}

$waktu_mulai = new DateTime($mulai);
$waktu_selesai = new DateTime($selesai);
$today = new DateTime();


if ($today < $waktu_mulai) {
	// belum mulai
	$waktu = 'belum';
	return $waktu;
	}
elseif ($today >= $waktu_mulai AND $today < $waktu_selesai) {
	// mulai
	$waktu = 'mulai';
	return $waktu;
	}
elseif ($today > $waktu_selesai) {
	// selesai
	$waktu = 'selesai';
	return $waktu;
	}

}

} //end of file
