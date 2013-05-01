s<?php
/**
 * @var UsersController $this
 * @var User $user
 */
$this->title = Yii::t('cardscape', 'Your Profile');
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'Update you profile'); ?></h1>

<?php
echo $this->renderPartial('_form', array('user' => $user));