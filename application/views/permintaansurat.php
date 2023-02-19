<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Form Permintaan Surat</h3>
                        <div class="text-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_barang" class="table table-bordered table-striped table-hover">
                            <thead>
                            <form action="<?php echo base_url('permintaansurat/proses_permintaan') ?>" method="POST" enctype="multipart/form-data">
                        <input type="text" value="<?php echo $this->session->userdata('id_user') ?>" name="id_user" hidden>
                        <div class="form-group">
                            <label for="perihal_permintaan">Permintaan Surat</label>
                            <select class="form-control" name="permintaan" id="permintaan" required>
                                <option value="">- Pilih -</option>
                <option value="Surat Perawatan Kendaraan">Surat Perawatan Kendaraan</option>
                <option value="Surat Perpanjangan STNK">Surat Perpanjangan STNK</option>
                </select>
                        </div>
                        <div class="form-group">
                            <label for="alasan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" rows="3" name="keterangan" required></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit" name="submit" id="submit">
                        <i class=""></i> Submit
                    </button>
                    </form>
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
