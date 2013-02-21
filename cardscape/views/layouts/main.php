<!DOCTYPE html>
<html>
    <head>
        <?php $baseUrl = Yii::app()->baseUrl; ?>

        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/bluetrip/screen.css">
        <!-- <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/bluetrip/print.css"> -->
        <!-- <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/bluetrip/ie.css"> -->

        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/cardscape.css">

        <title><?php echo CHtml::encode($this->title); ?></title>
    </head>
    <body>
        <div id="page" class="container">
            <div id="header" class="span-24">
                <div id="logo"></div>
                <nav class="navigation">
                    <?php $this->widget('zii.widgets.CMenu', $this->menu); ?>
                    <!-- <ul>
                        <li class="selected"><a href="index.html">home</a></li>
                        <li><a href="about.html">about us</a></li>
                        <li><a href="category.html">books</a></li>
                        <li><a href="specials.html">specials books</a></li>
                        <li><a href="myaccount.html">my accout</a></li>
                        <li><a href="register.html">register</a></li>
                        <li><a href="details.html">prices</a></li>
                        <li><a href="contact.html">contact</a></li>
                    </ul> -->
                </nav>
            </div>
            <div class="clearfix"></div>

            <div id="content-wrapper" class="span-24">
                <div class="content">
                    <?php echo $content; ?>
                </div>
            </div>
            <div class="clearfix"></div>

            <footer class="footer span-24">
                <div class="left"></div>
                <div class="right">
                    <a href="#">home</a>
                    <a href="#">about us</a>
                    <a href="#">services</a>
                    <a href="#">privacy policy</a>
                    <a href="#">contact us</a>
                </div>
            </footer>
            <div class="clearfix"></div>
        </div>
    </body>
</html>