<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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

//$routes->add('kontroler/metoda', 'Kontroler::metoda', ['filter' => 'role:naziv_grupe']);
//$routes->add('kontroler/metoda', 'Kontroler::metoda', ['filter' => 'perm:naziv_dozvole(permisije)']);

$routes->post('student/prijava_sacuvaj', 'Student::prijava_sacuvaj');
$routes->post('student/prijava_azuriraj_sacuvaj', 'Student::prijava_azuriraj_sacuvaj');
$routes->post('student/obrazlozenje_sacuvaj', 'Student::obrazlozenje_sacuvaj');
$routes->post('student/obrazlozenje_azuriraj_sacuvaj', 'Student::obrazlozenje_azuriraj_sacuvaj');
$routes->post('student/biografija_sacuvaj', 'Student::biografija_sacuvaj');
$routes->post('student/biografija_azuriraj_sacuvaj', 'Student::biografija_azuriraj_sacuvaj');
$routes->post('mentor/prijava_azuriraj_sacuvaj', 'Mentor::prijava_azuriraj_sacuvaj');
$routes->post('mentor/obrazlozenje_azuriraj_sacuvaj', 'Mentor::obrazlozenje_azuriraj_sacuvaj');
$routes->post('mentor/biografija_azuriraj_sacuvaj', 'Mentor::biografija_azuriraj_sacuvaj');
$routes->post('rukovodilac/prijava_azuriraj_sacuvaj', 'Rukovodilac::prijava_azuriraj_sacuvaj');
$routes->post('rukovodilac/obrazlozenje_azuriraj_sacuvaj', 'Rukovodilac::obrazlozenje_azuriraj_sacuvaj');
$routes->post('rukovodilac/biografija_azuriraj_sacuvaj', 'Rukovodilac::biografija_azuriraj_sacuvaj');
$routes->post('stsluzba/prijava_azuriraj_sacuvaj', 'Stsluzba::prijava_azuriraj_sacuvaj');
$routes->post('stsluzba/obrazlozenje_azuriraj_sacuvaj', 'Stsluzba::obrazlozenje_azuriraj_sacuvaj');
$routes->post('stsluzba/biografija_azuriraj_sacuvaj', 'Stsluzba::biografija_azuriraj_sacuvaj');
$routes->post('komisija/prijava_azuriraj_sacuvaj', 'Komisija::prijava_azuriraj_sacuvaj');
$routes->post('komisija/obrazlozenje_azuriraj_sacuvaj', 'Komisija::obrazlozenje_azuriraj_sacuvaj');
$routes->post('komisija/biografija_azuriraj_sacuvaj', 'Komisija::biografija_azuriraj_sacuvaj');




/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

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