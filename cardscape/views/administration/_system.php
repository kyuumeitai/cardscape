<?php $form = $this->beginWidget('CActiveForm', array('id' => 'system-form', 'enableAjaxValidation' => true)); ?>

<fieldset>
    <legend>System Settings</legend>

    <div class="row">
        <?php
        echo $form->labelEx($ssForm, 'allowProjects'),
        $form->checkBox($ssForm, 'allowProjects');
        $form->error($ssForm, 'allowProjects');
        ?>
    </div>    
</fieldset>

<div class="row buttons">
    <?php echo CHtml::submitButton('Save') ?>
</div>

<?php
$this->endWidget();