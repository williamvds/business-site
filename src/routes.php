<?php

function title( $str ) {
  global $lang;
  define( 'PAGE_TITLE', $str .' | '. $lang->homeTitle );
}

$router->get( $lang->homeURL, function() {
  global $lang;
  define( 'PAGE_TITLE', $lang->homeTitle );
  require 'views/home.php'; return true;
} );

$router->get( $lang->contactURL, function() {
  global $lang;
  title( $lang->contactTitle );
  require 'views/contact.php'; return true;
} );

$router->get( $lang->galleryURL, function() {
  global $lang;
  title( $lang->galleryTitle );
  require 'views/gallery.php'; return true;
} );

