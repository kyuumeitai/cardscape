<div class="buttonsrow">
    <?php
    echo CHtml::submitButton(Yii::t('cardscape', 'Save')),
    CHtml::link(Yii::t('cardscape', 'Cancel'), $this->createUrl('attributes/index'), array('class' => 'cancel'));
    ?>
</div>
