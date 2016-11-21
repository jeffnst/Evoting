<h4> Klik tombol berikut untuk mengosongkan tabel </h4>
 
 <h1>
 <a  href="<?php echo base_url('admin/get_empty_db/tbl_dpt') ;?>" class="btn btn-lg btn-primary" >
    <i class="fa fa-users"> </i>
   <b>  Tabel DPT  </b> </a>

    <a class="btn btn-lg btn-info" href="<?php echo base_url('admin/get_empty_db/tbl_kandidat') ?>" >
    <i class="fa fa-male"> </i> <i class="fa fa-male"> </i>
    <b> Tabel Kandidat </b> </a>

    <a class="btn btn-lg btn-success" href="<?php echo base_url('admin/get_empty_db/tbl_hasil') ?>">
    <i class="fa fa-th"> </i>
   <b> Tabel Hasil </b> </a>
    </h1>

     <?php if ($msg){
     echo '<div class = "callout callout-success">
     <h4>' .$msg.   '</h4> </div>'; } ;?>