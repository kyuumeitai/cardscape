<?php
/**
 * @var CardsController $this
 */
$this->title = Yii::t('cardscape', 'Suggest new card');
?>
<h1 class = "fancy"><?php echo Yii::t('cardscape', 'Suggest a new card'); ?></h1>

<?php
echo CHtml::form($this->createUrl('cards/suggest'), 'post', array('enctype' => 'multipart/form-data'));

foreach ($attributes as $attribute) {
    ?>
    <div class="span-4"><?php echo CHtml::label($attribute->name, 'AttributeValue_' . $attribute->id); ?></div>
    <div class="span-19 last">
        <?php
        if ($attribute->multivalue) {
            echo CHtml::dropDownList('AttributeValue[' . $attribute->id . ']', null, $attribute->options);
        } else {
            echo CHtml::textField('AttributeValue[' . $attribute->id . ']');
        }
        ?>
    </div>
    <?php
}
?>

<div class="span-4"><?php echo CHtml::label(Yii::t('cardscape', 'Card image'), 'image'); ?></div>
<div class="span-19"><?php echo CHtml::fileField('image'); ?></div>

<div class="buttonsrow span-23">
    <button type="submit" name="Suggestion" class="button positive"><?php echo Yii::t('cardscape', 'Save'); ?></button>
    <a href="<?php echo $this->createUrl('cards/index'); ?>"><?php echo Yii::t('cardscape', 'Cancel'); ?></a>
</div>

<?php
echo CHtml::endForm();
