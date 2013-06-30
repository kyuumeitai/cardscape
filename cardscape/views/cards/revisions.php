<?php
/** @var CardsController $this */
$this->title = Yii::t('cardscape', 'Card Revisions');
?>

<h1><?php echo Yii::t('cardscape', 'Revisions for {card}', array('{card}' => $cardName)); ?></h1>

<div class="grid-header-tools">
    <?php
    echo CHtml::link(Yii::t('cardscape', 'Browse'), $this->createUrl('cards/index')),
    CHtml::link(Yii::t('cardscape', 'Change'), $this->createUrl('cards/update', array('id' => $card->id))),
    CHtml::link(Yii::t('cardscape', 'New based'), $this->createUrl('cards/newbased', array('id' => $card->id)));
    ?>
</div>

<?php foreach ($revisions as $revision) { ?>
    <h2><?php echo Yii::t('cardscape', 'Revision {number}', array('{number}' => $revision->number)); ?></h2>
    <table class="card-data">
        <tbody>
            <?php foreach ($revision->attributes as $attribute) { ?>
                <tr>
                    <td><?php echo $attribute->name; ?></td>
                    <td><?php echo $attribute->value; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="revision-author">
        <?php
        echo Yii::t('cardscape', 'Revision at {date} by {author}.', array(
            '{date}' => $revision->date,
            '{author}' => CHtml::link($revision->author, $this->createUrl('users/details', array('id' => $revision->authorId)))
        ));

        if (!Yii::app()->user->isGuest && Yii::app()->user->role == 'administrator') {
            echo CHtml::link(Yii::t('cardscape', 'Delete this revision'), $this->createUrl('cards/deleterevision', array('id' => $revision->id)));
        }
        ?>
    </div>
    <?php
}