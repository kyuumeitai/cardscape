<?php
/**
 * @var AttributesController $this
 * @var AttributeI18N $filter
 */
$this->title = Yii::t('cardscape', 'Card attributes');
?>

<h1><?php echo Yii::t('cardscape', 'Manage card attributes'); ?></h1>

<?php
$imageBaseUrl = (Yii::app()->baseUrl . '/images/icons/');

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'attributei18n-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {summary} {pager}',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'string',
            'header' => $filter->getAttributeLabel('string'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->string, Yii::app()->createUrl("attributes/update", array("id" => $data->attributeId)))'
        ),
        array(
            'header' => Attribute::model()->getAttributeLabel('identity'),
            'type' => 'html',
            'value' => ('$data->attribute->isIdentity() ? CHtml::image("' . ($imageBaseUrl . 'tick.png') . '") : ""'),
        ),
        array(
            'header' => Attribute::model()->getAttributeLabel('order'),
            'type' => 'raw',
            'value' => '$data->attribute->order',
        ),
        array(
            'header' => Yii::t('cardscape', 'Actions'),
            'class' => 'CButtonColumn',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("attributes/update", array("id" => $data->attributeId))',
                    'imageUrl' => $imageBaseUrl . 'pencil.png'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("attributes/delete", array("id" => $data->attributeId))',
                    'imageUrl' => $imageBaseUrl . 'minus-circle.png'
                ),
                'view' => array('visible' => 'false')
            )
        )
    ),
));
?>

<div class="clear"></div>
<!-- <?php echo CHtml::link(Yii::t('cardscape', 'Add attribute'), $this->createUrl('attributes/create')); ?> -->