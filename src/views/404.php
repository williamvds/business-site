<?php if ( !AJAX ) require 'views/head.php' ?>
<h1>404</h1>
<p><?php echo sprintf( $lang->e404P, '<em>'. REQUEST_URI .'</em>' ) ?></p>
<a href="/<?php if ( defined( 'BR' ) ) echo 'pt' ?>"><?php echo $lang->e404P2 ?></a>
<?php if ( !AJAX ) require 'views/foot.php' ?>
