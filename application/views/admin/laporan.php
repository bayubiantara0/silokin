
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-light">
                <h3 class="card-title"><i class="fa fa-list text-blue"></i> Data Laporan</h3>
                <div class="text-right">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_lpr()"
                        title="Add Kendaraan"><i class="fas fa-plus"></i> Add</button>
                        <a href="<?php echo base_url('cetaklaporan') ?>"><button class="btn btn-sm btn-outline-primary" type="button"><i class="fas fa-print"></i> 
                        Cetak Laporan</button></a>
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                        data-toggle="dropdown">
                        <i class="fas fa-print"></i> Cetak
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <a href="<?php echo base_url('cetakperawatan') ?>" class="btn btn-sm btn-outline-primary"
                                    id="perawatan" target="_blank" title="Cetak Laporan Perawatan"><i class="fas fa-download"></i>
                                    Cetak Laporan Perawatan</a><br>
                                <a href="<?php echo base_url('cetakpajak') ?>" class="btn btn-sm btn-outline-primary"
                                    id="pajak" target="_blank" title="Cetak Laporan Pajak dan STNK"><i class="fas fa-download"></i>
                                    Cetak Laporan Pajak dan STNK</a>
                            </ul>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabelsubmenu" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr class="bg-info">
                    <th>Jenis Dokumen</th>
                    <th>Nomor Polisi</th>
                    <th>Asal Dokumen</th>
                    <th>Tanggal Dokumen </th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>







<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table =$("#tabelsubmenu").DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
        "sEmptyTable": "Data Laporan Belum Ada"
        },
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('laporan/ajax_list') ?>",
            "type": "POST"
        },
         //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "render": function ( data, type, row ) {

                 return "<a class=\"btn btn-xs btn-outline-primary print\" href=\"javascript:void(0)\" title=\"Cetak\" nama=" +
                        row[0] + "  onclick=\"cetak(" + row[5] +
                        ")\"><i class=\"fas fa-print\"></i></a> <a class=\"btn btn-xs btn-outline-danger delete\" href=\"javascript:void(0)\" title=\"Delete\" nama=" +
                        row[0] + "  onclick=\"dellpr(" + row[5] +
                        ")\"><i class=\"fas fa-trash\"></i></a>";

            },

            "orderable": false, //set not orderable
        },
        {
            "targets": [ 4 ], //last column
            "render": function ( data, type, row ) {

                 return "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" nama=" +
                        row[0] + " onclick=\"downloadlpr(" +row[5] +")\">"+ row[4] +"</a>";
            },

            "orderable": false, //set not orderable
        },
        ],
      });

 //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
        $(this).removeClass('is-invalid');
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
        $(this).removeClass('is-invalid');
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
        $(this).removeClass('is-invalid');
    });

});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });


    function dellpr(id) {

Swal.fire({
    title: 'Apa kamu yakin?',
    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus ini!',
}).then((result) => {
    if (result.value) {
        $.ajax({
            url: "<?php echo site_url('laporan/delete'); ?>",
            type: "POST",
            data: "id=" + id,
            cache: false,
            dataType: 'json',
            success: function(data) {
                reload_table()
                Swal.fire(
                    'Hapus',
                    'Berhasil Terhapus',
                    'success'
                )

            }
        });
    } else if (result.dismiss === swal.DismissReason.cancel) {
        Swal.fire(
            'Batal',
            'Anda membatalkan penghapusan',
            'error'
        )
    }
})
}

//view
function downloadlpr(id) {
    $.ajax({
      url:"<?php echo site_url('laporan/download'); ?>",
        type:"POST",
      data:"id="+id,
      cache:false,
      dataType: 'json',
      success: function(respon) {
            $("#md_def").html(respon);
        }
    })
}

function cetak(id) {
    $.ajax({
      url:"<?php echo base_url('Cetakrowlaporan') ?>",
        type:"POST",
      data:"id="+id,
      cache:false,
      dataType: 'json',
      success: function(respon) {
            $("#md_def").html(respon);
        }
    })
}

function add_lpr() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal({
        backdrop: 'static',
        keyboard: false
    }); // show bootstrap modal
    $('.modal-title').text('Add Laporan'); // Set Title to Bootstrap modal title
}

function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url = "<?php echo site_url('laporan/insert') ?>";
    var formdata = new FormData($('#form')[0]);
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formdata,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
                Toast.fire({
                  icon: 'success',
                  title: 'Success!!.'
                });
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').addClass('is-invalid');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]).addClass('invalid-feedback');
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


</script>



<!-- Bootstrap modal -->

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
              <h3 class="modal-title">Person Form</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>

            </div>
            <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="" name="id"/>
           <div class="card-body">
			<div class="form-group row ">
            <label for="nama_laporan" class="col-sm-3 col-form-label">Jenis Dokumen</label>
            <div class="col-sm-9 kosong">
            <select class="form-control" name="lampiran" id="lampiran" required>
                                <option value="">- Pilih -</option>
                <option value="Surat Perawatan Kendaraan">Surat Perawatan Kendaraan</option>
                <option value="Surat Pajak dan STNK">Surat Pajak dan STNK</option>
                </select>
            </div>
          </div>
          <div class="form-group row ">
                            <label for="nama" class="col-sm-3 col-form-label">Nomor Polisi</label>
                            <div class="col-sm-9 kosong">
                            <select class="form-control" name="nmr_polisi" id="nmr_polisi" required>
        <option value="">- Pilih -</option>
        <?php foreach ($kendaraan as $row): ?>
                    <option value="<?php echo $row->nomor_polisi; ?>"><?php echo $row->nomor_polisi; ?> - <?php echo $row->merk; ?></option>
                    <?php endforeach;?>
                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
          <div class="form-group row ">
            <label for="nama_owner" class="col-sm-3 col-form-label">Asal Dokumen</label>
            <div class="col-sm-9 kosong">
              <input type="text" class="form-control"  name="perujuk" id="perujuk" placeholder="Asal Dokumen" >
              <span class="help-block"></span>
            </div>
          </div>
          <div class="form-group row ">
            <label for="alamat" class="col-sm-3 col-form-label">Tanggal Dokumen</label>
            <div class="col-sm-9 kosong">
              <input type="date" class="form-control" name="masuk" id="masuk" placeholder="Tanggal Dokumen" >
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row ">
            <label for="logo" class="col-sm-3 col-form-label">Dokumen</label>
            <div class="col-sm-9 kosong">
              <input type="file" class="form-control btn-file" name="berkas" id="berkas" placeholder="Dokumen" value="UPLOAD">
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
