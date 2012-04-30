<?php $this->title = 'Login or Register'; ?>

<h1>Login or Register</h1>

<div class="halfleft">
    <?php $this->renderPartial('_login', array('login' => $login)); ?>
</div>

<div class="halfright">
    <?php $this->renderPartial('_register', array('register' => $register)); ?>
</div>

<div style="clear:both;"></div>

