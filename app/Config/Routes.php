<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->get('/', 'Home::index');

$routes->post('daftar', 'User::daftar');
$routes->post('masuk', 'User::masuk');

$routes->post('tambah_role', 'Role::tambah_role',['filter' => 'authFilter']);
$routes->post('tambah_motivasi', 'Motivasi::tambah_motivasi',['filter' => 'authFilter']);

$routes->get('user', 'User::user',['filter' => 'authFilter']);

$routes->get('list_role', 'Role::list_role',['filter' => 'authFilter']);
$routes->get('role/(:any)', 'Role::role/$1',['filter' => 'authFilter']);
$routes->post('ubah_role/(:any)', 'Role::ubah_role/$1',['filter' => 'authFilter']);
$routes->delete('hapus_role/(:any)', 'Role::hapus_role/$1',['filter' => 'authFilter']);

$routes->get('list_motivasi', 'Motivasi::list_motivasi',['filter' => 'authFilter']);
$routes->get('motivasi/(:any)', 'Motivasi::motivasi/$1',['filter' => 'authFilter']);
$routes->post('ubah_motivasi/(:any)', 'Motivasi::ubah_motivasi/$1',['filter' => 'authFilter']);
$routes->delete('hapus_motivasi/(:any)', 'Motivasi::hapus_motivasi/$1',['filter' => 'authFilter']);

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
