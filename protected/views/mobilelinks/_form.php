<?php
/* @var $this MobilelinksController */
/* @var $model Mobilelinks */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mobilelinks-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tagId'); ?>
		<?php echo $form->textField($model,'tagId'); ?>
		<?php echo $form->error($model,'tagId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imageId'); ?>
		<?php echo $form->textField($model,'imageId'); ?>
		<?php echo $form->error($model,'imageId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->