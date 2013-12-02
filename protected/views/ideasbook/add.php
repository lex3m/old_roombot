<div class="list-bot izo-list">
    <h1>Добавление новой книги идей</h1>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'ideasbook-ideasbook-form',
    'enableAjaxValidation'=>false,
)); ?>



    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>  
        <?php echo $form->textField($model,'name',array('size'=>37)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('cols'=>50,'rows'=>5)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>




    <div class="row buttons">
        <?php echo CHtml::submitButton('Создать',array('class'=>'rbBtn createNewIdeasBookBtn')); ?>
    </div>

<?php $this->endWidget(); ?>

</div>   
</div>
