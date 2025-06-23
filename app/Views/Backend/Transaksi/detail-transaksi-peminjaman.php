<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Detail Transaksi Peminjaman</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Detail Transaksi Peminjaman</h3>
                    <hr />
                    <table class="table table-bordered">
                        <tr><th>No. Peminjaman</th><td><?= $transaksi['no_peminjaman']; ?></td></tr>
                        <tr><th>ID Anggota</th><td><?= $transaksi['id_anggota']; ?></td></tr>
                        <tr><th>Tanggal Pinjam</th><td><?= $transaksi['tgl_pinjam']; ?></td></tr>
                        <tr><th>Total Pinjam</th><td><?= $transaksi['total_pinjam']; ?></td></tr>
                        <tr><th>Status Transaksi</th><td><?= $transaksi['status_transaksi']; ?></td></tr>
                        <tr><th>Status Ambil Buku</th><td><?= $transaksi['status_ambil_buku']; ?></td></tr>
                    </table>
                    <h4>Detail Buku Dipinjam</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Buku</th>
                                <th>Status Pinjam</th>
                                <th>Perpanjangan</th>
                                <th>Tanggal Kembali</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach($detail as $d): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $d['id_buku']; ?></td>
                                <td><?= $d['status_pinjam']; ?></td>
                                <td><?= $d['perpanjangan']; ?></td>
                                <td><?= $d['tgl_kembali']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a href="<?= base_url('admin/data-transaksi-peminjaman'); ?>" class="btn btn-default">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
