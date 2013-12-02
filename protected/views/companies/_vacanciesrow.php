<div class="span-17 last">
   <div class="span-17 last"> <strong>
<?php echo CHtml::link(CHtml::encode($data->title),array('vacancies/view','id'=>$data->urlID)); ?></strong>     
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Редактировать',array('vacancies/edit','id'=>$data->urlID));
?>  
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('vacancies/delete'),array('id'=>'delete_offer','target'=>$data->urlID,'title
'=>$data->title)); ?>  
</div> 
   
</div>
<br><br>