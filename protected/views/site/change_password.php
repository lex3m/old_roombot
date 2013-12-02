<?php
/* @var $this UsersController */
/* @var $model Users */




?>

<div class="list-bot">
<h1>Изменение пароля</h1>
<p>Введите новый пароль</p>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'change_password_form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

  

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
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Ok'); ?> 
    </div>

<?php $this->endWidget(); ?>
    </div>

</div>