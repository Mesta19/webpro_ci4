<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
 <div class="row">
   <ol class="breadcrumb">
     <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
     <li>Master Data Anggota</li>
     <li class="active">Input Data Anggota</li>
   </ol>
 </div>
 
 <div class="row">
   <div class="col-md-12">
     <div class="panel panel-default">
       <div class="panel-body">
         <h3>Input Anggota</h3>
         <hr />
         <form action="<?php echo base_url('anggota/simpan-anggota');?>" method="post">
           <div class="form-group col-md-6">
             <label>Nama Anggota</label>
             <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Anggota" required="required">
           </div>
           <div style="clear:both;"></div>

          <div class="form-group col-md-6">
          <label>Password Anggota</label>
          <input type="password" class="form-control" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',this)" name="passwordAnggota" placeholder="Masukkan Password Anggota" required="required">
          </div>
          <div style="clear:both;"></div>

           <div class="form-group col-md-6">
             <label>Nomor Telepon</label>
             <input type="text" class="form-control" name="no_tlp" id="no_tlp" placeholder="Masukkan Nomor telepon Anggota" required="required" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
           </div>
           <div style="clear:both;"></div>

           <div class="form-group col-md-6">
             <label>Email Anggota</label>
             <input type="email" class="form-control" name="email" placeholder="Masukkan Email Anggota" required="required" oninvalid="this.setCustomValidity('Email harus mengandung @ dan format valid!')" oninput="setCustomValidity('')">
           </div>
           <div style="clear:both;"></div>
           <div class="form-group col-md-6">
             <label>Alamat</label>
             <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat Anggota" required="required">
           </div>
           <div style="clear:both;"></div>
<div class="form-group col-md-6">
 <label>Jenis Kelamin</label>
 <select class="form-control" name="jenis_kelamin" required="required">
   <option value="">--- Pilih ---</option>
   <option value="L">Laki-laki</option>
   <option value="P">Perempuan</option>
 </select>
</div>
<div style="clear:both;"></div>

<div class="form-group col-md-6">
 <button type="submit" class="btn btn-primary">Simpan</button>
 <button type="reset" class="btn btn-danger">Batal</button>
</div>
<div style="clear:both;"></div>
</form>
   </div>
 </div>
</div>
</div>

</div>
<script>
// Jika ingin mencegah paste karakter non-angka juga:
document.addEventListener('DOMContentLoaded', function() {
  var noTlp = document.getElementById('no_tlp');
  if(noTlp) {
    noTlp.addEventListener('paste', function(e) {
      var paste = (e.clipboardData || window.clipboardData).getData('text');
      if(/\D/.test(paste)) {
        e.preventDefault();
      }
    });
  }
});
</script>