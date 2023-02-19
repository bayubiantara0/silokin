<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Surat Perawatan Kendaraan</h3>
                        <div class="text-right">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="tbl_barang" class="table table-bordered table-striped table-hover">
                    <form action="<?php echo base_url('cetakpp') ?>" id="form" class="form-horizontal" method="post">
                    <input type="hidden" value="" name="id" />
                    <div class="card-body">
                        <div class="form-group row ">
                            <label for="nama" class="col-sm-3 col-form-label">Nomor Polisi</label>
                            <div class="col-sm-9 kosong">
        <select class="form-control" name="nmr_polisi" id="nmr_polisi" required>
        <option value="">- Pilih -</option>
        <?php foreach ($kendaraan as $row): ?>
                    <option value="<?php echo $row->nomor_polisi; ?>"><?php echo $row->nomor_polisi; ?> - <?php echo $row->merk; ?></option>
                    <?php endforeach;?>
                </select>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama_owner" class="col-sm-3 col-form-label">Tujuan Service</label>
                            <div class="col-sm-9 kosong">
                                <select class="form-control" name="service" id="service" required>
                                <option value="">- Pilih -</option>
        <?php foreach ($tujuan as $row): ?>
                    <option value="<?php echo $row->keterangan; ?>"><?php echo $row->keterangan; ?></option>
                    <?php endforeach;?>
                </select>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="alamat" class="col-sm-3 col-form-label">Jenis Perawatan</label>
                            <div class="col-sm-9 kosong">
                            <label><input type="checkbox" name="perawatan[]" value="Service/Tuneup">Service/Tuneup</label><br>
            <label><input type="checkbox" name="perawatan[]" value="Ganti Oli">Ganti Oli</label><br>
            <label><input type="checkbox" name="perawatan[]" value="Cek Kaki-Kaki">Cek Kaki-Kaki</label><br>
            <label><input type="checkbox" name="perawatan[]" value="Pengecekan Ban Depan/Belakang">Pengecekan Ban
                Depan/Belakang</label><br>
            <label><input type="checkbox" name="perawatan[]" value="Pengecekan Aki">Pengecekan Aki</label><br>
            <label><input type="checkbox" name="perawatan[]" value="Pengecekan Rantai">Pengecekan Rantai</label><br>
            <label><input type="checkbox" name="perawatan[]" value="Pengecekan Kupling">Pengecekan
                Kupling</label><br>
            <label><input type="checkbox" name="perawatan[]" value="Cek Karet Gir/Ganti">Cek Karet
                Gir/Ganti</label><br>
            <label><input type="checkbox" name="perawatan[]" value="Ganti Ban Dalam Belakang">Ganti Ban Dalam
                Belakang</label><br>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama_owner" class="col-sm-3 col-form-label">No Ketentuan</label>
                            <div class="col-sm-9 kosong">
                            <select name="no" id="service" class="form-control" required>
                            <option value="">- Pilih -</option>
        <?php foreach ($ketentuan as $row): ?>
                    <option value="<?php echo $row->keterangan; ?>"><?php echo $row->keterangan; ?></option>
                    <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </form>
                <tbody>
                            </tbody>
                            <div class="col-md-2">
                    <button class="btn btn-primary" type="submit" name="surat">
                        <i class="fa fa-print"></i> Cetak Surat
                    </button>
                </div>
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
