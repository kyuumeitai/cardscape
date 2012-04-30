<?php $form = $this->beginWidget('CActiveForm', array('id' => 'user-form', 'enableAjaxValidation' => true)); ?>

<fieldset>
    <legend>General</legend>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'username'),
        $form->textField($user, 'username', array('size' => 25, 'maxlength' => 25)),
        $form->error($user, 'username');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'email'),
        $form->textField($user, 'email', array('size' => 50, 'maxlength' => 255)),
        $form->error($user, 'email');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'showEmail'),
        $form->checkBox($user, 'showEmail'),
        $form->error($user, 'showEmail');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'role'),
        $form->dropDownList($user, 'role', User::roleNames()),
        $form->error($user, 'role');
        ?>
    </div>
</fieldset>

<fieldset>
    <legend>Social</legend>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'location'),
        $form->textField($user, 'location', array('size' => 50, 'maxlength' => 255)),
        $form->error($user, 'location');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'msn'),
        $form->textField($user, 'msn', array('size' => 50, 'maxlength' => 255)),
        $form->error($user, 'msn');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'skype'),
        $form->textField($user, 'skype', array('size' => 50, 'maxlength' => 255)),
        $form->error($user, 'skype');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'twitter'),
        $form->textField($user, 'twitter', array('size' => 50, 'maxlength' => 50)),
        $form->error($user, 'twitter');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'about'),
        $form->textField($user, 'about', array('size' => 100, 'maxlength' => 255)),
        $form->error($user, 'about');
        ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($user, 'avatar'),
        $form->textField($user, 'avatar', array('size' => 100, 'maxlength' => 255)),
        $form->error($user, 'avatar');
        ?>
    </div>
</fieldset>
<div class="row buttons">
    <?php
    echo CHtml::submitButton($user->isNewRecord ? 'Create' : 'Save'),
    CHtml::link('Cancel', $this->createUrl('users/index'), array('class' => 'cancel'))
    ?>
</div>

<?php
$this->endWidget();