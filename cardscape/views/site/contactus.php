<?php
/** @var SiteController $this */
$this->title = Yii::t('cardscape', 'Contact us');
?>

<h1><?php echo Yii::t('cardscape', 'Contact us'); ?></h1>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'contact-form',
    'enableAjaxValidation' => true
        ));
?>
<div class="row">
    <?php
    echo $form->labelEx($contact, 'name'),
    $form->textField($contact, 'name', array('maxlength' => 200));
    ?>
</div>

<div class="row">
    <?php
    echo $form->labelEx($contact, 'email'),
    $form->textField($contact, 'email', array('maxlength' => 255));
    ?>
</div>

<div class="row">
    <?php
    echo $form->labelEx($contact, 'subject'),
    $form->textField($contact, 'subject', array('maxlength' => 255));
    ?>
</div>

<div class="row">
    <?php
    echo $form->labelEx($contact, 'message'),
    $form->textArea($contact, 'message', array('rows' => 6, 'cols' => 75));
    ?>
</div>

<div class="row">
    <?php echo CHtml::submitButton(Yii::t('cardscape', 'Send')); ?>
</div>

<?php
$this->endWidget();
