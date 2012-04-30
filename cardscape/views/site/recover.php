<h1>Recover Password</h1>
<?php
//$form = $this->beginWidget('CActiveForm', array(
//    'id' => 'login-form',
//    'focus' => array($login, 'username')
//        ));
?>
<fieldset>
    <legend></legend>
    <div class="row">
        <?php
        echo $form->labelEx($login, 'username'),
        $form->textField($login, 'username');
        ?>
    </div>
    <?php echo $form->error($login, 'username'); ?>

    <div class="row">
        <?php
        echo $form->labelEx($login, 'password'),
        $form->passwordField($login, 'password');
        ?>
    </div>
    <?php echo $form->error($login, 'password'); ?>

    <div class="row">
        <?php
        echo $form->checkBox($login, 'rememberMe'),
        $form->label($login, 'rememberMe');
        ?>
    </div>
    <?php echo $form->error($login, 'rememberMe'); ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Login'); ?>
    </div>
</fieldset>

<?php $this->endWidget(); ?>

<p>
    <?php echo CHtml::link('Lost password?', $this->createURL('site/recover')); ?>
</p>