
    <h1 style="font-size:20pt">Data Pemilih Tetap Pemilihan Ketua OSIS 2016-2017</h1>

    <h3></h3>
    <br />
    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
    <button class="btn btn-primary" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
    <button class="btn btn-info" onclick="import_excel()"><i class=" fa fa-file-excel-o"></i> Import Excel</button>
    <a href= "<?php echo base_url('admin/export_excel') ?>" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> Export Excel</a>
    <br />
    <br />
    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>

                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th style="width:125px;">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>

        <tfoot>
        <tr>

          <th>NIS</th>
          <th>Nama</th>
          <th>Kelas</th>
          <th>Action</th>
        </tr>
        </tfoot>
    </table>



<script src="<?php echo base_url('aset/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('aset/plugins/datatables/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('aset/plugins/datepicker/bootstrap-datepicker.js')?>"></script>


<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

//datatables
table = $('#table').DataTable({

    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo site_url('admin/ajax_list');?>",
        "type": "POST"
    },

    //Set column definition initialisation properties.
    "columnDefs": [
    {
        "targets": [ -1 ], //last column
        "orderable": false, //set not orderable
    },
    ],

});




//set input/textarea/select event when change value, remove class error and remove text help block
$("input").change(function(){
    $(this).parent().parent().removeClass('has-error');
    $(this).next().empty();
});
$("textarea").change(function(){
    $(this).parent().parent().removeClass('has-error');
    $(this).next().empty();
});
$("select").change(function(){
    $(this).parent().parent().removeClass('has-error');
    $(this).next().empty();
});

});


function import_excel()
{

$('#excel')[0].reset(); // reset form on modals
$('.form-group').removeClass('has-error'); // clear error class

$('#modal_excel').modal('show'); // show bootstrap modal
$('.modal-title').text('import data'); // Set Title to Bootstrap modal title
}





function add_person()
{
save_method = 'add';
$('#form')[0].reset(); // reset form on modals
$('.form-group').removeClass('has-error'); // clear error class
$('.help-block').empty(); // clear error string
$('#modal_form').modal('show'); // show bootstrap modal
$('.modal-title').text('Tambah data'); // Set Title to Bootstrap modal title
}


function edit_person(id)
{
save_method = 'update';
$('#form')[0].reset(); // reset form on modals
$('.form-group').removeClass('has-error'); // clear error class
$('.help-block').empty(); // clear error string

//Ajax Load data from ajax
$.ajax({
    url : "<?php echo site_url('admin/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {

        $('[name="id"]').val(data.id);
        $('[name="nis"]').val(data.nis);
        $('[name="nama"]').val(data.nama);
        $('[name="kelas"]').val(data.kelas);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    }
});
}

function reload_table()
{
table.ajax.reload(null,false); //reload datatable ajax
}

function save()
{
$('#btnSave').text('saving...'); //change button text
$('#btnSave').attr('disabled',true); //set button disable
var url;

if(save_method == 'add') {
    url = "<?php echo site_url('admin/ajax_add')?>";
} else {
    url = "<?php echo site_url('admin/ajax_update')?>";
}

// ajax adding data to database
$.ajax({
    url : url,
    type: "POST",
    data: $('#form').serialize(),
    dataType: "JSON",
    success: function(data)
    {

        if(data.status) //if success close modal and reload ajax table
        {
            $('#modal_form').modal('hide');
            reload_table();
        }
        else
        {
            for (var i = 0; i < data.inputerror.length; i++)
            {
                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
            }
        }
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable


    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error adding / update data');
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable

    }
});
}

function delete_person(id)
{
if(confirm('Are you sure delete this data?'))
{
    // ajax delete data to database
    $.ajax({
        url : "<?php echo site_url('admin/ajax_delete')?>/"+id,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error deleting data');
        }
    });

}
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Form Data Pemilih</h3>
        </div>
        <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
                <input type="hidden" value="" name="id"/>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">NIS</label>
                        <div class="col-md-9">
                            <input name="nis" placeholder="nis Pemilih" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama</label>
                        <div class="col-md-9">
                            <input name="nama" placeholder="Nama Pemilih" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Kelas</label>
                        <div class="col-md-9">
                            <select name="kelas" class="form-control">
                                <option value="">--Pilih Kelas--</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>


                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


<!-- Bootstrap modal import excel -->
<div class="modal fade" id="modal_excel" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Import Data Pemilih</h3>
        </div>
        <div class="modal-body form">
            <form method="post" action="<?php echo site_url('admin/upload'); ?>" id="excel" name="file" class="form-horizontal" enctype="multipart/form-data">
              <input type="file" name="userfile" id="userfile"/>
              <input type="submit" value="submit" name="submit" id="submit"/>
        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
