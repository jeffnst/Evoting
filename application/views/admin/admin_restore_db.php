 
 
 <?php if ($msg){
     echo '<div class = "callout callout-success">
     <h4>' .$msg.   '</h4> </div>'; } ;?>

 <form action="<?php echo base_url('admin/get_restore'); ?>" id="form" method="post" enctype="multipart/form-data" class="form-horizontal">
                   
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-2">Pilih File</label>
                            <div class="col-md-6">
                                <input name="file" id="file" placeholder="Pilih file"  class="form-control" type="file">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-4">
                            <button type="submit" id="submit" name="submit" value="upload" class="btn btn-primary" >Submit</button>
                            </div
                        </div>
                        
</form>