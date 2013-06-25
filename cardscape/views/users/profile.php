s<?php
/**
 * @var UsersController $this
 * @var User $user
 */
$this->title = Yii::t('cardscape', 'Your Profile');
?>

<h1><?php echo Yii::t('cardscape', 'Update your profile'); ?></h1>

<?php
echo $this->renderPartial('_form', array('user' => $user));