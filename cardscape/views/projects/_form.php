<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'project-form',
    'enableAjaxValidation' => true,
        ));
?>

<fieldset>
    <legend>General</legend>
    <div class="row">
        <?php
        echo $form->labelEx($project, 'name'),
        $form->textField($project, 'name', array('size' => 50, 'maxlength' => 50)),
        $form->error($project, 'name');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($project, 'description'),
        $form->textField($project, 'description', array('size' => 100, 'maxlength' => 255)),
        $form->error($project, 'description');
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
        echo $form->error($project, 'expires');
        ?>
    </div>

    <div class="row buttons">
        <?php
        echo CHtml::submitButton($project->isNewRecord ? 'Create' : 'Save'),
        CHtml::link('Cancel', $this->createUrl('projects/index'), array('class' => 'cancel'));
        ?>
    </div>
</fieldset>
<?php
$this->endWidget();