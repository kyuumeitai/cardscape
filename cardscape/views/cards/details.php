<?php
/**
 * @var CardsController $this
 * @var Card $card
 */
$this->title = Yii::t('cardscape', 'Card\'s detais');
?>

<div class="span-8">
    <h1 class="fancy"><?php echo Yii::t('cardscape', 'Details for {card}', array('{card}' => $card->names[0]->string)); ?></h1>
</div>
<div class="span-14 prefix-1 last stick-right">
    <a class="revisions-card-action" href="<?php echo $this->createUrl('cards/revisions', array('id' => $card->id)); ?>"><?php echo Yii::t('cardscape', 'Revision list'); ?></a>
    <a class="edit-card-action" href="<?php echo $this->createUrl('cards/update', array('id' => $card->id)); ?>"><?php echo Yii::t('cardscape', 'Change card'); ?></a>
    <a class="delete-card-action" href="<?php echo $this->createUrl('cards/delete', array('id' => $card->id)); ?>"><?php echo Yii::t('cardscape', 'Delete'); ?></a>
</div>
<div class="clear"></div>

<?php
echo $this->renderPartial('_card-details', array(
    'card' => $card,
    'attributes' => $attributes
));
?>
<div class="clear"></div>
<?php
echo $this->renderPartial('_comments', array(
    'card' => $card,
    'comments' => $card->comments
));