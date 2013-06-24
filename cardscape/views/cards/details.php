<?php
/**
 * @var CardsController $this
 * @var Card $card
 */
$this->title = Yii::t('cardscape', 'Card\'s detais');
?>

<h1><?php echo Yii::t('cardscape', 'Details for {card}', array('{card}' => $card->names[0]->string)); ?></h1>
<div class="grid-header-tools">
    <a class="revisions-card-action" href="<?php echo $this->createUrl('cards/revisions', array('id' => $card->id)); ?>"><?php echo Yii::t('cardscape', 'Revision list'); ?></a>
    <a class="edit-card-action" href="<?php echo $this->createUrl('cards/update', array('id' => $card->id)); ?>"><?php echo Yii::t('cardscape', 'Change card'); ?></a>
    <a class="delete-card-action" href="<?php echo $this->createUrl('cards/delete', array('id' => $card->id)); ?>"><?php echo Yii::t('cardscape', 'Delete'); ?></a>
</div>

<?php
echo $this->renderPartial('_card-details', array(
    'card' => $card,
    'attributes' => $attributes
));

echo $this->renderPartial('_comments', array(
    'card' => $card,
    'comments' => $card->comments
));