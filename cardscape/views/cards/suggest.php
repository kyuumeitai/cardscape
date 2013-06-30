<?php
/**
 * @var CardsController $this
 */
$this->title = Yii::t('cardscape', 'Suggest new card');
?>
<h1><?php echo Yii::t('cardscape', 'Suggest a new card'); ?></h1>

<?php
echo CHtml::form($this->createUrl('cards/suggest'), 'post', array('enctype' => 'multipart/form-data'));

foreach ($attributes as $attribute) {
    ?>
    <div class="row">
        <?php
        echo CHtml::label($attribute->name, 'AttributeValue_' . $attribute->id);
        if ($attribute->multivalue) {
            echo CHtml::dropDownList('AttributeValue[' . $attribute->id . ']', null, $attribute->options);
        } else if ($attribute->large) {
            echo CHtml::textArea('AttributeValue[' . $attribute->id . ']', null, array('cols' => 80, 'rows' => 3));
        } else {
            echo CHtml::textField('AttributeValue[' . $attribute->id . ']', null, array('size' => 50));
        }
        ?>
    </div>
<?php } ?>

<div class="row">
    <?php
    echo CHtml::label(Yii::t('cardscape', 'Card image'), 'image'),
    CHtml::fileField('image');
    ?>
</div>

<div class="row last">
    <?php
    echo CHtml::submitButton(Yii::t('cardscape', 'Save')),
    CHtml::link(Yii::t('cardscape', 'Cancel'), $this->createUrl('cards/index'), array('class' => 'cancel'));
    ?>
</div>

<?php
echo CHtml::endForm();
