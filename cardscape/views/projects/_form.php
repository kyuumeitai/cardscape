<?php
$form = $this->beginWidget('CActiveForm', array('id' => 'project-form'));
?>
<div class="row">
    <?php
    echo $form->labelEx($project, 'name'),
    $form->textField($project, 'name', array('size' => 30, 'maxlength' => 50));
    ?>
</div>

<div class="row">
    <?php
    echo $form->labelEx($project, 'description'),
    $form->textField($project, 'description', array('size' => 30, 'maxlength' => 255));
    ?>
</div>

<div class="row">
    <?php
    echo $form->labelEx($project, 'expires');

    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $project,
        'attribute' => 'expires',
        'options' => array(
            'showAnim' => 'fold'
        ),
    ));
    ?>
</div>

<div class="row">
    <button type="submit" class="button positive"><?php echo Yii::t('cardscape', 'Save'); ?></button>
    <a href="<?php echo $this->createUrl('projects/index'); ?>"><?php echo Yii::t('cardscape', 'Cancel'); ?></a>
</div>
<?php
$this->endWidget();