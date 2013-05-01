<p>
    <?php
    echo Yii::t('cardscape', 'This is an activation e-mail for your account created at {sitename}. Please use the following link to activate your account.', array(
        '{sitename}' => Yii::app()->name
    ));
    ?>
</p>
<p class="activation-link">
    <span><?php echo Yii::t('cardscape', 'Use:'); ?></span>
    <a href="<?php echo $this->createAbsoluteUrl('site/activate', array('key' => $activation->token)); ?>"><?php echo $this->createAbsoluteUrl('site/activate', array('key' => $activation->token)); ?></a>
</p>

<p>
    <?php echo Yii::t('cardscape', 'This is an automated messages, please don\'t reply to this e-mail address as this messages is sent after your registration or password recovery request.'); ?>
</p>

<?php if ($activation->administratorRequested) { ?>
    <p><?php echo Yii::t('cardscape', 'This activation was requested by an administrator.'); ?> </p>
<?php } ?>
