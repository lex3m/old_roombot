<div class="list-bot">
<h1>Изменение аватара</h1>
<br>
<div class="memberCabinetPic">
            <a onclick="return false;" href="">  
            <img height="150px" id="mainMemberCabinetPic" src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $member->memberinfo->avatar;?>"/>
        </a>
</div>
<div class="changeMemberAvatar" style="margin-left: 50px; float: left;">
<?php
$form = $this->beginWidget(
    'CActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )
);
?> 

<div class="row buttons">  
<?php
echo $form->labelEx($memberinfo, 'image');
echo $form->fileField($memberinfo, 'image');
echo $form->error($memberinfo, 'image'); 
?>
</div>
<br>
<div class="row buttons">
        <?php echo CHtml::submitButton('Изменить аватар',array('class'=>'rbBtn submitAvatar')); ?>   
</div>
<?php
$this->endWidget();
?>
</div>
</div>