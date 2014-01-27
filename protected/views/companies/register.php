<div class="list-bot">
<h1>Sign up</h1>
<div class="form smail">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'member-form',
	'enableAjaxValidation'=>false,
)); ?>





	

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>40,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>
	
	<div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'value'=>'')); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password_repeat'); ?>
        <?php echo $form->passwordField($model,'password_repeat',array('size'=>60,'maxlength'=>255,'value'=>'')); ?>
        <?php echo $form->error($model,'password_repeat'); ?>  
    </div>

<!--    <div class="row">-->
<!--        You should agree with <a href="--><?php //echo Yii::app()->createUrl('site/rules'); ?><!--">site rules</a>:<br>-->
<!--        I accept&nbsp;--><?php //echo $form->checkBox($model,'rulles',  array()); ?>
<!--        --><?php //echo $form->error($model,'rulles'); ?>
<!--    </div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton('Sign up'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>