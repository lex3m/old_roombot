<div class="span-17">
<?php $this->widget('CabinetHeader', array('url_ID'=>$member->urlID));
 ?>
 <div class="span-17 last">
        Вакансии компании <?php echo $company->name; ?>
        <?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('добавить вакансию',array('vacancies/add')); ?> 
   </div>
   <div class="span-17 last">
  <?php 

 $this->widget('zii.widgets.CListView', array('viewData' => array( 'member' => $member),'dataProvider'=>$vacancies,'itemView'=>'_vacanciesrow','ajaxUpdate'=>false)); 
  ?>
  </div>
</div>
 <div  class="span-1 last">
<?php $this->widget('CompanyControlPanel', array('id'=>$member->urlID));
 ?>
</div>  
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'confirm_delete_vacancy',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
    ), 
)); echo 'Вы точно хотите удалить эту новость?<br>';
 echo CHtml::button('Да', array('id'=>'yes_confirm_delete_vacancy')); 
 echo CHtml::button('Нет', array('id'=>'no_confirm_delete_vacancy'));  
$this->endWidget('zii.widgets.jui.CJuiDialog');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/vacanciesEdit.js");
?>