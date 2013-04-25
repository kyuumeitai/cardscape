<?php
/**
 * @var AttributesController $this
 */
$this->title = Yii::t('cardscape', 'Update attribute')
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'Update {name} attribute', array('{name}' => $attributeI18N->string)); ?></h1>

<?php
echo $this->renderPartial('_form', array(
    'attribute' => $attribute,
    'attributeI18N' => $attributeI18N,
    'options' => $options,
    'optionsI18N' => $optionsI18N
));