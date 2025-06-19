<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// ...
// Public Routes
$routes->get('/', 'Paket::index');
$routes->get('/paket', 'Paket::index');

// Area/Cek Area Routes - consolidated
$routes->get('/cek-area', 'Area::index');
$routes->get('area', 'Area::index');
$routes->post('/cek-area/proses', 'Area::proses');
$routes->post('area/proses', 'Area::proses');
$routes->post('/cek-area/checkByCoordinates', 'Area::checkByCoordinates');
$routes->post('area/checkByCoordinates', 'Area::checkByCoordinates');

// Auth Routes
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::proses');
$routes->post('/login/proses', 'Auth::proses');
$routes->get('/logout', 'Auth::logout');

// Rute untuk user yang sudah login
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    // Tambahkan rute lain untuk user di sini, misal: profil, tagihan, dll.
});

// Admin Routes (Grouped and Protected by a Filter)
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'admin\Dashboard::index');
    
    // CRUD Routes for Packages
    $routes->get('paket', 'admin\PaketController::index');
    $routes->get('paket/new', 'admin\PaketController::new');
    $routes->post('paket/create', 'admin\PaketController::create');
    $routes->get('paket/view/(:num)', 'admin\PaketController::show/$1');
    $routes->get('paket/edit/(:num)', 'admin\PaketController::edit/$1');
    $routes->post('paket/update/(:num)', 'admin\PaketController::update/$1');
    $routes->delete('paket/delete/(:num)', 'admin\PaketController::delete/$1');
    $routes->post('paket/toggle-status/(:num)', 'admin\PaketController::toggleStatus/$1');
    $routes->post('paket/toggle-popular/(:num)', 'admin\PaketController::togglePopular/$1');
    
});