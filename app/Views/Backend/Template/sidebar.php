<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <ul class="nav menu">
        <li><a href="<?= base_url('admin/dashboard-admin'); ?>">
            <span class="glyphicon glyphicon-dashboard"></span> Dashboard</a>
        </li>

        <li><a href="<?= base_url('admin/master-data-admin'); ?>">
            <span class="glyphicon glyphicon-user"></span> Master Data Admin</a>
        </li>

        <li><a href="<?= base_url('anggota/master-data-anggota'); ?>">
            <span class="glyphicon glyphicon-book"></span> Master Data Anggota</a>
        </li>

        <li><a href="<?= base_url('kategori'); ?>">
            <span class="glyphicon glyphicon-tags"></span> Master Data Kategori</a>
        </li>

        <li><a href="<?= base_url('rak'); ?>">
            <span class="glyphicon glyphicon-th-large"></span> Master Data Rak</a>
        </li>

        <li><a href="<?= base_url('buku'); ?>">
            <span class="glyphicon glyphicon-bookmark"></span> Master Data Buku</a>
        </li>

        <li class="parent">
            <a href="#">
                <span class="glyphicon glyphicon-transfer"></span> Transaksi 
                <span data-toggle="collapse" href="#sub-transaksi" class="icon pull-right">
                    <em class="glyphicon glyphicon-plus"></em>
                </span>
            </a>
            <ul class="children collapse" id="sub-transaksi">
                <li><a href="<?= base_url('/admin/peminjaman-step-1'); ?>">
                    <span class="glyphicon glyphicon-import"></span> Peminjaman
                </a></li>
                <li><a href="<?= base_url('pengembalian'); ?>">
                    <span class="glyphicon glyphicon-export"></span> Pengembalian
                </a></li>
            </ul>
        </li>

        <li class="parent">
            <a href="#">
                <span class="glyphicon glyphicon-stats"></span> Laporan 
                <span data-toggle="collapse" href="#sub-laporan" class="icon pull-right">
                    <em class="glyphicon glyphicon-plus"></em>
                </span>
            </a>
            <ul class="children collapse" id="sub-laporan">
                <li><a href="<?= base_url('laporan/peminjaman'); ?>">
                    <span class="glyphicon glyphicon-list-alt"></span> Laporan Peminjaman
                </a></li>
                <li><a href="<?= base_url('laporan/pengembalian'); ?>">
                    <span class="glyphicon glyphicon-list-alt"></span> Laporan Pengembalian
                </a></li>
            </ul>
        </li>

        <li role="presentation" class="divider"></li>
        <li><a href="<?= base_url('admin/logout'); ?>">
            <span class="glyphicon glyphicon-log-out"></span> Logout
        </a></li>
    </ul>
    <div class="attribution">Template by <a href="http://www.medialoot.com/item/lumino-admin-bootstrap-template/">Medialoot</a></div>
</div><!--/.sidebar-->
