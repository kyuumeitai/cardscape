<?php
/** @var CardsController $this */
$this->title = Yii::t('cardscape', 'Card Revisions');
?>

<h1><?php echo Yii::t('cardscape', 'Revisions for {card}', array('{card}' => $cardName)); ?></h1>

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
        ?>
    </div>
    <?php
}