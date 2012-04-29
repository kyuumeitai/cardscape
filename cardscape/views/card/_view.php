<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cardId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cardId), array('view', 'id'=>$data->cardId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::encode($data->userId); ?>
	<br />


</div>