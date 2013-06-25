<?php
/**
 * @var AttributesController $this
 */
$this->title = Yii::t('cardscape', 'Create attribute');
?>

<h1><?php echo Yii::t('cardscape', 'Create new attribute'); ?></h1>

<?php
echo $this->renderPartial('_form', array(
    'attribute' => $attribute,
    'attributeI18N' => $attributeI18N,
    'options' => $options,
    'optionsI18N' => $optionsI18N
));
