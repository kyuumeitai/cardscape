<?php $form = $this->beginWidget('CActiveForm', array('id' => 'faction-form')); ?>
<fieldset>
    <legend>Faction</legend>

    <div class="row">
        <?php
        echo $form->labelEx($faction, 'name'),
        $form->textField($faction, 'name');
        ?>
    </div>
    <?php echo $form->error($faction, 'name'); ?>

    <div class="row">
        <?php echo CHtml::submitButton('Save'); ?>
    </div>
</fieldset>
<?php
$this->endWidget();