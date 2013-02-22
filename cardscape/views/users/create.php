<?php
/** @var UsersController $this */
$this->title = Yii::t('cardscape', 'Create User');
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'Create new user'); ?></h1>

<?php echo $this->renderPartial('_form', array('user' => $user)); ?>