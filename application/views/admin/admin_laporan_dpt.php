<!DOCTYPE html>
<html>
<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_dpt.xls");
?>
<table>
<tr >
	<td rowspan="3"> <img src="<?php echo base_url()?>/uploads/kop_surat.png">
	</td>
</tr>
</table>
<br>
 <table id="tabel_dpt" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>KELAS</th>
                      
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      <?php
		$no=1;
		foreach ($lap_dpt->result() as $row ) {		?>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row->nis ;?></td>
                        <td><?php echo $row->nama ;?></td>
                        <td><?php echo $row->kelas ;?></td>
                        
                      </tr>
                     <?php } ;?>
                    </tbody>
                    
                  </table>