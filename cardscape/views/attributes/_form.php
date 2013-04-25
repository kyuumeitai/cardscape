<?php
/**
 * @var AttributesController $this
 * @var Attribute $attribute
 * @var AttributeI18N $attributeI18N
 * @var AttributeOption $attributeOption
 * @var AttributeOptionI18N $attributeOptionI18N
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'attribute-form',
    'enableAjaxValidation' => true,
        ));
?>

<div class="formrow">
<?php
echo $form->labelEx($attributeI18N, 'string'),
 $form->textField($attributeI18N, 'string');
?>
</div>

<div class="formrow">
<?php
echo $form->labelEx($attribute, 'multivalue'),
 $form->checkBox($attribute, 'multivalue');
?>
</div>

<div class="formrow">
    <div class="span-11">
<?php
echo $form->labelEx($attributeOption, 'key'),
 $form->textField($attributeOption, 'key');
?>
    </div>
    <div class="span-11 prefix-1 last">
<?php
echo $form->labelEx($attributeOptionI18N, 'string'),
 $form->textField($attributeOptionI18N, 'string');
?>
    </div>
</div>

<div class="clearfix"></div>

<div class="buttonsrow">
<?php
echo CHtml::submitButton(Yii::t('cardscape', 'Save')),
 CHtml::link(Yii::t('cardscape', 'Cancel'), $this->createUrl('attributes/index'), array('class' => 'cancel'));
?>
</div>

<?php
$this->endWidget();
