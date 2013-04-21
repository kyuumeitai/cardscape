<?php
/** @var UsersController $this */
$this->title = Yii::t('cardscape', 'Users');
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'Manage Users'); ?></h1>

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
            'value' => '$data->getRoleName()',
            'filter' => User::getRolesArray()
        ),
        array(
            'header' => Yii::t('cardscape', 'Actions'),
            'class' => 'CButtonColumn'
        )
    ),
));
?>
<div>
    <a href="<?php echo $this->createUrl('users/create'); ?>"><?php echo Yii::t('cardscape', 'Add user'); ?></a>
</div>