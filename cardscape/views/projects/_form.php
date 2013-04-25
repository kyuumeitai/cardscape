<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'project-form',
    'enableAjaxValidation' => true,
        ));
?>
<div class="formrow">
    <?php
    echo $form->labelEx($project, 'name'),
    $form->textField($project, 'name', array('size' => 50, 'maxlength' => 50)),
    $form->error($project, 'name');
    ?>
</div>

<div class="formrow">
    <?php
    echo $form->labelEx($project, 'description'),
    $form->textField($project, 'description', array('size' => 100, 'maxlength' => 255)),
    $form->error($project, 'description');
    ?>
</div>

<div class="formrow">
    <?php
    echo $form->labelEx($project, 'expires');
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $project,
        'attribute' => 'expires',
        'options' => array(
            'showAnim' => 'fold'
        ),
    ));
    echo $form->error($project, 'expires');
    ?>
</div>

<div class="buttonsrow">
    <button type="submit" class="button positive"><?php echo Yii::t('cardscape', 'Save'); ?></button>
    <a href="<?php echo $this->createUrl('projects/index'); ?>"><?php echo Yii::t('cardscape', 'Cancel'); ?></a>
</div>
<?php
$this->endWidget();