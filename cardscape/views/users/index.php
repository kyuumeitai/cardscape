<?php
/**
 * @var UsersController $this
 * @var User $filter
 */
$this->title = Yii::t('cardscape', 'Users');
?>

<h1><?php echo Yii::t('cardscape', 'Manage users'); ?></h1>

<?php
$imageBaseUrl = (Yii::app()->baseUrl . '/images/icons/');

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {summary} {pager}',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'username',
            'type' => 'raw',
            'value' => 'CHtml::link($data->username, Yii::app()->createUrl("users/update", array("id" => $data->id)))'
        ),
        'email:email',
        array(
            'name' => 'activationCompleted',
            'type' => 'raw',
            'value' => '($data->activationCompleted ? Yii::t("cardscape", "Yes") : Yii::t("cardscape", "No"))',
            'filter' => array(0 => Yii::t('cardscape', 'No'), 1 => Yii::t('cardscape', 'Yes'))
        ),
        array(
            'name' => 'role',
            'type' => 'raw',
            'value' => '$data->getRoleName($data->role)',
            'filter' => User::getRolesArray()
        ),
        array(
            'header' => Yii::t('cardscape', 'Actions'),
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false')
            )
        )
    ),
));

?>

<div class="clear"></div>
<!-- <?php echo CHtml::link(Yii::t('cardscape', 'Add user'), $this->createUrl('users/create')); ?> -->