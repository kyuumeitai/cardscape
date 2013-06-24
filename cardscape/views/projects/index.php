<?php
/**
 * @var ProjectsController $this
 * @var Project $filter
 */
$this->title = Yii::t('cardscape', 'Projects');
?>

<h1><?php echo Yii::t('cardscape', 'Manage projects'); ?></h1>
<div class="grid-header-tools">
    <a class="new-project-action" href="<?php echo $this->createUrl('projects/create'); ?>"><?php echo Yii::t('cardscape', 'Add project'); ?></a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'project-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {summary} {pager}',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("projects/update", array("id" => $data->projectId)))'
        ),
        array(
            'header' => Yii::t('cardscape', 'Actions'),
            'class' => 'CButtonColumn',
            'buttons' => array(
                'update' => array(
                    'imageUrl' => $imageBaseUrl . 'pencil.png'
                ),
                'delete' => array(
                    'imageUrl' => $imageBaseUrl . 'minus-circle.png'
                ),
                'view' => array('visible' => 'false')
            )
        )
    ),
));
