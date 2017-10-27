[![Screenshot of homepage](https://raw.github.com/williamvds/business-site/master/docs/homepage.png)]
[![Screenshot of adaptive homepage](https://raw.github.com/williamvds/business-site/master/docs/adaptiveHomepage.png)]
# A simple business site

This project provides the backbone for the content a business might want to display on their
website

* Simple and clear style

* Adapts to differently sized screens, using only CSS media queries

* Minimal JavaScript for loading pages through AJAX requests

* CSS-only slideshow and gallery page

* Routing controlled by PHP with...
  * a controller system
  * support for parameters extracted from the request URI
  * the ability to respond in JSON format

* A basic language system

## Installation

* Folder with AllowOverride enabled for `.htaccess`

* Enable httpd modules:
  * php7\_module
  * rewrite\_module
  * expires\_module
  * deflate\_module

## Usage

### Folder structure
The [`/static`](static) folder is the only one containing the files that users are able to download.

All other requests are silently redirected to [`/src/index.php`](src/index.php).

As such, store any files that users must be able to download in [`/static`](static) - that includes
JavaScript, CSS, and images.

See [`.htaccess`](.htaccess) to see how this is done using the rewrite engine.

### Router

See [`/src/index.php`](src/index.php) and [`/src/routes.php`](src/routes.php) for more simple examples.

#### 1. Responding to requests

```php
$router = new Router;

$router->use( function() {
  echo 'This is called for all requests<br>';
} );

$router->post( function() {
  echo 'This is called for all POST requests<br>';
} );

$router->use( function() {
  echo 'This is always the last controller called';
  return true; // Stop other controllers running after this
} );
```

Methods available for `GET`, `POST`, `PUT`, and `DELETE`, all following the same format

#### 2. Filtering by request path

```php
$router->use( '/', function() {
  echo 'You\'re home!<br>';
} );

$router->use( '/.*', function() {
  echo 'You\'re away from home<br>';
} );

$router->use( '/foo', function() {
  echo 'You\'re at /foo<br>';
  return true;
} );

$router->use( '/foo*', function() {
  echo 'Your request began with /foo<br>';
  return true;
} );
```

#### 3. Getting parameters from URI

`$params` is provided as a parameter in each callback. It is also available in the global scope.

It contains the matched information from the URL pattern used.

```php
$router->use( '/foo/:bar', function( $params ) {
  echo $params['bar'];
  return true;
} );
// Go to /foo:        no output
// Go to /foo/1:      1
// Go to /foo/string: string

$router->use( '/foo/:bar/:baz', function( $params ) {
  print_r( $params );
  return true;
} );
// Go to /foo:     no output
// Go to /foo/1:   no output
// Go to /foo/1/2: Array ( [0] => /foo/1/2/ [bar] => 1 [1] => 1 [baz] => 2 [2] => 2 )
```

## Attribution

Facebook logo - [Zlatko Najdenovski](https://iconfinder.com/icons/317727)
([CC BY 3.0](https://creativecommons.org/licenses/by/3.0/))

Menu icon - [Google material icons](https://material.io/icons/)
([Apache 2.0](https://www.apache.org/licenses/LICENSE-2.0))

SVG flags - [Panayiotis Lipiridis](https://github.com/lipis/flag-icon-css)
([MIT License](https://github.com/lipis/flag-icon-css/blob/master/LICENSE))
