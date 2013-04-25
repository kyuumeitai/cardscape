<?php
/** @var CardsController $this */
$this->title = Yii::t('cardscape', 'Cards');
?>

<div class="span-8">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Browse cards list'); ?></h1>
</div>
<div class="span-14 prefix-1 last stick-right">
    <?php
    echo CHtml::form($this->createUrl('cards/index'));
    echo CHtml::textField('quicksearch', null, array('placeholder' => Yii::t('cardscape', 'search ...')));
    echo CHtml::endForm();
    ?>
</div>