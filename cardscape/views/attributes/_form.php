<?php
/**
 * @var AttributesController $this
 * @var Attribute $attribute
 * @var AttributeI18N $attributeI18N
 * @var AttributeOption $attributeOption
 * @var AttributeOptionI18N $attributeOptionI18N
 */
$baseUrl = Yii::app()->baseUrl;
echo CHtml::form();
?>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attributeI18N, 'string'),
    CHtml::activeTextField($attributeI18N, 'string');
    ?>
</div>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attribute, 'identity'),
    CHtml::activeCheckBox($attribute, 'identity');
    ?>
</div>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attribute, 'searchable'),
    CHtml::activeCheckBox($attribute, 'searchable');
    ?>
</div>

<div class="row">
    <?php
    echo CHtml::activeLabelEx($attribute, 'order'),
    CHtml::activeTextField($attribute, 'order');
    ?>
</div>

<div>
    <?php
    echo CHtml::activeLabelEx($attribute, 'multivalue'),
    CHtml::activeCheckBox($attribute, 'multivalue');
    ?>
</div>

<!-- //TODO: update to new structure -->
<div class="multivalue-lines">
    <!-- hidden template line -->
    <div class="multivalue-line-hidden hidden">
        <div class="span-1"><img class="rm-multiline" src="<?php echo $baseUrl; ?>/images/icons/minus-circle.png"/></div>
        <div class="span-3">
            <?php echo CHtml::label(AttributeOption::model()->getAttributeLabel('key'), 'templateOption', array('class' => 'required option')); ?>
            <span class="required">*</span>
        </div>
        <div class="span-8"><?php echo CHtml::textField('templateOption'); ?></div>

        <!-- second column -->
        <div class="span-4">
            <?php echo CHtml::label(AttributeOptionI18N::model()->getAttributeLabel('string'), 'templateTranslation', array('class' => 'required translation')); ?>
            <span class="required">*</span>
        </div>
        <div class="span-8 last"><?php echo CHtml::textField('templateTranslation'); ?></div>
    </div>

    <!-- //TODO: update to new structure -->
    <?php foreach ($options as $index => $option) { ?>
        <div class="multivalue-line-<?php echo $index; ?>">
            <div class="span-1"><img class="rm-multiline" data-line="<?php echo $index; ?>" src="<?php echo $baseUrl; ?>/images/icons/minus-circle.png"/></div>

            <div class="span-3">
                <?php echo CHtml::label(AttributeOption::model()->getAttributeLabel('key'), "AttributeOption_key_{$index}", array('class' => 'required')); ?>
                <span class="required">*</span>
            </div>
            <div class="span-8"><?php echo CHtml::textField("AttributeOption[key][{$index}]", $option); ?></div>

            <!-- second column -->
            <div class="span-3">
                <?php echo CHtml::label(AttributeOptionI18N::model()->getAttributeLabel('string'), "AttributeOptionI18N_string_{$index}", array('class' => 'required')); ?>
                <span class="required">*</span>
            </div>
            <div class="span-8 last"><?php echo CHtml::textField("AttributeOptionI18N[string][{$index}]", $optionsI18N[$index]); ?></div>
        </div>
    <?php } ?>
</div>

<div>
    <span class="hidden multiline-count"><?php echo count($options); ?></span>
    <span class="add-multiline"><?php echo Yii::t('cardscape', 'Add new line'); ?></span>
</div>

<div class="row">
    <?php
    echo CHtml::submitButton(Yii::t('cardscape', 'Save')),
    CHtml::link(Yii::t('cardscape', 'Cancel'), $this->createUrl('attributes/index'));
    ?>
</div>

<?php
echo CHtml::endForm();
