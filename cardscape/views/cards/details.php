<?php
/**
 * @var CardsController $this
 * @var Card $card
 */
$this->title = Yii::t('cardscape', 'Card\'s detais');
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'Details for {card}', array('{card}' => $card->names[0]->string)); ?></h1>

<?php
echo $this->renderPartial('_card-details', array(
    'card' => $card,
    'attributes' => $attributes
)),
 $this->renderPartial('_comments', array(
    'card' => $card,
    'comments' => $card->comments
));