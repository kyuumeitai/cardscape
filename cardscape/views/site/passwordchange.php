<?php $form = $this->beginWidget('CActiveForm', array('id' => 'change-form', 'enableAjaxValidation' => true)); ?>
<fieldset>
    <legend>Recover</legend>
    <div class="row">
        <?php
        echo $form->labelEx($change, 'password'),
        $form->passwordField($change, 'password');
        ?>
    </div>
    <?php echo $form->error($change, 'password'); ?>

    <div class="row">
        <?php
        echo $form->labelEx($change, 'password_repeat'),
        $form->passwordField($change, 'password_repeat');
        ?>
    </div>
    <?php echo $form->error($change, 'password_repeat'); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Change Password'); ?>
    </div>
</fieldset>

<?php
$this->endWidget();