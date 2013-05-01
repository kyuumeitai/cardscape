<?php
/** @var SiteController $this */
$this->title = Yii::t('cardscape', 'Registration');
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'New account registered'); ?></h1>

<?php
echo Yii::t('cardscape', '<p>Your registration is complete but before you can login you need to activate your account.</p><p>An e-mail with the activation link was sent to your e-mail address, please follow the instructions provided there.</p>');
?>

<p>
    <a href="<?php echo $this->createUrl('site/index'); ?>"><?php echo Yii::t('cardscape', 'Home'); ?></a>
</p>
