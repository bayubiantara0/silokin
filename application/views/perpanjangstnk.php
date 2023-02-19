<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Surat Perpanjangan STNK</h3>
                        <div class="text-right">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="tbl_barang" class="table table-bordered table-striped table-hover">
                    <form action="<?php echo base_url('cetakstnkmotor') ?>" id="form" class="form-horizontal" method="post">
                    <input type="hidden" value="" name="id" />
                    <label class="card-tittle"><i></i> Pilih Tanggal Pajak Kendaraan Motor</label><br>
                    <div class="card-body">

                        <div class="form-group row ">

                            <label for="nama" class="col-sm-3 col-form-label">Dari Tanggal</label>
                            <div class="col-sm-9 kosong">
                            <input type="date" class="form-control" name="tgl_a" required>
                            </div>
                        </div>
                        <div class="form-group row ">

                            <label for="nama" class="col-sm-3 col-form-label">Sampai Tanggal</label>
                            <div class="col-sm-9 kosong">
                            <input type="date" class="form-control" name="tgl_b" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                        <button class="btn btn-primary" type="submit" name="surat">
                            <i class="fa fa-print"></i> Cetak Surat
                        </button>
                </div>
                    </div>
                </form>
                <form action="<?php echo base_url('cetakstnkmobil') ?>" id="form" class="form-horizontal" method="post">
                    <input type="hidden" value="" name="id" />
                    <div class="card-body">
                    <label align="center" class="card-tittle"><i></i> Pilih Tanggal Pajak Kendaraan Mobil</label><br>
                        <div class="form-group row ">

                            <label for="nama" class="col-sm-3 col-form-label">Dari Tanggal</label>
                            <div class="col-sm-9 kosong">
                            <input type="date" class="form-control" name="tgl_a" required>
                            </div>
                        </div>
                        <div class="form-group row ">

                            <label for="nama" class="col-sm-3 col-form-label">Sampai Tanggal</label>
                            <div class="col-sm-9 kosong">
                            <input type="date" class="form-control" name="tgl_b" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                        <button class="btn btn-primary" type="submit" name="surat">
                            <i class="fa fa-print"></i> Cetak Surat
                        </button>
                </div>
                    </div>
                </form>
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
