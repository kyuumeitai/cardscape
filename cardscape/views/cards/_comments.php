<?php
Yii::app()->clientScript->registerScriptFile('', CClientScript::POS_END);
?>
<div class="card-comments">
    <h2><?php echo Yii::t('cardscape', 'User comments'); ?></h2>
    <?php
    if (count($comments) > 0) {
        foreach ($comments as $comment) {
            ?>
            <div class="comment">
                <div class="comment-message"><?php echo $comment->message ?></div>
                <div class="comment-details">
                    <span class="comment-date"><?php echo $comment->date; ?></span>
                    <span class="comment-author">
                        <?php
                        echo CHtml::link($comment->user->username, $this->createUrl('users/details', array(
                                    'id' => $comment->userId)));
                        ?>
                    </span>
                    <span class="comment-update"><?php echo CHtml::link(Yii::t('cardscape', 'Edit comment'), $this->createUrl('comments/update', array('id' => $comment->id))); ?></span>
                    <span class="comment-delete"><?php echo CHtml::link(Yii::t('cardscape', 'Delete'), $this->createUrl('comments/delete', array('id' => $comment->id))); ?></span>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="empty-comments"><?php echo Yii::t('cardscape', 'Be the first to comment this card.'); ?></div>
    <?php } ?>
    <div class="comment-options">
        <?php echo CHtml::form($this->createUrl('cards/comment', array('id' => $card->id))); ?>
        <div class="span-3"><?php echo CHtml::label(Yii::t('cardscape', 'Comment'), 'commentbox'); ?></div>
        <div class="span-20 last"><?php echo CHtml::textArea('commentbox', null, array('cols' => 50, 'rows' => 3)); ?></div>
        <div class="buttonsrow span-20 prefix-3 last"><button type="submit" class="button positive"><?php echo Yii::t('cardscape', 'Post comment'); ?></button></div>
            <?php echo CHtml::endForm(); ?>
    </div>
</div>