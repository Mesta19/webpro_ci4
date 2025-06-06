
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data Buku</li>
            <li class="active">Edit Data Buku</li>
        </ol>
    </div><h3>Edit Buku</h3>
<hr />
        <form action="<?php echo base_url('buku/update');?>" method="post" enctype="multipart/form-data">
            <div class="form-group col-md-6">
                <label>Judul Buku</label>
                <input type="text" class="form-control" name="judul_buku" placeholder="Masukkan Judul Buku" value="<?= $data_buku['judul_buku'];?>" required="required">
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-6">
                <label>Pengarang</label>
                <input type="text" class="form-control" name="pengarang" placeholder="Masukkan Nama Pengarang" value="<?= $data_buku['pengarang'];?>" required="required">
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-6">
                <label>Penerbit</label>
                <input type="text" class="form-control" name="penerbit" placeholder="Masukkan Nama Penerbit" value="<?= $data_buku['penerbit'];?>" required="required">
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-3">
                <label>Tahun Terbit</label>
                <input type="number" class="form-control" name="tahun" placeholder="Contoh: 2023" value="<?= $data_buku['tahun'];?>" required="required">
            </div>
            <div class="form-group col-md-3">
                <label>Jumlah Eksemplar</label>
                <input type="number" class="form-control" name="jumlah_eksemplar" placeholder="Masukkan Jumlah Eksemplar" value="<?= $data_buku['jumlah_eksemplar'];?>" required="required">
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-6">
                <label>Kategori</label>
                <select class="form-control" name="id_kategori" required="required">
                    <option value="">--- Pilih Kategori ---</option>
                    <?php foreach($kategori as $kat): ?>
                        <option value="<?= $kat['id_kategori']; ?>" <?= ($data_buku['id_kategori'] == $kat['id_kategori']) ? 'selected' : ''; ?>><?= $kat['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-6">
                <label>Rak</label>
                <select class="form-control" name="id_rak" required="required">
                    <option value="">--- Pilih Rak ---</option>
                    <?php foreach($rak as $r): ?>
                        <option value="<?= $r['id_rak']; ?>" <?= ($data_buku['id_rak'] == $r['id_rak']) ? 'selected' : ''; ?>><?= $r['nama_rak']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-6">
                <label>Keterangan</label>
                <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan"><?= $data_buku['keterangan'];?></textarea>
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-6">
                <label>Cover Buku (Opsional)</label>
                <?php if (!empty($data_buku['cover_buku'])): ?>
                    <img src="<?= base_url('public/uploads/cover_buku/' . $data_buku['cover_buku']); ?>" alt="Cover Buku" width="100">
                    <br>
                <?php endif; ?>
                <input type="file" class="form-control" name="cover_buku" accept="image/*">
                <small class="text-muted">Pilih gambar baru untuk mengganti cover yang ada.</small>
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-6">
                <label>E-book (Opsional)</label>
                <input type="text" class="form-control" name="e_book" placeholder="Link E-book" value="<?= $data_buku['e_book'];?>">
            </div>
            <div style="clear:both;"></div>

            <div class="form-group col-md-6">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?php echo base_url('buku');?>"><button type="button" class="btn btn-danger">Batal</button></a>
            </div>
            <div style="clear:both;"></div>
</form>