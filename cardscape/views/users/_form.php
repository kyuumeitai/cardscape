<?php
/** @var UsersController $this */
/** @var CActiveForm $form */
$form = $this->beginWidget('CActiveForm', array('id' => 'user-form'));
?>

<div class="span-4"><?php echo $form->labelEx($user, 'username'); ?></div>
<div class="span-20 last">
    <?php echo $form->textField($user, 'username', array('size' => 25, 'maxlength' => 25)); ?>
</div>
<div class="clear"></div>

<div class="span-4"><?php echo $form->labelEx($user, 'email'); ?></div>
<div class="span-20 last">
    <?php echo $form->textField($user, 'email', array('size' => 25, 'maxlength' => 255)); ?>
</div>
<div class="clear"></div>

<div class="span-4"><?php echo $form->labelEx($user, 'role'); ?></div>
<div class="span-20 last">
    <?php echo $form->dropDownList($user, 'role', User::getRolesArray()); ?>
</div>
<div class="clear"></div>

<div class="span-4"><?php echo $form->labelEx($user, 'language'); ?></div>
<div class="span-20 last">
    <?php echo $form->textField($user, 'language', array('maxlength' => 5)); ?>
</div>
<div class="clear"></div>

<div class="span-4"><?php echo $form->labelEx($user, 'activationCompleted'); ?></div>
<div class="span-20 last">
    <?php
    echo $form->dropDownList($user, 'activationCompleted', array(
        0 => Yii::t('cardscape', 'No'), 1 => Yii::t('cardscape', 'Yes')
    ));
    ?>
</div>
<div class="clear"></div>

<div class="buttonsrow span-24">
    <button type="submit" class="button positive"><?php echo Yii::t('cardscape', 'Save'); ?></button>
    <a href="<?php echo $this->createUrl('users/index'); ?>"><?php echo Yii::t('cardscape', 'Cancel'); ?></a>
</div>

<?php
$this->endWidget();
