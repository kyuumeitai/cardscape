<?php
/** @var CardsController $this */
$this->title = Yii::t('cardscape', 'Cards');
?>

<div class="span-8">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Browse cards list'); ?></h1>
</div>
<div class="span-14 prefix-1 last stick-right">
    <a class="suggest-card-action" href="<?php echo $this->createUrl('cards/suggest'); ?>"><?php echo Yii::t('cardscape', 'Suggest a card'); ?></a>
    <a class="search-card-action" href="<?php echo $this->createUrl('cards/search'); ?>"><?php echo Yii::t('cardscape', 'Advanced search'); ?></a>

    <?php echo CHtml::form($this->createUrl('cards/index')); ?>
    <?php echo CHtml::textField('quicksearch', null, array('placeholder' => Yii::t('cardscape', 'search ...'))); ?>
    <?php echo CHtml::endForm(); ?>
</div>