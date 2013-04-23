<?php
/**
 * @var AttributesController $this
 */
$this->title = Yii::t('cardscape', 'Card attributes');
?>

<div class="span-8">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Manage card attributes'); ?></h1>
</div>
<div class="span-14 prefix-1 last stick-right">
    <!-- <a class="new-user-action" href="<?php echo $this->createUrl('attributes/create'); ?>"><?php echo Yii::t('cardscape', 'Add attribute'); ?></a> -->
</div>
<?php
/*$this->widget('zii.widgets.grid.CGridView', array(
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
));*/
