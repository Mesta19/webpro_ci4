<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
      <li class="active">Master Data Kategori</li>
    </ol>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>
            Master Data Kategori
            <a href="<?= base_url('kategori/input');?>">
              <button class="btn btn-sm btn-primary pull-right">Input Data Kategori</button>
            </a>
          </h3>
          <hr />
          <table data-toggle="table" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach($data_kategori as $row): ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= esc($row['nama_kategori']); ?></td>
                <td>
                  <a href="<?= base_url('kategori/edit/'.sha1($row['id_kategori']));?>">
                    <button class="btn btn-sm btn-success">Edit</button>
                  </a>
                  <a href="#" onclick="doDelete('<?= sha1($row['id_kategori']);?>')">
                    <button class="btn btn-sm btn-danger">Hapus</button>
                  </a>
                </td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function doDelete(id){
  swal({
    title: "Hapus Kategori?",
    text: "Data akan terhapus permanen!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then(ok => {
    if(ok){
      window.location.href = '<?= base_url('kategori/delete/');?>'+id;
    }
  });
}
</script>
