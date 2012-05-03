<?php $form = $this->beginWidget('CActiveForm', array('id' => 'email-form', 'enableAjaxValidation' => true)); ?>

<fieldset>
    <legend>General</legend>

    <div class="row">
        <?php
        echo $form->labelEx($seForm, 'email'),
        $form->textField($seForm, 'email', array('size' => 25, 'maxlength' => 25)),
        $form->error($seForm, 'email');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($seForm, 'smtp'),
        $form->checkBox($seForm, 'smtp'),
        $form->error($seForm, 'smtp');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($seForm, 'username'),
        $form->textField($seForm, 'username'),
        $form->error($seForm, 'username');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($seForm, 'password'),
        $form->passwordField($seForm, 'password'),
        $form->error($seForm, 'password');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($seForm, 'host'),
        $form->textField($seForm, 'host'),
        $form->error($seForm, 'host');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($seForm, 'port'),
        $form->textField($seForm, 'port'),
        $form->error($seForm, 'port');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($seForm, 'security'),
        $form->dropDownList($seForm, 'security', SettingsEmailForm::securityNames()),
        $form->error($seForm, 'security');
        ?>
    </div>
</fieldset>

<div class="row buttons">
    <?php
    echo CHtml::submitButton('Save');
    ?>
</div>

<?php
$this->endWidget();