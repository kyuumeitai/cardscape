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
    <fieldset>
        <legend>Existing user</legend>

        <div class="formrow">
            <?php
            echo $loginForm->labelEx($login, 'emailOrUsername'),
            $loginForm->textField($login, 'emailOrUsername');
            ?>
        </div>
        <div class="formrow">
            <?php
            echo $loginForm->labelEx($login, 'password'),
            $loginForm->passwordField($login, 'password');
            ?>
        </div>
    </fieldset>

    <div class="buttonsrow">
        <?php echo CHtml::submitButton(Yii::t('cardscape', 'Login')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<div class="span-11 prefix-1 last">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Register new account'); ?></h1>
    <?php
    $registrationForm = $this->beginWidget('CActiveForm', array(
        'id' => 'registration-form', 'enableAjaxValidation' => true
    ));
    ?>

    <fieldset>
        <legend><?php echo Yii::t('cardscape', 'New user account'); ?></legend>

        <div class="formrow">
            <?php
            echo $registrationForm->labelEx($registration, 'username'),
            $registrationForm->textField($registration, 'username', array('size' => 25, 'maxlength' => 25));
            //$registrationForm->error($registration, 'username');
            ?> 
        </div>

        <div class="formrow">
            <?php
            echo $registrationForm->labelEx($registration, 'email'),
            $registrationForm->textField($registration, 'email', array('size' => 25, 'maxlength' => 255));
            //$registrationForm->error($registration, 'email');
            ?> 
        </div>

        <div class="formrow">
            <?php
            echo $registrationForm->labelEx($registration, 'password'),
            $registrationForm->passwordField($registration, 'password');
            //$registrationForm->error($registration, 'password');
            ?> 
        </div>

        <div class="formrow">
            <?php
            echo $registrationForm->labelEx($registration, 'repeatPassword'),
            $registrationForm->passwordField($registration, 'repeatPassword');
            //$registrationForm->error($registration, 'repeatPassword');
            ?> 
        </div>

        <div class="formrow">
            <?php
            echo $registrationForm->labelEx($registration, 'language'),
            $registrationForm->dropDownList($registration, 'language', Yii::app()->params['languages']);
            //$registrationForm->error($registration, 'email');
            ?>
        </div>
    </fieldset>

    <div class="buttonsrow">
        <?php echo CHtml::submitButton(Yii::t('cardscape', 'Register')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
