<?php if ($msg){
     echo '<div class = "callout callout-success">
     <h4>' .$msg.   '</h4> </div>'; } ;?>

 <form action="<?php echo base_url('admin/change_pass'); ?>" id="form" method="post"  class="form-horizontal">
                   
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-2">Sandi Baru</label>
                            <div class="col-md-6">
                                <input name="new_pass" id="new_pass" placeholder="Sandi Baru"  class="form-control" type="password">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-4">
                            <button type="submit" id="submit" name="submit" value="password" class="btn btn-primary" >Submit</button>
                            </div
                        </div>
                        
</form>