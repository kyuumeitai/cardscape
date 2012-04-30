<?php $form = $this->beginWidget('CActiveForm', array('id' => 'recover-form', 'enableAjaxValidation' => false)); ?>
<fieldset>
    <legend>Recover</legend>
    <div class="row">
        <?php
        echo $form->labelEx($recover, 'email'),
        $form->textField($recover, 'email');
        ?>
    </div>
    <?php echo $form->error($recover, 'email'); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Request New Password'); ?>
    </div>
</fieldset>

<?php
$this->endWidget();