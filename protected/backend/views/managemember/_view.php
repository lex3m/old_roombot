<?php
/* @var $this ManagememberController */
/* @var $data Member */
?>

<div class="view">

    <?php //echo CHtml::encode($data->getAttributeLabel('email')); ?>
    <span style="font-size:20px;"><?php echo CHtml::link(CHtml::encode($data->email), array('mobilepictures/search', 'id'=>$data->id)); ?></span>
    <br/>    
    
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role')); ?>:</b>
	<?php echo CHtml::encode($data->role); ?>
	<br />

	<b>Статус:</b>
	<?php if ($data->activate_type==1) echo 'активирован'; else echo 'не активирован';?>
	<br />

    <b>Количество фотографий:</b>
    <?php echo $data->countphotos; ?>
    <br />
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::encode($data->date); ?>
    <br />
    
	<b><?php echo CHtml::encode($data->getAttributeLabel('urlID')); ?>:</b>
	<?php echo CHtml::encode($data->urlID); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activate_type')); ?>:</b>
	<?php echo CHtml::encode($data->activate_type); ?>
	<br />

	*/ ?>

</div>