<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/styles.css">

        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <div id="page">
            <div id="topbanner"><!-- //TODO: Big image header and logo to the side --></div>
            <nav role="navigation">
                <div id="menu-container">
                    <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu)); ?>
                </div>
            </nav>
            <div class="clearfix"></div>

            <div id="content" role="main">
                <?php echo $content; ?>
            </div>

            <footer role="contentinfo">
                <ul>
                    <li>Footer information</li>
                </ul>
            </footer>
        </div>
    </body>
</html>

