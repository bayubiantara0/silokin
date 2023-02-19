<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Data Permintaan</h3>
                        <div class="text-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_barang" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>No</th>
                                    <th>Nama Bidang</th>
                                    <th>Permintaan Surat</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Diajukan</th>
                                    <th>Status Permintaan</th>
                                    <th>Alasan Verifikasi</th>
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
    table = $("#tbl_barang").DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "sEmptyTable": "Data Permintaan Belum Ada"
        },
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('datapermintaan_a/ajax_list') ?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [{
                "targets": [-1], //last column
                "render": function(data, type, row) {
                    if (row[5] == 1) {
                        return "<a class=\"btn btn-xs btn-success\" href=\"javascript:void(0)\" title=\"Setuju\" onclick=\"vsetuju(" + row[7] +
                        ")\"><i class='fa fa-check' aria-hidden='true'></i></a> <a class=\"btn btn-xs btn-danger\" href=\"javascript:void(0)\" title=\"Tolak\" onclick=\"vtolak(" + row[7] +
                        ")\"><i class='fa fa-times' aria-hidden='true'></i</a>"
                    } else if (row[5] == 2) {
                        return "<a style=\"font-size:10;\" class=\"btn btn-xs btn-success\" href=\"javascript:void(0)\" title=\"Telah Disetujui\">Disetujui</a>"
                    } else if (row[5] == 3) {
                        return "<a style=\"font-size:10;\" class=\"btn btn-xs btn-danger\" href=\"javascript:void(0)\" title=\"Telah Ditolak\">Ditolak</a>"
                    };

                },

                "orderable": false, //set not orderable
            },
            {
            "targets" : [5],
            "render" : function (data, type, row) {
              if (row[5] == 1) {
                return "<a class=\"btn btn-xs btn-info\" href=\"javascript:void(0)\" title=\"Menunggu Konfirmasi\">Menunggu Konfirmasi</a>"
                } else if (row[5] == 2) {
                    return "<a class=\"btn btn-xs btn-success\" href=\"javascript:void(0)\" title=\"Permintaan Diterima\">Permintaan Diterima</a>"
                    } else if (row[5] == 3) {
                        return "<a class=\"btn btn-xs btn btn-danger\" href=\"javascript:void(0)\" title=\"Permintaan Ditolak\">Permintaan Ditolak</a>"
                        };

            },

          },
          {
            "targets" : [6],
            "render" : function (data, type, row) {
              if (row[6] == null) {
                return "<a class=\"btn btn-xs btn-warning\" href=\"javascript:void(0)\" title=\"Menunggu Proses\">Menunggu Proses</a>"
                } else {
                    return row[6]
                    };

          },
          },
        ],
    });

    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function() {
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
        $(this).removeClass('is-invalid');
    });
    $("textarea").change(function() {
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
        $(this).removeClass('is-invalid');
    });
    $("select").change(function() {
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
        $(this).removeClass('is-invalid');
    });

});

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

function vsetuju(id_permintaan) {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url: "<?php echo site_url('datapermintaan_a/ambilsetuju') ?>/" + id_permintaan,
        type: "GET",
        dataType: "JSON",
        success: function(data) {

            $('[name="id_permintaan"]').val(data.id_permintaan);
            $('[name="keterangan"]').val(data.alasan_verifikasi);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Apakah kamu yakin ingin Menyetujui Permintaan ini?'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function vtolak(id_permintaan) {
    save_method = 'approvv';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url: "<?php echo site_url('datapermintaan_a/ambilsetuju') ?>/" + id_permintaan,
        type: "GET",
        dataType: "JSON",
        success: function(data) {

            $('[name="id_permintaan"]').val(data.id_permintaan);
            $('[name="keterangan"]').val(data.alasan_verifikasi);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Apakah kamu yakin ingin Menolak Permintaan ini?'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function save()
  {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;

    if(save_method == 'add') {
      url = "<?php echo site_url('datapermintaan_a/updatesetuju') ?>";
    } else {
      url = "<?php echo site_url('datapermintaan_a/updatetolak') ?>";
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
              Toast.fire({
                icon: 'success',
                title: 'Permintaan Telah Diperbaharui'
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">

            <div class="modal-header">
                <h3 class="modal-title">Persetujuan Permintaan</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_permintaan" id="id_permintaan" />
                    <div class="card-body">
                        <div class="form-group row ">
                            <label for="nama" class="col-sm-3 col-form-label">Alasan</label>
                            <div class="col-sm-9 kosong">
                                <textarea class="form-control" name="keterangan" id="keterangan"
                                    placeholder="Alasan" rows="4"></textarea>
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