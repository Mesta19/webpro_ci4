<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
      <li>Master Data Kategori</li>
      <li class="active">Edit Data Kategori</li>
    </ol>
  </div>

  <h3>Edit Kategori</h3>
  <hr />
  <form action="<?= base_url('kategori/update');?>" method="post">
    <input type="hidden" name="id_kategori" value="<?= esc($data_kategori['id_kategori']);?>">
    <div class="form-group col-md-6">
      <label>Nama Kategori</label>
      <input type="text" name="nama_kategori" class="form-control"
             value="<?= esc($data_kategori['nama_kategori']); ?>"
             placeholder="Masukkan Nama Kategori" required>
    </div>
    <div style="clear:both;"></div>
    <div class="form-group col-md-6">
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="<?= base_url('kategori');?>" class="btn btn-danger">Batal</a>
    </div>
    <div style="clear:both;"></div>
  </form>
</div>
