<?php if ( !AJAX ) require 'views/head.php' ?>
<div class="imgLeft">
  <div id="contact">
    <h1><?php echo $lang->contactH ?></h1>
    <p><?php echo $lang->contactPhone, ': ', $lang->phone ?></p>
    <p><?php echo $lang->contactEmail?>:
      <a href="mailto:<?php echo $lang->email ?>"><?php echo $lang->email ?></a>
    </p>
    <p><?php echo str_replace( "\n", "<br>\n", $lang->contactAddr ) ?></p>
  </div>
  <iframe id="map" allowfullscreen
    src="https://www.google.com/maps/embed/v1/place?key=<?php echo $lang->mapsAPI ?>&q=London,UK">
  </iframe>
</div>
<?php if ( !AJAX ) require 'views/foot.php' ?>
