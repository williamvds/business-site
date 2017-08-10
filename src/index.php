<?php

define( 'DEVEL', isset( $_ENV['dev'] ) );
ini_set( 'display_errors', DEVEL );

define( 'REQUEST_URI', parse_url( $_SERVER['REQUEST_URI'] )['path'] );
define( 'BASEDIR', __DIR__ );
define( 'AJAX', isset( $_GET['ajax'] ) );

ob_start();

require 'lib/lang.php';
global $lang;
$lang = new Lang;

// Load lanaguage info from file
$langs = parse_ini_file( 'lang.ini', true );
foreach ( $langs as $k => $val ) {
  is_array( $val )? Lang::add( $k, $val ) : Lang::addGlobal( $k, $val );
}

require 'lib/router.php';
global $router;
$router = new Router;

// Example to change language - all URLs beggining with /pt are set to portuguese
$router->use( '/pt*', function() {
  global $lang;
  $lang( 'pt' );
} );

require 'routes.php';

// Catch all requests to handle 404
$router->use( function() {
  http_response_code( 404 );

  global $lang;
  define( 'PAGE_TITLE' , $lang->e404Title );

  require 'views/404.php';
} );

$router->respond();

ob_end_flush();
