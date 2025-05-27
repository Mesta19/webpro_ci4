<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
      <li>Master Data Rak</li>
      <li class="active">Input Data Rak</li>
    </ol>
  </div>

  <h3>Input Rak</h3>
  <hr />
  <form action="<?= base_url('rak/save');?>" method="post">
    <div class="form-group col-md-6">
      <label>Nama Rak</label>
      <input type="text" name="nama_rak" class="form-control" placeholder="Masukkan Nama Rak" required>
    </div>
    <div style="clear:both;"></div>
    <div class="form-group col-md-6">
      <button class="btn btn-primary">Simpan</button>
      <a href="<?= base_url('rak');?>" class="btn btn-danger">Batal</a>
    </div>
    <div style="clear:both;"></div>
  </form>
</div>
