<?php
/**
 * @var UsersController $this
 * @var CActiveForm $registrationForm
 */
$this->title = Yii::t('cardscape', 'Login/Register');
?>

<div class="span-11">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Login'); ?></h1>
    <?php
    $loginForm = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => false
    ));
    ?>
    <div class="span-4"><?php echo $loginForm->labelEx($login, 'emailOrUsername'); ?></div>
    <div class="span-6"><?php echo $loginForm->textField($login, 'emailOrUsername'); ?></div>
    <div class="clear"></div>

    <div class="span-4"><?php echo $loginForm->labelEx($login, 'password'); ?></div>
    <div class="span-6"><?php echo $loginForm->passwordField($login, 'password'); ?></div>
    <div class="clear"></div>

    <div class="buttonsrow span-10 last">
        <button type="submit" class="button"><?php echo Yii::t('cardscape', 'Login'); ?></button>
    </div>
    <div class="clear"></div>

    <?php $this->endWidget(); ?>
</div>

<div class="span-12 prefix-1 last">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Register new account'); ?></h1>
    <?php
    $registrationForm = $this->beginWidget('CActiveForm', array(
        'id' => 'registration-form', 'enableAjaxValidation' => true
    ));
    ?>
    <div class="span-4"><?php echo $registrationForm->labelEx($registration, 'username'); ?></div>
    <div class="span-7"><?php echo $registrationForm->textField($registration, 'username', array('size' => 25, 'maxlength' => 25)); ?></div>
    <div class="clear"></div>

    <div class="span-4"><?php echo $registrationForm->labelEx($registration, 'email'); ?></div>
    <div class="span-7"><?php echo $registrationForm->textField($registration, 'email', array('size' => 25, 'maxlength' => 255)); ?></div>
    <div class="clear"></div>

    <div class="span-4"><?php echo $registrationForm->labelEx($registration, 'password'); ?></div>
    <div class="span-7"><?php echo $registrationForm->passwordField($registration, 'password'); ?></div>
    <div class="clear"></div>

    <div class="span-4"><?php echo $registrationForm->labelEx($registration, 'repeatPassword'); ?></div>
    <div class="span-7"><?php echo $registrationForm->passwordField($registration, 'repeatPassword'); ?></div>
    <div class="clear"></div>

    <div class="span-4"><?php echo $registrationForm->labelEx($registration, 'language'); ?></div>
    <div class="span-7"><?php echo $registrationForm->dropDownList($registration, 'language', Yii::app()->params['languages']); ?></div>
    <div class="clear"></div>

    <div class="buttonsrow span-12 last">
        <button type="submit" class="button"><?php echo Yii::t('cardscape', 'Register'); ?></button>
    </div>
    <div class="clear"></div>

    <?php $this->endWidget(); ?>
</div>