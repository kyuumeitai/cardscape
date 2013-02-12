<!DOCTYPE html>
<html>
    <head>
        <?php $baseUrl = Yii::app()->baseUrl; ?>

        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/cardscape.css">

        <title><?php echo CHtml::encode($this->title); ?></title>
    </head>
    <body>
        <div class="pagetop">
            <nav class="mainmenu"></nav>
        </div>
        <div class="content">
            <?php echo $content; ?>
        </div>
        <footer class="footer">
            <?php echo date('Y'); ?>
        </footer>
    </body>
</html>