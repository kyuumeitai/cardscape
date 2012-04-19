<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/wtactics.css">
        <!-- <script type="text/javascript" src="util.js"></script> -->

        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <div id="header">
            <h1>Cardscape - {$cfg.general.game}</h1>
            <div id="tools">
                <?php if (Yii::app()->user->isGuest) { ?>
                    <a href="<?php echo $this->createUrl('site/login'); ?>">Login/Register</a>
                <?php } else { ?>
                    <a href="<?php echo $this->createUrl('/cpanel'); ?>">User CP</a> | <a href="<?php echo $this->createUrl('site/logout'); ?>">Logout</a>
                <?php } ?>
            </div>
            <div style="clear: both"></div>

            <div id="menubar">
                <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu)); ?>
                <div style="clear: both"></div>
            </div>

        </div>

        <div id="content">
            <?php echo $content; ?>        
        </div>
        
        <div id="footer">
            <p>
                Cardscape is licensed under the <a href="#">GNU Affero Public License 3</a>. The sourcecode can be obtained at <a href="#">Sourceforge</a>
            </p>
        </div>
    </body>
</html>

