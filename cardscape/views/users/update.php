<?php $this->title = 'Update User' ?>

<h1>Update <?php echo $user->username; ?>'s Information</h1>

<?php echo $this->renderPartial('_form', array('user' => $user)); ?>