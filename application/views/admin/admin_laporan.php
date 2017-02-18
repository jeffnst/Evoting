

<div class="box box-default">

  <div class="box-header with-border">
  <i class="fa fa-bar-chart"> </i>
  <h5 class="box-title">Laporan Hasil Pemilihan Ketua OSIS  
  <?php if($nama_sekolah){
    echo $nama_sekolah.' '; }
    if($tahun_pemilihan){ 
      echo $tahun_pemilihan; } ;?> </h5>
  </div>
  <div class="box-body">



<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Laporan</th>
                    <th colspan="2" style="width:200px;">Format</th>
                    
                </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width:10px;">1</td>
                <td>Daftar Pemilih Tetap (DPT)</td>
                <td style="width:50px;"> <a href= "<?php echo base_url('admin/lapdpt'); ?> "><button class="btn btn-xs btn-success"><i class="fa fa-file-excel-o"></i> <b>XLS </b> </button> </a> </td>
                <td style="width:50px;"><a href= "<?php echo base_url('admin/lapdptpdf'); ?> "> <button class="btn btn-xs btn-danger"><i class="fa fa-file-pdf-o "></i> <b>PDF</b> </button></a></td>
            </tr>
            <tr>
                <td style="width:10px;">2</td>
                <td>Data Pasangan Calon </td>
                <td style="width:50px;"> <a href= "<?php echo base_url('admin/lapkandidat'); ?> "> <button class="btn btn-xs btn-success"><i class="fa fa-file-excel-o"></i> <b>XLS </b> </button> </a> </td>
                <td style="width:50px;"><a href= "<?php echo base_url('admin/lapkandidatpdf'); ?> ">  <button class="btn btn-xs btn-danger"><i class="fa fa-file-pdf-o "></i> <b>PDF</b> </button></a></td>
            </tr>

            <tr>
                <td style="width:10px;">3</td>
                <td>Data Hasil Perolehan Suara </td>
                <td style="width:50px;"> <a href= "<?php echo base_url('admin/laphasil'); ?> "><button class="btn btn-xs btn-success"><i class="fa fa-file-excel-o"></i> <b>XLS </b> </button> </a> </td>
                <td style="width:50px;"> <a href= "<?php echo base_url('admin/laphasilpdf'); ?> "><button class="btn btn-xs btn-danger"><i class="fa fa-file-pdf-o "></i> <b>PDF</b> </button></a></td>
            </tr>
            </tbody>

            
        </table>
</div>
</div>