<?php $this->title = 'Projects'; ?>

<h1>Manage Projects</h1>
<div class="tools">
    <a href="<?php echo $this->createUrl('projects/create'); ?>">Create Project</a>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'project-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'projectId',
            'filter' => false
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("projects/update", array("id" => $data->projectId)))'
        ),
        array(
            'name' => 'expires',
            'type' => 'date',
            'value' => 'strtotime($data->expires)',
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