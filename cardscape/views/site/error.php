<?php
/** @var SiteController $this */
$this->title = Yii::t('cardscape', ' Error');
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'Error '), '&nbsp;', $code; ?></h1>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>