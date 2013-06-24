<?php
/**
 * @var UsersController $this
 * @var CActiveForm $registrationForm
 */
$this->title = Yii::t('cardscape', 'Login/Register');
?>

<div class="half-block">
    <h1><?php echo Yii::t('cardscape', 'Login'); ?></h1>
    <?php
    $loginForm = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => false
    ));
    ?>
    <div class="row">
        <?php
        echo $loginForm->labelEx($login, 'emailOrUsername'),
        $loginForm->textField($login, 'emailOrUsername');
        ?>
    </div>

    <div class="row">
        <?php
        echo $loginForm->labelEx($login, 'password'),
        $loginForm->passwordField($login, 'password');
        ?>
    </div>

    <div class="row">
        <button type="submit" class="button"><?php echo Yii::t('cardscape', 'Login'); ?></button>
    </div>
    <?php $this->endWidget(); ?>
</div>

<div class="half-block">
    <h1><?php echo Yii::t('cardscape', 'Register new account'); ?></h1>
    <?php
    $registrationForm = $this->beginWidget('CActiveForm', array(
        'id' => 'registration-form', 'enableAjaxValidation' => true
    ));
    ?>
    <div class="row">
        <?php
        echo $registrationForm->labelEx($registration, 'username'),
        $registrationForm->textField($registration, 'username', array('size' => 25, 'maxlength' => 25));
        ?>
    </div>

    <div class="row"><?php
        echo $registrationForm->labelEx($registration, 'email'),
        $registrationForm->textField($registration, 'email', array('size' => 25, 'maxlength' => 255));
        ?>
    </div>

    <div class="row"><?php
        echo $registrationForm->labelEx($registration, 'password'),
        $registrationForm->passwordField($registration, 'password');
        ?>
    </div>

    <div class="row">
        <?php
        echo $registrationForm->labelEx($registration, 'repeatPassword'),
        $registrationForm->passwordField($registration, 'repeatPassword');
        ?>
    </div>

    <div class="row">
        <?php
        echo $registrationForm->labelEx($registration, 'language'),
        $registrationForm->dropDownList($registration, 'language', Yii::app()->params['languages']);
        ?>
    </div>

    <div class="row">
        <button type="submit" class="button"><?php echo Yii::t('cardscape', 'Register'); ?></button>
    </div>

    <?php $this->endWidget(); ?>
</div>

<div class="clear"></div>