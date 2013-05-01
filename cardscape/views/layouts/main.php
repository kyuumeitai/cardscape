<!DOCTYPE html>
<html>
    <head>
        <?php $baseUrl = Yii::app()->baseUrl; ?>

        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/bluetrip/screen.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/base.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/grids.css">

        <script src="<?php echo $baseUrl; ?>/js/jquery-2.0.0.min.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/cardscape.js"></script>

        <title><?php echo CHtml::encode($this->title); ?></title>
    </head>
    <body>
        <div id="page" class="container">
            <div id="header" class="span-24">
                <div id="logo">
                    <?php if (!Yii::app()->user->isGuest) { ?>
                        <div class="user-options">
                            <a class="user-profile" href="<?php echo $this->createUrl('users/profile'); ?>">[ <?php echo Yii::app()->user->name; ?> ]</a>
                            <a class="user-logout" href="<?php echo $this->createUrl('site/logout'); ?>"><?php echo Yii::t('cardscape', 'Logout'); ?></a>
                        </div>
                    <?php } ?>
                    <h1 class="name"><?php echo Yii::app()->name; ?></h1>
                </div>
                <nav class="navigation">
                    <?php $this->widget('zii.widgets.CMenu', $this->menu); ?>
                </nav>
            </div>
            <div class="clear"></div>

            <div id="content-wrapper">
                <?php echo $content; ?>
            </div>
            <div class="clear"></div>

            <footer class="footer span-24">
                <div class="left">
                    <?php
                    echo (defined('CSVersion') ? 'v' . CSVersion : ''),
                    (isset(Yii::app()->params['copyrightHolder']) ? (' - &copy;' . date('Y') .
                            ' ' . Yii::app()->params['copyrightHolder']) : '');
                    ?>
                </div>
                <div class="right navigation">
                    <?php $this->widget('zii.widgets.CMenu', $this->footerMenu); ?>
                </div>
            </footer>
            <div class="clear"></div>
        </div>
    </body>
</html>