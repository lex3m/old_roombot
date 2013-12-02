<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
/*$this->breadcrumbs=array(
	'Login',
);*/
?>

<div class="list-bot">
<h1>Авторизация</h1>



<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>



	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		
	</div>
	
	
	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Войти'); ?> 
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<div class="ne-vhod">
     У Вас еще нет своего кабинета? <br />В этом случае Вам нужно зарегистрироваться.<br />
     <div class="knopka-srednyaya">
         <a href="/companies/register" class="knopo4ka">Зарегистрироваться</a>
     </div>    
     
    <?php echo CHtml::link('Забыли пароль?',array("site/password")); ?>
</div>

</div><!-- list-bot -->
