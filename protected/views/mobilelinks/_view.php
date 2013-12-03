<?php
/* @var $this MobilelinksController */
/* @var $data Mobilelinks */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tagId')); ?>:</b>
	<?php echo CHtml::encode($data->tagId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imageId')); ?>:</b>
	<?php echo CHtml::encode($data->imageId); ?>
	<br />


</div>