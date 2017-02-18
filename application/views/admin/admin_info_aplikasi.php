<?php
if($isi){
 foreach($isi as $hasil){
    $id= $hasil->id;
    $periode = $hasil->periode;
    $tahun_pemilihan = $hasil->tahun_pemilihan;
    $nama_sekolah = $hasil->nama_sekolah;
    $mulai = $hasil->mulai_pemilihan;
    $selesai = $hasil->selesai_pemilihan;
    $kop_surat = $hasil->kop_surat;
    }
}
    else {
    $id='';    
    $periode = '';
    $tahun_pemilihan = '';
    $nama_sekolah = '';
    $mulai = '';
    $selesai = '';
    $kop_surat = '';
    }

 ?>

<div class="box box-default">

	<div class="box-header with-border">
	<i class="fa fa-gear"> </i>
	<h3 class="box-title">Form Pengaturan Informasi Aplikasi </h3>
	</div>
	<div class="box-body">

    <div>
        <?php 
           $info = $this->session->flashdata('msg_info');
            if ($info){
            echo $info;
        }
         ?>
        
    </div>
		<form method="post" action="<?php echo base_url('admin/update_info');?>" id="form" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-body">
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label class="control-label col-md-3">Periode</label>
                            <div class="col-md-9">
                                <input name="periode" placeholder="Periode Pemilihan (cth; 2016-2017)" class="form-control" type="text" value="<?php echo $periode; ?>">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tahun Pemilihan</label>
                            <div class="col-md-9">
                                <input name="tahun_pemilihan" placeholder="Tahun Pemilihan (cth; 2016)" class="form-control" type="number" value="<?php echo $tahun_pemilihan; ?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Sekolah</label>
                            <div class="col-md-9">
                                <input name="nama_sekolah" placeholder="Nama Sekolah (cth; Yayasan Pendidikan Indah Mulia)" class="form-control" type="text" value="<?php echo $nama_sekolah; ?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Waktu Mulai Pemilihan</label>
                            <div class="col-md-9" >
                                <div class='input-group date' id='datetimepicker' name="mulai_pemilihan" >
                                <input type='text' name="mulai_pemilihan" value="<?php echo $mulai ?>" class="form-control" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>

                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Waktu Selesai Pemilihan</label>
                            <div class="col-md-9" >
                                <div class='input-group date' id='datetimepicker1' name="selesai_pemilihan">
                                <input type='text' name="selesai_pemilihan" value="<?php echo $selesai ?>" class="form-control" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Logo/Kop Surat</label>
                            <div class="col-md-9">
                                <input name="kop_surat" class="form-control" type="file" value="<?php echo $kop_surat; ?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <?php if($kop_surat){
                            echo '<div class="form-group">
                            <label class="control-label col-md-3">Preview Logo/Kop Surat</label>
                            <div class="col-md-9">
                                <img src="'.base_url().'uploads/'.$kop_surat.'" style="height:100px;width:300px;"/>
                                </div>
                                
                                <div class="checkbox col-md-9 col-md-offset-3">
                                <label class="control-label">
                                
                                <input type="checkbox" name="remove_kop" value="'  .$kop_surat.'"/>
                                Centang untuk menghapus logo/kop surat</label>
                                </div>
                            
                        </div>';
                            } ?>



					</div>
				<div class="box-footer">
				<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
		</form>                
	</div>
</div> 

<script type="text/javascript">
            $(function () {
                $('#datetimepicker , #datetimepicker1').datetimepicker({format: 'YYYY-MM-DD h:m:s'});
                
            });
        </script>
