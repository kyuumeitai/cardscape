<?php
/**
 * @var UsersController $this
 * @var User $filter
 */
$this->title = Yii::t('cardscape', 'Users');
?>

<div class="span-9">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Manage users'); ?></h1>
</div>
<div class="span-14 prefix-1 last stick-right">
    <a class="new-user-action" href="<?php echo $this->createUrl('users/create'); ?>"><?php echo Yii::t('cardscape', 'Add user'); ?></a>
</div>
<div class="clear"></div>
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
            'template' => '{reset} {update} {delete}',
            'buttons' => array(
                'reset' => array(
                    'label' => Yii::t('cardscape', 'Reset password/activation'),
                    'url' => 'Yii::app()->createUrl("users/reset", array("id" => $data->id))',
                    'imageUrl' => $imageBaseUrl . 'key--arrow.png',
                    'click' => 'js:cardscape.resetUserActivation'
                ),
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
