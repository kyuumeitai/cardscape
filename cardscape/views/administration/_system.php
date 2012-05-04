<?php $form = $this->beginWidget('CActiveForm', array('id' => 'system-form', 'enableAjaxValidation' => true)); ?>

<fieldset>
    <legend>System Settings</legend>
    <div class="row">
        <?php
        echo $form->labelEx($ssForm, 'language'),
        $form->dropDownList($ssForm, 'language', $languages);
        $form->error($ssForm, 'language');
        ?>
    </div>    
    <div class="row">
        <?php
        echo $form->labelEx($ssForm, 'projects'),
        $form->checkBox($ssForm, 'projects');
        $form->error($ssForm, 'projects');
        ?>
    </div>
</fieldset>

<div class="row buttons">
    <?php echo CHtml::submitButton('Save') ?>
</div>

<?php
$this->endWidget();