<?php
// Handling all flash messages that may have been sent to the currently authenticated
// user
$messages = Yii::app()->user->getFlashes();
if (count($messages) > 0) {
    $jsGrowl = '';
    foreach ($messages as $key => $message) {
        $jsGrowl .= '$.jGrowl("' . $message . '", {theme: "' . $key . '"})';
    }

    Yii::app()->clientScript->registerScript('jsgrowl', $jsGrowl, CClientScript::POS_READY);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <?php $baseUrl = Yii::app()->baseUrl; ?>

        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl, '/css/cardscape', (YII_DEBUG ? '' : '.min'), '.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jquery.jgrowl.min.css">

        <script src="<?php echo $baseUrl; ?>/js/jquery-2.0.0.min.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/jquery.jgrowl.min.js"></script>
        <script src="<?php echo $baseUrl, '/js/cardscape', (YII_DEBUG ? '' : '.min'), '.js'; ?>"></script>

        <title><?php echo CHtml::encode($this->title); ?></title>
    </head>
    <body>
        <div id="header">
            <div id="session-tools">
                <?php if (!Yii::app()->user->isGuest) { ?>
                    <a class="user-profile" href="<?php echo $this->createUrl('users/profile'); ?>"><?php echo Yii::app()->user->name; ?></a>
                    <a class="user-logout" href="<?php echo $this->createUrl('site/logout'); ?>"><?php echo Yii::t('cardscape', 'Logout'); ?></a>
                <?php } else { ?>
                    <a class="login-register" href="<?php echo $this->createUrl('site/login'); ?>"><?php echo Yii::t('cardscape', 'Login/Register'); ?></a>
                <?php } ?>
            </div>
            <?php echo CHtml::encode(Yii::app()->name); ?>
        </div>
        <nav class="navigation"><?php $this->widget('zii.widgets.CMenu', $this->menu); ?></nav>
        <div id="page">
            <!-- DESC: Contains the center page with the main content, it is placed 
            just below the menu strip. -->

            <div class="content">
                <?php echo $content; ?>
            </div>

            <div class="clear"></div>
        </div>
        <footer class="footer">
            <?php
            echo (defined('CSVersion') ? 'v' . CSVersion : ''),
            (isset(Yii::app()->params['copyrightHolder']) ? (' - &copy;' . date('Y') .
                    ' ' . Yii::app()->params['copyrightHolder']) : '');

            $this->widget('zii.widgets.CMenu', $this->footerMenu);
            ?>
        </footer>
    </body>
</html>