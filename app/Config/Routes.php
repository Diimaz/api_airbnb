<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('user', 'Servicios::index');
//$routes->get('user', 'Client::index');
//$routes->post('user', 'Client::store');
//$routes->get('user/(:num)', 'Client::show/$1');
//$routes->post('user/(:num)', 'Client::update/$1');
//$routes->delete('user/(:num)', 'Client::destroy/$1');

$routes->post('login', 'Auth::login');

$routes->get('servicios', 'Servicios::servicios');
$routes->post('serviciosPost', 'Servicios::serviciosPost');
$routes->get('servicios/(:num)', 'Servicios::servicio/$1');
$routes->get('usuarios/(:num)', 'Servicios::usuario/$1');
$routes->get('servicios/reservas/(:num)', 'Servicios::servicioReserva/$1');
//$routes->get('anfitriones', 'Client::anfitriones');
$routes->get('municipioss', 'Servicios::municipioss');
//$routes->get('tarifas', 'Client::tarifas');
//$routes->get('tipoHospedajes', 'Client::tiposHospedajes');
//$routes->get('usuarios', 'Client::usuarios');

$routes->get('paises', 'Servicios::paises');
$routes->get('departamentos/(:num)', 'Servicios::departamentos/$1');
$routes->get('municipios/(:num)', 'Servicios::municipios/$1');


$routes->post('pagos', 'Pagos::pagos');
$routes->post('confirmar', 'Pagos::confirmarPago');
$routes->post('filtros', 'Filtros::filtros');
$routes->post('prueba','Servicios::prueba');

$routes->post('filtroFechas','Servicios::filtroFechas');
$routes->post('misReservas', 'Reservas::misReservas');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}