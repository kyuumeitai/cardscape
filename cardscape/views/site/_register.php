<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'register-form',
    'enableAjaxValidation' => true
        ));
?>
<fieldset>
    <legend>Register</legend>
    <div class="row">
        <?php
        echo $form->labelEx($register, 'username'),
        $form->textField($register, 'username');
        ?>
    </div>
    <?php echo $form->error($register, 'username'); ?>

    <div class="row">
        <?php
        echo $form->labelEx($register, 'email'),
        $form->textField($register, 'email');
        ?>
    </div>
    <?php echo $form->error($register, 'email'); ?>

    <div class="row">
        <?php
        echo $form->labelEx($register, 'password'),
        $form->passwordField($register, 'password');
        ?>
    </div>
    <?php echo $form->error($register, 'password'); ?>

    <div class="row">
        <?php
        echo $form->labelEx($register, 'password_repeat'),
        $form->passwordField($register, 'password_repeat');
        ?>
    </div>
    <?php echo $form->error($register, 'password_repeat'); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Register'); ?>
    </div>
</fieldset>

<?php
$this->endWidget();