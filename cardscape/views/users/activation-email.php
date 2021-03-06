<?php
$activationUrl = $this->createAbsoluteUrl('site/activate', array('key' => $activation->token));
?>

<p>
    <?php
    echo Yii::t('cardscape', 'This is an activation e-mail for your account created at {sitename}. Please use the following link to activate your account.', array(
        '{sitename}' => Yii::app()->name
    ));
    ?>
</p>

<p class="activation-link">
    <span><?php echo Yii::t('cardscape', 'Link:'); ?></span>
    <?php echo CHtml::link($activationUrl, $activationUrl); ?>
</p>

<p class="activation-footer">
    <?php
    if ($activation->administratorRequested) {
        echo Yii::t('cardscape', 'This activation was requested by an administrator.'), '&nbsp;';
    }

    echo Yii::t('cardscape', 'This is an automated messages, please don\'t reply to this e-mail address as this messages is sent after your registration or password recovery request.');
    ?>
</p>
