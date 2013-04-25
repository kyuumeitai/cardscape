<?php
/** @var UsersController $this */
/** @var CActiveForm $form */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true
        ));
?>

<div class="formrow">
    <?php
    echo $form->labelEx($user, 'username'),
    $form->textField($user, 'username', array('size' => 25, 'maxlength' => 25));
    ?>
</div>

<div class="formrow">
    <?php
    echo $form->labelEx($user, 'email'),
    $form->textField($user, 'email', array('size' => 25, 'maxlength' => 255));
    ?>
</div>

<div class="formrow">
    <?php
    echo $form->labelEx($user, 'role'),
    $form->dropDownList($user, 'role', User::getRolesArray());
    ?>
</div>
<div class="formrow">
    <?php
    echo $form->labelEx($user, 'language'),
    $form->textField($user, 'language', array('maxlength' => 5));
    ?>
</div>

<div class="buttonsrow">
    <button type="submit" class="button positive"><?php echo Yii::t('cardscape', 'Save'); ?></button>
    <a href="<?php echo $this->createUrl('users/index'); ?>"><?php echo Yii::t('cardscape', 'Cancel'); ?></a>
</div>

<?php
$this->endWidget();
