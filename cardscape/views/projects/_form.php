<?php
$form = $this->beginWidget('CActiveForm', array('id' => 'project-form'));
?>
<div class="span-4"><?php echo $form->labelEx($project, 'name'); ?></div>
<div class="span-20 last">
    <?php echo $form->textField($project, 'name', array('size' => 30, 'maxlength' => 50)); ?>
</div>
<div class="clear"></div>

<div class="span-4"><?php echo $form->labelEx($project, 'description'); ?></div>
<div class="span-20 last">
    <?php echo $form->textField($project, 'description', array('size' => 30, 'maxlength' => 255)); ?>
</div>
<div class="clear"></div>

<div class="span-4"><?php echo $form->labelEx($project, 'expires'); ?></div>
<div class="span-20 last">
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $project,
        'attribute' => 'expires',
        'options' => array(
            'showAnim' => 'fold'
        ),
    ));
    ?>
</div>
<div class="clear"></div>

<div class="buttonsrow span-24">
    <button type="submit" class="button positive"><?php echo Yii::t('cardscape', 'Save'); ?></button>
    <a href="<?php echo $this->createUrl('projects/index'); ?>"><?php echo Yii::t('cardscape', 'Cancel'); ?></a>
</div>
<?php
$this->endWidget();