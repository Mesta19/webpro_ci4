<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Laporan</li>
            <li class="active">Laporan Pengembalian</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Laporan Pengembalian</h3>
                    <hr />
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Pengembalian</th>
                                <th>No Peminjaman</th>
                                <th>Tanggal Kembali</th>
                                <th>Denda</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($dataPengembalian) && is_array($dataPengembalian)): $no=1; foreach($dataPengembalian as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['no_pengembalian']); ?></td>
                                <td><?= htmlspecialchars($row['no_peminjaman']); ?></td>
                                <td><?= htmlspecialchars($row['tgl_pengembalian']); ?></td>
                                <td><?= htmlspecialchars($row['denda']); ?></td>
                                <td><?= htmlspecialchars($row['id_admin']); ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
