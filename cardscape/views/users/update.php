<?php
/**
 * @var UsersController $this
 * @var User $user
 */
$this->title = Yii::t('cardscape', 'Update user');
?>

<h1><?php echo Yii::t('cardscape', 'Update {username}\'s information', array('{username}' => $user->username)); ?></h1>

<?php echo $this->renderPartial('_form', array('user' => $user)); ?>