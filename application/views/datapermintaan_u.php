<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Data Kendaraan</h3>
                        <div class="text-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_barang" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title ">View Kendaraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="md_def">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
            "url": "<?php echo site_url('datapermintaan_u/ajax_list') ?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [{
                "targets": [-1], //last column
                "render": function(data, type, row) {

                    return "<a class=\"btn btn-xs btn-outline-danger delete\" href=\"javascript:void(0)\" title=\"Delete\" nama=" +
                        row[0] + "  onclick=\"delpn(" + row[7] +
                        ")\"><i class=\"fas fa-trash\"></i></a>";

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

//delete
function delpn(id_permintaan) {

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
                url: "<?php echo site_url('datapermintaan_u/delete'); ?>",
                type: "POST",
                data: "id_permintaan=" + id_permintaan,
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

</script>