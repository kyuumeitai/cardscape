<?php $this->title = 'Create Attribute'; ?>

<h1>Create Attribute</h1>

<?php echo CHtml::beginForm(); ?>

<fieldset>
    <legend>General</legend>
    <div class="row">
        <?php
        echo CHtml::label('Name', 'name'),
        CHtml::textField('name');
        ?>
    </div>

    <div class="row">
        <?php
        echo CHtml::label('Multi-value', 'multivalue'),
        CHtml::checkBox('multivalue', null, array('uncheckValue' => 0));
        ?>
    </div>
</fieldset>

<div class="row buttons">
    <?php
    echo CHtml::submitButton('Create'),
    CHtml::link('Cancel', $this->createUrl('attributes/index'), array('class' => 'cancel'));
    ?>
</div>
<?php
echo CHtml::endForm();