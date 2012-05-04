<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/styles.css">

        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <div id="page">
            <div id="topbanner">
                <!-- //TODO: Big image header and logo to the side -->
                Find some nice images to slide here and offer the usually header...
                A logo should be placed similar to a clip (a bit offset to the left).
            </div>
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
                    <li><a href="<?php echo $this->createUrl('site/about'); ?>">About</a></li>
                    <li><a href="<?php echo $this->createUrl('site/credits'); ?>">Credits</a></li>
                    <li><a href="http://sourceforge.net/projects/cardscape/">Cardscape</a></li>
                    <li><a href="http://wtactics.org">WTactics</a></li>                    
                </ul>
                <p><?php echo Yii::app()->params['copyright']; ?></p>
            </footer>
        </div>
    </body>
</html>

