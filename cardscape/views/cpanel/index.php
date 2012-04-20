<?php $this->title = 'Control Panel'; ?>

<h2>Control Panel</h2>

<?php $form = $this->beginWidget('CActiveForm', array('id' => 'user-form')); ?>
<fieldset>
    <legend>User Information</legend>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'email'),
        $form->textField($user, 'email');
        ?>
    </div>
    <?php echo $form->error($user, 'email'); ?>

    <div class="row">
        <?php echo CHtml::submitButton('Save'); ?>
    </div>
</fieldset>
<?php
$this->endWidget();