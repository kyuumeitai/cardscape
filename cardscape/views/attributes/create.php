<?php
/**
 * @var AttributesController $this
 */
$this->title = Yii::t('cardscape', 'Create attribute')
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'Create new attribute'); ?></h1>

<?php
echo $this->renderPartial('_form');
