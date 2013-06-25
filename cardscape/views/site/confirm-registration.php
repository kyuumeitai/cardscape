<?php
/** @var SiteController $this */
$this->title = Yii::t('cardscape', 'Registration');
?>

<h1><?php echo Yii::t('cardscape', 'New account registered'); ?></h1>

<p>
    <?php echo Yii::t('cardscape', 'Your registration is complete but before you can login you need to activate your account. An e-mail with the activation link was sent to your e-mail address, please follow the instructions provided there.'); ?>
</p>

<p>
    <?php echo CHtml::link(Yii::t('cardscape', 'Home'), $this->createUrl('site/index')); ?>
</p>
