<?php if ( !AJAX ) require 'views/head.php' ?>
<span class="slides">
  <input type="radio" name="slide" id="sl1" checked>
  <img alt="a picture of our work" src="https://placehold.it/800x360">
  <input type="radio" name="slide" id="sl2">
  <img alt="a picture of our work" src="https://placehold.it/800x360">
  <input type="radio" name="slide" id="sl3">
  <img alt="a picture of our work" src="https://placehold.it/800x360">
  <span>
    <label for="sl1">●</label>
    <label for="sl2">●</label>
    <label for="sl3">●</label>
  </span>
</span>

<div>
  <h1><?php echo $lang->homeH1 ?></h1>
  <p><?php echo $lang->homeP1 ?></p>
  <a href="/contact" class="card"><?php echo $lang->contact ?></a>
</div>

<div class="imgLeft sizeWrap">
  <img src="https://placehold.it/350x250">
  <div>
    <h2><?php echo $lang->homeH2 ?></h2>
    <p><?php echo $lang->homeP2 ?></p>
  </div>
</div>

<div class="imgRight sizeWrap">
  <div>
    <h2><?php echo $lang->homeH3 ?></h2>
    <p><?php echo $lang->homeP3 ?></p>
  </div>
  <img src="https://placehold.it/350x250">
</div>

<div>
  <h2><?php echo $lang->homeH4 ?></h2>
  <p><?php echo $lang->homeP4 ?></p>
</div>
<?php if ( !AJAX ) require 'views/foot.php' ?>
