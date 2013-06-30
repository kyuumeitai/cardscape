<?php
/**
 * @var CardsController $this
 * @var Card $card
 */
$this->title = Yii::t('cardscape', 'Card\'s detais');
?>

<h1><?php echo Yii::t('cardscape', 'Details for {card}', array('{card}' => '//TODO:')); ?></h1>

<div class="grid-header-tools">
    <?php
    echo CHtml::link(Yii::t('cardscape', 'Revisions'), $this->createUrl('cards/revisions', array('id' => $card->id))),
    CHtml::link(Yii::t('cardscape', 'Change'), $this->createUrl('cards/update', array('id' => $card->id))),
    CHtml::link(Yii::t('cardscape', 'New based'), $this->createUrl('cards/newbased', array('id' => $card->id)));

    if (!Yii::app()->user->isGuest && Yii::app()->user->role == 'administrator') {
        echo CHtml::link(Yii::t('cardscape', 'Delete'), $this->createUrl('cards/delete', array('id' => $card->id)));
    }
    ?>
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
