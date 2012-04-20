<?php $this->title = 'Login or Register'; ?>

<h2>Login or Register</h2>

<div id="loginarea">
    <?php $this->renderPartial('_login', array('login' => $login)); ?>
</div>

<div id="registerarea">
    <?php $this->renderPartial('_register', array('register' => $register)); ?>
</div>

<div style="clear:both;"></div>

