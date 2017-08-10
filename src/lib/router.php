<?php

class Router {
  // Value of 'true' indicates that no more handlers should be run
  /**
   * @var bool Whether a handler has indicated that no more handlers should run
   */
  protected $done = false;

  /**
   * Compiles the given path into a regular expression with parameters
   * e.g. /foo/:bar/:baz matched against /foo/123/abc returns bar = "123", baz = "abc".
   * Parameters will match any symbol until another ':' is found, so '/' are still matched
   * '*' symbol matches any number of characters that are not ':'
   *
   * @param string $path     Request path to compile
   * @param bool   $fullPath (= true) Whether the returned pattern should append '$'
   * i.e. if pattern only has to match the beggining of the request path
  */
  protected function compilePath( $path ) {
    if ( is_null( $path ) ) return null;

    $path = preg_replace( '~\*~', '[^:]*',
      preg_replace( '~:(?\'param\'[^:/]+)~', "(?'$1'[^:/]+)",
      $path ) );

    return '~'. $path .'[\/]?$~';
  }

  /**
   * Call handler if request path and method are correct. Save returned result in self::$done.
   *
   * @param callable/array $func Function(s) to call
   * @param string $path   (optional) Request path pattern that the function will be called for
   * @param int    $method (optional) Request method to filter by
  */
  protected function callHandler( $func, $path = null, $method = null ) {
    global $params;

    if ( $this->done
      || !is_null( $path ) && !preg_match( $path, REQUEST_URI, $params )
      || !is_null( $method ) && $_SERVER['REQUEST_METHOD'] !== $method
    ) return;

    $this->done = $func( $params ) === true;
  }

  /**
   * Register a handler with variable number of arguments.
   * Number of arguments:
   * 1: function
   * 2: path, function
   *
   * @param array          $args Handler options [[path,] function(s)]
   * @param callable/array $func  Function(s) to call
   */
  protected function varHandler( $args, $helper, $method = null ) {
    switch ( count( $args ) ) {
      case 1:
        $this->callHandler( $args[0], null, $method );
        break;

      case 2:
        $this->callHandler( $args[1], self::compilePath( $args[0] ), $method );
        break;

      default: throw new InvalidArgumentException(
        "Router.$helper: Invalid number of arguments given" );
    }
  }

  /**
   * Adds handler, optionally filtered by path.
   * Number of arguments:
   * 1: function
   * 2: path, function
   *
   * @param string $path (optional) Request path pattern that the function will be called for
   * @param callable/array $func  Function(s) to call
  */
  public function use() {
    $this->varHandler( func_get_args(), 'use' );
  }

  /**
   * Adds GET handler, optionally filtered by path. Same argument pattern as use()
   *
   * @see Router::use()
  */
  public function get() {
    $this->varHandler( func_get_args(), 'get', 'GET' );
  }

  /**
   * Adds POST handler, optionally filtered by path. Same argument pattern as use()
   *
   * @see Router::use()
  */
  public function post() {
    $this->varHandler( func_get_args(), 'post', 'POST' );
  }

  /**
   * Adds PUT handler, optionally filtered by path. Same argument pattern as use()
   *
   * @see Router::use()
  */
  public function put() {
    $this->varHandler( func_get_args(), 'put', 'PUT' );
  }

  /**
   * Adds DELETE handler, optionally filtered by path. Same argument pattern as use()
   *
   * @see Router::use()
  */
  public function delete() {
    $this->varHandler( func_get_args(), 'delete', 'DELETE' );
  }

  // Encode response as JSON
  public static function respondJSON() {
    global $params;
    $params = isset( $params )? $params : [];

    header( 'Content-type: text/json' );
    echo json_encode( [
      'title' => PAGE_TITLE,
      'html'  => ob_get_clean(),
    ] );
  }

  /**
   * Defaults - define page title if undefined, return JSON if necessary
  */
  public function respond() {
    if ( !defined( 'PAGE_TITLE' ) ) {
      global $lang;
      define( 'PAGE_TITLE', $lang->homeTitle );
    }
    // JSON response for AJAX requests
    if ( AJAX )
      return self::respondJSON();
  }

  function __construct() {
    // Render error page if something goes wrong
    register_shutdown_function( function() {
      if ( error_get_last()['type'] !== E_ERROR ) return;
      ob_clean();

      global $lang;
      define( 'PAGE_TITLE' , $lang->e500Title );
      http_response_code( 500 );

      require 'views/500.php';
      if ( AJAX ) self::respondJSON();
    } );

  }

}
