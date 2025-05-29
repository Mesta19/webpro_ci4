<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin::login');
$routes->get('/coba', 'Home::coba');
$routes->get('/home/coba-parameter/(:alpha)/(:num)/(:alphanum)', 'Home::belajar_segment/$1/$2/$3');
$routes->get('/percabangan', 'Home::percabangan');
$routes->get('/perulangan', 'Home::perulangan');
$routes->get('/admin/login-admin', 'Admin::login');
$routes->get('/admin/dashboard-admin', 'Admin::dashboard');
$routes->post('admin/autentikasi-login','Admin::autentikasi');
$routes->get('/admin/logout', 'Admin::logout');
$routes->get('/admin/logout', 'Admin::logout');
#  untuk module admin
$routes->get('/admin/master-data-admin', 'Admin::master_data_admin');
$routes->get('/admin/input-data-admin', 'Admin::input_data_admin');
$routes->post('admin/simpan-admin','Admin::simpan_data_admin');
$routes->get('/admin/edit-data-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
$routes->post('admin/update-admin','Admin::update_data_admin');
$routes->get('/admin/hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');

#  untuk module anggota
$routes->get('/anggota/master-data-anggota', 'Anggota::master_data_anggota');
$routes->get('/anggota/input-data-anggota', 'Anggota::input_data_anggota');
$routes->post('anggota/simpan-anggota','Anggota::simpan_data_anggota');
$routes->get('/anggota/edit-data-anggota/(:alphanum)', 'Anggota::edit_data_anggota/$1');
$routes->post('anggota/update-anggota','Anggota::update_data_anggota');
$routes->get('/anggota/hapus-data-anggota/(:alphanum)', 'Anggota::hapus_data_anggota/$1');

//modul kategori
$routes->get('kategori',           'Kategori::index');
$routes->get('kategori/input',     'Kategori::input');
$routes->post('kategori/save',     'Kategori::save');
$routes->get('kategori/edit/(:any)','Kategori::edit/$1');
$routes->post('kategori/update',   'Kategori::update');
$routes->get('kategori/delete/(:any)','Kategori::delete/$1');

//modul rak
$routes->get('rak',            'Rak::index');
$routes->get('rak/input',      'Rak::input');
$routes->post('rak/save',      'Rak::save');
$routes->get('rak/edit/(:any)', 'Rak::edit/$1');
$routes->post('rak/update',    'Rak::update');
$routes->get('rak/delete/(:any)','Rak::delete/$1');

// modul buku
$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    // Routes untuk Buku
    $routes->get('buku',            'Buku::index');
    $routes->get('buku/input',      'Buku::input');
    $routes->post('buku/save',      'Buku::save');
    $routes->get('buku/edit/(:any)', 'Buku::edit/$1');
    $routes->post('buku/update',    'Buku::update');
    $routes->get('buku/delete/(:any)','Buku::delete/$1');
});

// routes peminjaman
$routes->get('/admin/data-transaksi-peminjaman', 'Admin::data_transaksi_peminjaman');
$routes->get('/admin/peminjaman-step-1', 'Admin::peminjaman_step1');
$routes->get('/admin/tes-qr', 'Admin::tes_qr');
$routes->get('/admin/peminjaman-step-2', 'Admin::peminjaman_step2');
$routes->post('/admin/peminjaman-step-2', 'Admin::peminjaman_step2');
$routes->get('/admin/simpan-temp-pinjam/(:alphanum)', 'Admin::simpan_temp_pinjam/$1');
$routes->get('admin/simpan-temp-_pinjam/(:segment)', 'Admin::simpan_temp_pinjam/$1');
$routes->get('/admin/hapus-temp/(:alphanum)', 'Admin::hapus_peminjaman/$1');
$routes->get('/admin/simpan-transaksi-peminjaman', 'Admin::simpan_transaksi_peminjaman');