<?php $this->title = 'Card Attributes'; ?>

<h1>Card Attributes</h1>

<div class="tools">
    <a href="<?php echo $this->createUrl('attributes/create'); ?>">Create Attribute</a>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'attribute-grid',
    'dataProvider' => $data,
    'template' => '{items} {pager} {summary}',
    'cssFile' => Yii::app()->baseUrl . '/css/grid.css',
    'columns' => array(
        array(
            'name' => 'attributeId',
            'filter' => false
        ),
        array(
            'header' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->defaultName(), Yii::app()->createUrl("attributes/update", array("id" => $data->attributeId)))'
        ),
        'useCount',
        array(
            'name' => 'multivalue',
            'type' => 'raw',
            'value' => '$data->multivalue ? "Yes" : "No"',
            'filter' => false
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false')
            )
        )
    ),
));