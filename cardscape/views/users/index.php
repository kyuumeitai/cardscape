<?php
$this->title = 'Users';

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/grids.css');
?>

<h1>Manage Users</h1>

<div class="tools">
    <a href="<?php echo $this->createUrl('users/create'); ?>">Create User</a>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'cssFile' => Yii::app()->baseUrl . '/css/grid.css',
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
            'buttons' => array(
                'view' => array('visible' => 'false'),
                'reset' => array(
                    'label' => 'Reset Password',
                    'url' => 'Yii::app()->createUrl("users/reset", array("id" => $data->userId)))',
                    'imageUrl' => Yii::app()->baseUrl . '/images/icons/key-solid.png',
                    'click' => 'function () { return confirm("Are you sure you want to reset this user\'s password?"); }'
                )
            ),
            'template' => '{update} {reset} {delete}'
        )
    ),
));
