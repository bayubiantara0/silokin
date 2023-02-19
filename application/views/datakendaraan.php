<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Data Kendaraan</h3>
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_brg()"
                                title="Add Kendaraan"><i class="fas fa-plus"></i> Add</button>
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                data-toggle="dropdown">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <a href="<?php echo base_url('cetakmotor') ?>" class="btn btn-sm btn-outline-primary"
                                    id="ctk_motor" target="_blank" title="Cetak Motor"><i class="fas fa-download"></i>
                                    Cetak Motor</a><br>
                                <a href="<?php echo base_url('cetakmobil') ?>" class="btn btn-sm btn-outline-primary"
                                    id="ctk_mobil" target="_blank" title="Cetak Mobil"><i class="fas fa-download"></i>
                                    Cetak Mobil</a>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_barang" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>Jenis Kendaraan</th>
                                    <th>Merk</th>
                                    <th>Type</th>
                                    <th>Tahun Penerbitan</th>
                                    <th>Nomor Polisi</th>
                                    <th>Nomor Rangka</th>
                                    <th>Pemegang</th>
                                    <th>No Berita Acara</th>
                                    <th>STNK</th>
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
            "sEmptyTable": "Data Kendaraan Belum Ada"
        },
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('datakendaraan/ajax_list') ?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [{
                "targets": [-1], //last column
                "render": function(data, type, row) {

                    return "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" onclick=\"vkendaraan(" +
                        row[9] +
                        ")\"><i class=\"fas fa-eye\"></i></a><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit_brg(" +
                        row[9] +
                        ")\"><i class=\"fas fa-edit\"></i></a><a class=\"btn btn-xs btn-outline-danger delete\" href=\"javascript:void(0)\" title=\"Delete\" nama=" +
                        row[0] + "  onclick=\"delbrg(" + row[9] +
                        ")\"><i class=\"fas fa-trash\"></i></a>";

                },

                "orderable": false, //set not orderable
            },
            {
            "targets": [ 8 ], //last column
            "render": function ( data, type, row ) {

                 return "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" nama=" +
                        row[0] + " onclick=\"downloadlpr(" +row[9] +")\">"+ row[8] +"</a>";
            },

            "orderable": false, //set not orderable
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
//view
function vkendaraan(id) {
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('.modal-title').text('View Kendaraan');
    $("#modal-default").modal('show');
    $.ajax({
        url: '<?php echo base_url('datakendaraan/viewkendaraan '); ?>',
        type: 'post',
        data: 'table=kendaraan&id=' + id,
        success: function(respon) {
            $("#md_def").html(respon);
        }
    })
}
//download
function downloadlpr(id) {
    $.ajax({
      url:"<?php echo site_url('datakendaraan/download'); ?>",
        type:"POST",
      data:"id="+id,
      cache:false,
      dataType: 'json',
      success: function(respon) {
            $("#md_def").html(respon);
        }
    })
}
//delete
function delbrg(id) {

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
                url: "<?php echo site_url('datakendaraan/delete'); ?>",
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


function add_brg() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal({
        backdrop: 'static',
        keyboard: false
    }); // show bootstrap modal
    $('.modal-title').text('Add Kendaraan'); // Set Title to Bootstrap modal title
}

function edit_brg(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url: "<?php echo site_url('datakendaraan/edit_barang') ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {

            $('[name="id"]').val(data.id);
            $('[name="jenis"]').val(data.jenis_kendaraan);
            $('[name="merk"]').val(data.merk);
            $('[name="type"]').val(data.tipe);
            $('[name="tahun"]').val(data.tahun_penerbitan);
            $('[name="warna"]').val(data.warna);
            $('[name="nopol"]').val(data.nomor_polisi);
            $('[name="nomor"]').val(data.no_rangka);
            $('[name="bahan"]').val(data.bahan_bakar);
            $('[name="pemegang"]').val(data.pemilik);
            $('[name="berita"]').val(data.berita);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Kendaraan'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable
    if (save_method == 'add') {
        var url = "<?php echo site_url('datakendaraan/insert') ?>";
        var formdata = new FormData($('#form')[0]);
    } else {
        var url = "<?php echo site_url('datakendaraan/update') ?>";
        var formdata = new FormData($('#form')[0]);
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formdata,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {

            if (data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
                Toast.fire({
                    icon: 'success',
                    title: 'Success!!.'
                });
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass(
                        'invalid-feedback');
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable


        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable

        }
    });
}
</script>



<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="card-body">
                        <div class="form-group row ">
                            <label for="nama" class="col-sm-3 col-form-label">Jenis Kendaraan</label>
                            <div class="col-sm-9 kosong">
                            <select class="form-control" name="jenis" id="jenis" required>
        <option value="">- Pilih -</option>
                    <option value="Motor">Motor</option>
                    <option value="Mobil">Mobil</option>
                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama_owner" class="col-sm-3 col-form-label">Merk</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="merk" id="merk" placeholder="Merk">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="alamat" class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="type" id="type" placeholder="Type">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama" class="col-sm-3 col-form-label">Tahun Penerbitan</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="tahun" id="tahun"
                                    placeholder="Tahun Penerbitan">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama_owner" class="col-sm-3 col-form-label">Warna</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="warna" id="warna" placeholder="Warna">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="alamat" class="col-sm-3 col-form-label">Nomor Polisi</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="nopol" id="nopol"
                                    placeholder="Nomor Polisi">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama" class="col-sm-3 col-form-label">Nomor Rangka</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="nomor" id="nomor"
                                    placeholder="Nomor Rangka">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama_owner" class="col-sm-3 col-form-label">Bahan Bakar</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="bahan" id="bahan"
                                    placeholder="Bahan Bakar">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="alamat" class="col-sm-3 col-form-label">Pemegang</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="pemegang" id="pemegang"
                                    placeholder="Pemegang">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="alamat" class="col-sm-3 col-form-label">No Berita Acara</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="berita" id="berita"
                                    placeholder="No Berita Acara">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="logo" class="col-sm-3 col-form-label">STNK</label>
                            <div class="col-sm-9 kosong">
                                <input type="file" class="form-control btn-file" name="stnk" id="stnk" placeholder="STNK" value="UPLOAD">
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