<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

public function getLoginData($usr,$psw)
{
  $u =$usr;
  $p = md5($psw);

  $cek_login = $this->db->get_where('tbl_user', array('username' => $u, 'password' => $p));
  if(count($cek_login->result())>0)
  {
    foreach ($cek_login->result() as $qck)
    {
      if($qck->level=='admin')
      {

                $sess_data['logged_in']		= 'yes';
                $sess_data['id']          = $qck->id;
                $sess_data['nama'] 	     	= $qck->nama;
                $sess_data['username'] 		= $qck->username;
                $sess_data['level'] 		  = $qck->level;


                $this->session->set_userdata($sess_data);

                header('location:'.base_url().'admin');
            }
            else if($qck->level=='super')
            {

              $sess_data['logged_in']		= 'yes';
              $sess_data['id']          = $qck->id;
              $sess_data['nama'] 	     	= $qck->nama;
              $sess_data['username'] 		= $qck->username;
              $sess_data['level'] 		  = $qck->level;

               $this->session->set_userdata($sess_data);
               header('location:'.base_url().'admin');
           }

       }
   }
   else
   {
      header('location:'.base_url().'login');
      $this->session->set_flashdata('login_info','<div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">
         <i class="icon-remove"></i>
     </button>
     Username atau Password salah....!!
     <br />
 </div>');
  }
}

} //end of file
