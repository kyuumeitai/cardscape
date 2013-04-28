<?php
/**
 * @var AttributesController $this
 * @var AttributeI18N $filter
 */
$this->title = Yii::t('cardscape', 'Card attributes');
?>

<div class="span-8">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Manage card attributes'); ?></h1>
</div>
<div class="span-14 prefix-1 last stick-right">
    <a class="new-attribute-action" href="<?php echo $this->createUrl('attributes/create'); ?>"><?php echo Yii::t('cardscape', 'Add attribute'); ?></a>
</div>
<?php
$imageBaseUrl = (Yii::app()->baseUrl . '/images/icons/');

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'attributei18n-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'string',
            'header' => $filter->getAttributeLabel('string'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->string, Yii::app()->createUrl("attributes/update", array("id" => $data->attributeId)))'
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
