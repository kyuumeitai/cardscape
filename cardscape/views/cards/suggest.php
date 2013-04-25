<?php
/**
 * @var CardsController $this
 */
$this->title = Yii::t('cardscape', 'Suggest new card');
?>
<h1 class = "fancy"><?php echo Yii::t('cardscape', 'Suggest a new card'); ?></h1>

<?php
echo CHtml::form();

foreach ($attributes as $attribute) {
    ?>
    <div class="span-4"><?php echo CHtml::label($attribute->name, 'attrvalue' + $attribute->id); ?></div>
    <div class="span-19 last">
        <?php
        if ($attribute->multivalue) {
            echo CHtml::dropDownList('attrvalue' . $attribute->id, null, $attribute->options);
        } else {
            echo CHtml::textField('attrvalue' . $attribute->id);
        }
        ?>
    </div>
    <?php
}
?>

<div class="buttonsrow span-23">
    <button type="submit" class="button positive"><?php echo Yii::t('cardscape', 'Save'); ?></button>
    <a href="<?php echo $this->createUrl('cards/index'); ?>"><?php echo Yii::t('cardscape', 'Cancel'); ?></a>
</div>

<?php
echo CHtml::endForm();
