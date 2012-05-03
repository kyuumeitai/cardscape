<?php
$this->title = 'Card Gallery';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/gallery.css');
?>

<h1>Card Gallery</h1>
<p>//TODO: not implemented yet!</p>
<div id="gallery">
    <?php foreach ($cards as $card) { ?>
        <div class="gallery-item"></div>
    <?php } ?>

    <div class="clearfix"></div>
</div>

