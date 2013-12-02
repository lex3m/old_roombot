<div class="span-17 last">
   <div class="span-17 last"> <strong>
<?php echo CHtml::link(CHtml::encode($data->title),array('news/view','id'=>$data->urlID)); ?></strong>     
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Редактировать',array('news/edit','id'=>$data->urlID));
?>  
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('news/delete'),array('id'=>'delete_news','target'=>$data->urlID,'title
'=>$data->title)); ?>  
</div> 
<br><br>
<?php 
$preview = News::truncateWords($data->content, 20);
echo $preview; ?>
</div>
<br><br>