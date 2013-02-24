<?php
/** @var UsersController $this */
/** @√ar CActiveForm $form */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true
        ));
?>

<fieldset>
    <legend>General</legend>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'username'),
        $form->textField($user, 'username', array('size' => 25, 'maxlength' => 25));
        //$form->error($user, 'username');
        ?>
    </div>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'email'),
        $form->textField($user, 'email', array('size' => 25, 'maxlength' => 255));
        //$form->error($user, 'email');
        ?>
    </div>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'role'),
        $form->dropDownList($user, 'role', User::getRolesArray());
        //$form->error($user, 'role');
        ?>
    </div>
    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'language'),
        $form->textField($user, 'language', array('maxlength' => 5));
        //$form->error($user, 'email');
        ?>
    </div>
</fieldset>

<div class="buttonsrow">
    <?php
    echo CHtml::submitButton(Yii::t('cardscape', 'Save')),
    CHtml::link('Cancel', $this->createUrl('users/index'))
    ?>
</div>

<?php
$this->endWidget();
