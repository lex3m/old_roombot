<div class="list-bot">
<h1 style = "margin-bottom: 0;"><?php echo Yii::t("memberInfo", 'Change social accounts')?></h1>
<br>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'member-form',
    'enableAjaxValidation'=>false,
)); ?>
    <div class="row">
        <p style="font-weight: bold; font-size: 14px"><?php echo Yii::t('memberInfo', 'Add a link to your social account like'); ?> <i>https://vk.com/user</i></p>
        <p>
            <?php echo Yii::t('memberInfo', 'Bind your account to social networks will allow you to login on the site in one click, without having to enter the same username and password'); ?>
        </p>
    </div>
    <br>
    <div class="row">
        <div class="labelFormField">
        <?php echo $form->labelEx($memberinfo,'vk',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->textField($memberinfo,'vk',array('size'=>50,'maxlength'=>70)); ?>
        <?php echo $form->error($memberinfo,'vk'); ?>
    </div>
    <br>
    <div class="row">
        <div class="labelFormField">
        <?php echo $form->labelEx($memberinfo,'fb',array('class'=>'labelForm')); ?>
        </div>
        <?php echo $form->textField($memberinfo,'fb',array('size'=>50,'maxlength'=>70)); ?>
        <?php echo $form->error($memberinfo,'fb'); ?>
    </div>
    <br>
    <div id="memberChangeInfoSaveButton" class="row buttons">
        <?php echo CHtml::submitButton(Yii::t("memberInfo", 'Save'),array('class'=>'rbBtn')); ?>
    </div>

<?php $this->endWidget(); ?>


</div>