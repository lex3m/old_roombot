<div class="list-bot">
<h1 style = "margin-bottom: 0;">Изменение информации</h1>
<br>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'member-form',
    'enableAjaxValidation'=>false,
)); ?>
    <div class="row">
        <div class="labelFormField">
            <?php echo $form->labelEx($member,'email',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->textField($member,'email',array('size'=>50,'maxlength'=>50)); ?>
        <?php echo $form->error($member,'email'); ?>
    </div>
    <br>
    <div class="row">
        <div class="labelFormField">
            <?php echo $form->labelEx($memberinfo,'showEmail',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->checkBox($memberinfo,'showEmail'); ?>
        <?php echo $form->error($memberinfo,'showEmail'); ?>
    </div>
    <br>
    <div class="row">
        <div class="labelFormField">
            <?php echo $form->labelEx($member,'login',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->textField($member,'login',array('size'=>50,'maxlength'=>50)); ?>
        <?php echo $form->error($member,'login'); ?>
    </div>
    <br>
    <div class="row">
        <div class="labelFormField">
            <?php echo $form->labelEx($memberinfo,'fio',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->textField($memberinfo,'fio',array('size'=>50,'maxlength'=>255)); ?>
        <?php echo $form->error($memberinfo,'fio'); ?>
    </div>
    <br>
    <div class="row">
        <div class="labelFormField">
        <?php echo $form->labelEx($memberinfo,'website',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->textField($memberinfo,'website',array('size'=>50,'maxlength'=>70)); ?>
        <?php echo $form->error($memberinfo,'website'); ?>
    </div>
    <br>
    <div class="row">
        <div class="labelFormField">
        <?php echo $form->labelEx($memberinfo,'phone',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->textField($memberinfo,'phone',array('size'=>50,'maxlength'=>12)); ?>
        <?php echo $form->error($memberinfo,'phone'); ?>
    </div>
    <br>
    <div class="row">
        <div class="labelFormField">
        <?php echo $form->labelEx($memberinfo,'about',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->textArea($memberinfo,'about',array('cols'=>50,'rows'=>'4','placeholder'=>'Напишите что-нибудь о себе')); ?>
        <?php echo $form->error($memberinfo,'about'); ?>
    </div>  
    <br>

    <div id="memberChangeInfoSaveButton" class="row buttons">
        <?php echo CHtml::submitButton('Сохранить',array('class'=>'rbBtn')); ?>
    </div>

<?php $this->endWidget(); ?>


</div>