<?php
/**
 * @var CardsController $this
 */
$this->title = Yii::t('cardscape', 'New based card');
?>

<h1><?php echo Yii::t('cardscape', 'New based card'); ?></h1>

<?php
echo CHtml::form($this->createUrl('cards/newbased'), 'post', array('enctype' => 'multipart/form-data'));

foreach ($attributes as $attribute) {
    ?>
    <div class="row">
        <?php
        echo CHtml::label($attribute->name, 'AttributeValue_' . $attribute->id);
        if ($attribute->multivalue) {
            echo CHtml::dropDownList('AttributeValue[' . $attribute->id . ']', $attribute->value, $attribute->options);
        } else if ($attribute->large) {
            echo CHtml::textArea('AttributeValue[' . $attribute->id . ']', $attribute->value, array('cols' => 80, 'rows' => 3));
        } else {
            echo CHtml::textField('AttributeValue[' . $attribute->id . ']', $attribute->value, array('size' => 50));
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
    echo CHtml::submitButton(Yii::t('cardscape', 'Save'), array('name' => 'NewBased')),
    CHtml::link(Yii::t('cardscape', 'Cancel'), $this->createUrl('cards/index'), array('class' => 'cancel'));
    ?>
</div>

<?php
echo CHtml::endForm();
