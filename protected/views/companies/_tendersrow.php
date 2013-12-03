<div class="span-17 last">
   <div class="span-17 last"> <strong>
<?php echo CHtml::link(CHtml::encode($data->name),array('tenders/view','id'=>$data->urlID)); ?></strong>     
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Редактировать',array('tenders/edit','id'=>$data->urlID));
?>  
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Файлы тендера',array('tenders/addfiles','id'=>$data->urlID));
?>  
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('tenders/delete'),array('id'=>'delete_tender','target'=>$data->urlID,'title
'=>$data->name)); ?>  
</div> 
<br><br>
<?php 
$preview = News::truncateWords($data->descLong, 20);
echo $preview; ?>
</div>
Виды потолков:<br>
<?php
foreach ($data->tenderskindceilings as $kindceilings)  
{
    $kindCeiling = KindSubCeilings::model()->findbyPk($kindceilings->kindCeilingID);
    
    echo $kindCeiling->name.'<br>';
}
?>
<br><br>