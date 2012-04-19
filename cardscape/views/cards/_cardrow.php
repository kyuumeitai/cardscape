<div>
    <!-- ?show_card={$card -> id} -->
    <a href="#"><?php echo $data->name; ?></a>
    <a href="<?php echo $this->createUrl('users/show', array('id' => $data->userId)); ?>"><?php echo $data->author->username; ?></a>
</div>