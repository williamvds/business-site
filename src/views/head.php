<!doctype html>
<title><?php echo PAGE_TITLE ?></title>
<link rel="stylesheet" href="/static/app.css">
<script src="/static/app.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">

<header>
  <div id="info" class="sizeWrap">
    <h1 id="logo"><?php echo $lang->homeTitle ?></h1>

    <div id="infoContact">
      <div>
        <p><b><?php echo $lang->contact ?>:</b> <?php echo $lang->phone ?></p>
        <a href="<?php echo $lang->facebook ?>" target="_blank"><?php echo $lang->headFacebook ?>
          <img src="/static/fb.svg" alt="<?php echo $lang->headFBAlt ?>">
        </a>
      </div>
    </div>
    <label for="menu"><img src="/static/menu.svg"></label>
  </div>

  <nav class="sizeWrap">
    <input id="menu" type="checkbox" hidden>
    <div>
      <div id="links">
<?php
  foreach ( ['home', 'gallery', 'contact'] as $link ) {
    $url = $lang->{ $link .'URL' };
    $text = $lang->{ $link .'Link' };
    $class = $url == REQUEST_URI? ' class="current"' : '';
    echo "<a$class href=\"$url\"><span>$text</span></a>\n";
  }
?>
      </div>

      <a id="lang" href="<?php echo $lang->langURL ?>">
        <img src="<?php echo $lang->langImg ?>">
        <span><?php echo $lang->langP ?></span>
      </a>
    </div>
  </nav>

</header>

<main>
