<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// ...
// Public Routes
$routes->get('/', 'Home::index');
$routes->get('/paket', 'Home:index');

// Area/Cek Area Routes - consolidated
$routes->get('/cek-area', 'Area::index');
$routes->get('area', 'Area::index');
$routes->post('/cek-area/proses', 'Area::proses');
$routes->post('area/proses', 'Area::proses');
$routes->post('/cek-area/checkByCoordinates', 'Area::checkByCoordinates');
$routes->post('area/checkByCoordinates', 'Area::checkByCoordinates');

// Package routes - using Dashboard controller
$routes->get('packages/available', 'Dashboard::availablePackages');
$routes->post('packages/upgrade', 'Dashboard::upgradePackage');

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
$routes->group('admin', ['filter' => 'auth:admin', 'namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    
    // CRUD Routes for Packages
    $routes->get('paket', 'PaketController::index');
    $routes->get('paket/new', 'PaketController::new');
    $routes->post('paket/create', 'PaketController::create');
    $routes->get('paket/view/(:num)', 'PaketController::view/$1');
    $routes->get('paket/edit/(:num)', 'PaketController::edit/$1');
    $routes->post('paket/update/(:num)', 'PaketController::update/$1');
    $routes->delete('paket/delete/(:num)', 'PaketController::delete/$1');
    $routes->post('paket/toggle-status/(:num)', 'admin\PaketController::toggleStatus/$1');
    $routes->post('paket/toggle-popular/(:num)', 'PaketController::togglePopular/$1');
    $routes->get('paket/export', 'PaketController::export');
});
