<?php
/** @var UsersController $this */
$this->title = Yii::t('interface', 'Users');
?>

<h1><?php echo Yii::t('interface', 'Manage Users'); ?></h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'cssFile' => false,
    'columns' => array(
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
            'class' => 'CButtonColumn'
        )
    ),
));
