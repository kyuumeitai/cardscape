<?php
/**
 * @var AttributesController $this
 * @var Attribute $attribute
 * @var AttributeI18N $attributeI18N
 * @var AttributeOption $attributeOption
 * @var AttributeOptionI18N $attributeOptionI18N
 */
$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerScript('initAttrJs', 'cardscape.attributes.init();', CClientScript::POS_END);

echo CHtml::form();
?>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attributeI18N, 'string'),
    CHtml::activeTextField($attributeI18N, 'string', array('size' => 50)),
    CHtml::error($attributeI18N, 'string');
    ?>
</div>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attribute, 'identity'),
    CHtml::activeCheckBox($attribute, 'identity'),
    CHtml::error($attribute, 'identity');
    ?>
</div>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attribute, 'searchable'),
    CHtml::activeCheckBox($attribute, 'searchable'),
    CHtml::error($attribute, 'searchable');
    ?>
</div>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attribute, 'order'),
    CHtml::activeTextField($attribute, 'order'),
    CHtml::error($attribute, 'order');
    ?>
</div>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attribute, 'large'),
    CHtml::activeCheckBox($attribute, 'large'),
    CHtml::error($attribute, 'large');
    ?>
</div>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attribute, 'multivalue'),
    CHtml::activeCheckBox($attribute, 'multivalue'),
    CHtml::error($attribute, 'multivalue');
    ?>
</div>

<div class="multivalue-lines">
    <!-- hidden template line -->
    <div class="multivalue-line-hidden hidden row">
        <img class="rm-multiline" src="<?php echo $baseUrl; ?>/images/icons/minus-circle.png"/>
        <?php
        echo CHtml::label(AttributeOption::model()->getAttributeLabel('key'), 'templateOption', array('class' => 'option')),
        CHtml::textField('templateOption'),
        CHtml::label(AttributeOptionI18N::model()->getAttributeLabel('string'), 'templateTranslation', array('class' => 'translation')),
        CHtml::textField('templateTranslation');
        ?>
    </div>

    <?php foreach ($options as $index => $option) { ?>
        <div class="row multivalue-line-<?php echo $index; ?>">
            <img class="rm-multiline" data-line="<?php echo $index; ?>" src="<?php echo $baseUrl; ?>/images/icons/minus-circle.png"/>
            <?php
            echo CHtml::label(AttributeOption::model()->getAttributeLabel('key'), "AttributeOption_key_{$index}"),
            CHtml::textField("AttributeOption[key][{$index}]", $option),
            CHtml::label(AttributeOptionI18N::model()->getAttributeLabel('string'), "AttributeOptionI18N_string_{$index}"),
            CHtml::textField("AttributeOptionI18N[string][{$index}]", $optionsI18N[$index]);
            ?>
        </div>
    <?php } ?>
</div>

<div class="row">
    <span class="hidden multiline-count"><?php echo count($options); ?></span>
    <a href="#" class="add-multiline"><?php echo Yii::t('cardscape', 'Add new line'); ?></a>
</div>

<div class="row last">
    <?php
    echo CHtml::submitButton(Yii::t('cardscape', 'Save')),
    CHtml::link(Yii::t('cardscape', 'Cancel'), $this->createUrl('attributes/index'), array('class' => 'cancel'));
    ?>
</div>

<?php
echo CHtml::endForm();
