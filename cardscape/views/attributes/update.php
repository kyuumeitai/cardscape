<?php
/**
 * @var AttributesController $this
 */
$this->title = Yii::t('cardscape', 'Update attribute');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/attributes.form.js', CClientScript::POS_END);
?>

<h1><?php echo Yii::t('cardscape', 'Update "{name}" attribute', array('{name}' => $attributeI18N->string)); ?></h1>

<?php
echo $this->renderPartial('_form', array(
    'attribute' => $attribute,
    'attributeI18N' => $attributeI18N,
    'options' => $options,
    'optionsI18N' => $optionsI18N
));