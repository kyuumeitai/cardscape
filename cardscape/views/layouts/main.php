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
            <div id="title">Cardscape - {$cfg.general.game}</div>
            <div id="menubar">
                <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu)); ?>
            </div>
        </div>

        <?php echo $content; ?>        

        <div id="footer">
            <p>
                Cardscape is licensed under the <a href="#">GNU Affero Public License 3</a>. The sourcecode can be obtained at <a href="#">Sourceforge</a>
            </p>
        </div>
    </body>
</html>

