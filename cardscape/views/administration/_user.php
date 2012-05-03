<?php $form = $this->beginWidget('CActiveForm', array('id' => 'user-form', 'enableAjaxValidation' => true)); ?>

<fieldset>
    <legend>General</legend>

    <div class="row">
        <?php
        echo $form->labelEx($suForm, 'registration'),
        $form->checkBox($suForm, 'registration'),
        $form->error($suForm, 'registration');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($suForm, 'captcha'),
        $form->checkBox($suForm, 'captcha'),
        $form->error($suForm, 'captach');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($suForm, 'minnick'),
        $form->textField($suForm, 'minnick'),
        $form->error($suForm, 'minnick');
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