<?php
/**
 * @var UsersController $this
 * @var User $user
 */
$this->title = Yii::t('cardscape', 'Create user');
?>

<h1><?php echo Yii::t('cardscape', 'Create a new user'); ?></h1>

<?php
echo $this->renderPartial('_form', array('user' => $user));