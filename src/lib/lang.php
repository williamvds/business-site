<?php

/**
 * Class: Lang
 * Stores strings with keys, supporting multiple languages
 */
class Lang {
  /**
   * Active language table to use
   *
   * @var string (= en)
   */
  protected $lang = 'en';

  /**
   * Array of language arrays, using language code as key
   *
   * @var array
   */
  protected static $langs   = [];

  /**
   * Array of global strings, accessible regardless of language. Language-specific entries override
   * global entries
   *
   * @var mixed
   */
  protected static $globals = [];

  /**
   * Add a global entry
   *
   * @param mixed $name Key to store the string
   * @param mixed $val  String value to store
   */
  static function addGlobal( $name, $val ) { static::$globals[$name] = $val; }

  /**
   * Add a language array
   *
   * @param mixed $l   Language code to store array as
   * @param array $val Array of strings
   */
  static function add( $l, $val ) { static::$langs[$l] = $val; }

  /**
   * Add an entry to an existing language
   *
   * @param mixed $l    Language code to add to
   * @param mixed $name Name of entry
   * @param mixed $val  Entry value
   */
  static function addTo( $l, $name, $val ) { static::$langs[$l][$name] = $val; }

  /**
   * Allows entries to be accessed with property syntax, $obj->stringName
   * Language entries override global entries of the same name
   *
   * @param mixed $key
   */
  public function __get( $key ) {
    return static::$langs[$this->lang][$key] ?? static::$globals[$key];
  }

  /**
   * Sets the active language for the object by calling it, $obj( 'en' )
   *
   * @param mixed $l
   */
  public function __invoke( $newLang ) {
    $this->lang = $newLang;
  }
}
