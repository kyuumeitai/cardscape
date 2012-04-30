<?php $this->title = 'Users'; ?>

<h1>Manage Users</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'columns' => array(
        array(
            'name' => 'userId',
            'filter' => false
        ),
        array(
            'name' => 'username',
            'type' => 'raw',
            'value' => 'CHtml::link($data->username, Yii::app()->createUrl("users/update", array("id" => $data->userId)))'
        ),
        'email:email',
        array(
            'name' => 'role',
            'type' => 'raw',
            'value' => 'User::roleNameById($data->role)',
            'filter' => User::roleNames()
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            //TODO: add reset password icon and action
            'buttons' => array(
                'view' => array('visible' => 'false')
            )
        )
    ),
));
?>
