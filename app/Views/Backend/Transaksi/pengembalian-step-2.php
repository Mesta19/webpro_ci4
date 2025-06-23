<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Pengembalian</li>
        </ol>
    </div><div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Detail Pengembalian</h3>
                    <hr />
                    <?php if(isset($dataAnggota) && $dataAnggota): ?>
                        <p><b>Nama Anggota:</b> <?php echo htmlspecialchars($dataAnggota['nama_anggota']); ?></p>
                    <?php endif; ?>
                    <?php if(isset($dataTransaksi) && $dataTransaksi): ?>
                        <p><b>No. Peminjaman:</b> <?php echo htmlspecialchars($dataTransaksi['no_peminjaman']); ?></p>
                        <p><b>Tanggal Pinjam:</b> <?php echo htmlspecialchars($dataTransaksi['tgl_pinjam']); ?></p>
                    <?php endif; ?>
                    <h4>Daftar Buku yang Dipinjam</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Status Pinjam</th>
                                <th>Tanggal Kembali (Jatuh Tempo)</th>
                                <th>Tanggal Pengembalian (Aktual)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($dataDetail) && is_array($dataDetail)): $no=1; foreach($dataDetail as $row): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['judul_buku']); ?></td>
                                <td><?php echo htmlspecialchars($row['status_pinjam']); ?></td>
                                <td><?php echo htmlspecialchars($row['tgl_kembali']); ?></td>
                                <td><?php echo date('Y-m-d'); // tanggal aktual pengembalian ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                    <form action="<?php echo base_url('admin/proses-pengembalian'); ?>" method="post">
                        <button type="submit" class="btn btn-success">Konfirmasi Pengembalian</button>
                        <a href="<?php echo base_url('admin/pengembalian-step-1'); ?>" class="btn btn-danger">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div></div>
