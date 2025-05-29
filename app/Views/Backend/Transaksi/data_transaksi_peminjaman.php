<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Transaksi Peminjaman Buku</li>
        </ol>
    </div><div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Transaksi Peminjaman Buku</h1>
        </div>
    </div><div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Daftar Data Peminjaman
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
                    <a href="<?= base_url('admin/peminjaman-step-1'); ?>" class="btn btn-primary btn-sm pull-right" style="margin-top: -5px; margin-right: 10px;">
                        <span class="glyphicon glyphicon-plus"></span> Tambah Peminjaman
                    </a>
                </div>
                <div class="panel-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <i class="fa fa-check-circle"></i> <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <i class="fa fa-times-circle"></i> <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <table data-toggle="table"
                           data-pagination="true"
                           data-search="true"
                           data-show-columns="true"
                           data-show-refresh="true"
                           data-show-toggle="true"
                           data-sort-name="no_peminjaman" 
                           data-sort-order="desc"
                           class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th data-field="no_peminjaman" data-sortable="true">No Peminjaman</th>
                            <th data-field="nama_anggota" data-sortable="true">Nama Anggota</th>
                            <th data-field="tgl_pinjam" data-sortable="true">Tanggal Peminjaman</th>
                            <th data-field="total_pinjam" data-sortable="true" data-align="center">Total Buku Yang Dipinjam</th>
                            <th data-field="status_transaksi" data-sortable="true" data-align="center">Status Transaksi</th>
                            <th data-field="status_ambil_buku" data-sortable="true" data-align="center">Status Ambil Buku</th>
                            <th data-field="opsi" data-align="center">Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($transaksi) && is_array($transaksi)): ?>
                            <?php foreach ($transaksi as $trx): ?>
                                <tr>
                                    <td><?= esc($trx['no_peminjaman']); ?></td>
                                    <td><?= esc($trx['nama_anggota'] ?? 'N/A'); ?></td>
                                    <td><?= esc(date('Y-m-d', strtotime($trx['tgl_pinjam']))); ?></td>
                                    <td align="center"><?= esc($trx['total_pinjam']); ?></td>
                                    <td align="center">
                                        <?php
                                        $statusClass = 'label-default'; // Default
                                        if ($trx['status_transaksi'] == 'Berjalan') {
                                            $statusClass = 'label-warning';
                                        } elseif ($trx['status_transaksi'] == 'Selesai') {
                                            $statusClass = 'label-success';
                                        } elseif ($trx['status_transaksi'] == 'Terlambat') { // Anda mungkin punya status ini
                                            $statusClass = 'label-danger';
                                        } elseif ($trx['status_transaksi'] == 'Dibatalkan') { // Atau status lain
                                            $statusClass = 'label-info';
                                        }
                                        ?>
                                        <span class="label <?= $statusClass; ?>"><?= esc($trx['status_transaksi']); ?></span>
                                    </td>
                                     <td align="center">
                                        <?php
                                        $statusAmbilClass = 'label-default'; // Default
                                        if ($trx['status_ambil_buku'] == 'Sudah Diambil') {
                                            $statusAmbilClass = 'label-success';
                                        } elseif ($trx['status_ambil_buku'] == 'Belum Diambil') {
                                            $statusAmbilClass = 'label-danger';
                                        }
                                        ?>
                                        <span class="label <?= $statusAmbilClass; ?>"><?= esc($trx['status_ambil_buku']); ?></span>
                                    </td>
                                    <td align="center">
                                        <a href="<?= base_url('admin/detail-transaksi-peminjaman/' . esc($trx['no_peminjaman'], 'url')); ?>" class="btn btn-primary btn-xs" title="Lihat Detail">
                                            <span class="glyphicon glyphicon-info-sign"></span> Lihat Detail
                                        </a>
                                        <?php if ($trx['status_transaksi'] == 'Berjalan' && $trx['status_ambil_buku'] == 'Sudah Diambil'): ?>
                                            <a href="<?= base_url('admin/form-pengembalian/' . esc($trx['no_peminjaman'], 'url')); ?>" class="btn btn-success btn-xs" title="Proses Pengembalian" style="margin-left: 5px;">
                                                <span class="glyphicon glyphicon-check"></span> Pengembalian
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data transaksi peminjaman.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div></div>  <script>
    $(function () {
        // Bagian ini mungkin spesifik untuk demo Lumino jika ada checkbox #hover, #striped, #condensed
        // Jika tidak ada checkbox tersebut di halaman Anda, baris ini tidak akan berpengaruh banyak
        $('#hover, #striped, #condensed').prop('checked', false); 
        
        // Inisialisasi Bootstrap Table. data-toggle="table" biasanya sudah cukup,
        // tapi ini memastikan jika ada konfigurasi tambahan yang diperlukan oleh tema.
        $('[data-toggle="table"]').bootstrapTable();
    });
</script>