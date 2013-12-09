
<div class="list-bot">


<p>Забыли свой пароль?</p>
Введите свой email для смены пароля.

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'send_letter_for_password_form',
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

    <div class="row buttons">
        <?php echo CHtml::submitButton('Ok'); ?> 
    </div>

<?php $this->endWidget(); ?>
    </div>
</div>
