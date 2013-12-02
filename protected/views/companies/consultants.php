<div class="span-17">
<?php $this->widget('CabinetHeader', array('url_ID'=>$member->urlID));
 ?>
 <div class="span-17 last">
        Консультанты <?php echo $company->name; ?>
        <?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('добавить консультанта',array('consultants/add')); ?> 
   </div>
   <div class="span-17 last">
  <?php 

 $this->widget('zii.widgets.CListView', array('viewData' => array('member' => $member),'dataProvider'=>$consultants,'itemView'=>'_consultantsrow','ajaxUpdate'=>false)); 
  ?>
  </div>
</div>
 <div  class="span-1 last">
<?php $this->widget('CompanyControlPanel', array('id'=>$member->urlID));
 ?>
</div>  
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'confirm_delete_consultant',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
    ), 
)); echo 'Вы точно хотите удалить этого консультанта?<br>';
 echo CHtml::button('Да', array('id'=>'yes_confirm_delete_consultant')); 
 echo CHtml::button('Нет', array('id'=>'no_confirm_delete_consultant'));  
$this->endWidget('zii.widgets.jui.CJuiDialog');

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'confirm_block_consultant',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
    ), 
)); ?>
Вы точно хотите заблокировать(или заблокировать) этого консультанта<br>
<?php
 echo CHtml::button('Да', array('id'=>'yes_confirm_block_consultant')); 
 echo CHtml::button('Нет', array('id'=>'no_confirm_block_consultant'));  
$this->endWidget('zii.widgets.jui.CJuiDialog');

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/consultantsEdit.js");

?>