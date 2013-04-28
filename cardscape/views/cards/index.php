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
</div>

<div class="cardlisting">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'user-grid',
        'dataProvider' => $filter->search(),
        'filter' => $filter,
        'template' => '{items} {pager} {summary}',
        'cssFile' => false,
        'columns' => array(
            array(
                'header' => CHtml::encode($filter->getAttributeLabel('name')),
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, Yii::app()->createUrl("cards/details", array("id" => $data->id)))'
            ),
            array(
                'header' => CHtml::encode($filter->getAttributeLabel('revision')),
                'name' => 'revision',
                'type' => 'raw',
                'value' => 'CHtml::link($data->revision, Yii::app()->createUrl("cards/revision", array("id" => $data->revisionId)))',
                'filter' => false
            ),
            array(
                'header' => CHtml::encode($filter->getAttributeLabel('date')),
                'name' => 'date',
                'type' => 'date'
            ),
            array(
                'header' => CHtml::encode($filter->getAttributeLabel('status')),
                'name' => 'status',
                'type' => 'raw',
                'value' => 'Card::getStatusName($data->status)',
                'filter' => Card::getCardStatusesArray()
            ),
            array(
                'header' => CHtml::encode($filter->getAttributeLabel('author')),
                'name' => 'author',
                'type' => 'raw',
                'value' => 'CHtml::link($data->author, Yii::app()->createUrl("users/details", array("id" => $data->authorId)))'
            ),
            array(
                'header' => Yii::t('cardscape', 'Actions'),
                'class' => 'CButtonColumn'
            )
        )
    ));
    ?>
</div>