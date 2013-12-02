<?php
/* @var $this KindUsersController */
/* @var $model KindUsers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kind-users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ID'); ?>
		<?php echo $form->textField($model,'ID'); ?>
		<?php echo $form->error($model,'ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userType'); ?>
		<?php echo $form->textField($model,'userType',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'userType'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->