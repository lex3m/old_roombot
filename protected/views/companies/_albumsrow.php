<div class="span-17 last">
   <div class="span-17 last"> <strong>
<?php echo CHtml::link(CHtml::encode($data->name),array('albums/view','id'=>$data->urlID)); ?></strong>  
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Фотографии',array('albums/view','id'=>$data->urlID)); 
?>   
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Редактировать',array('albums/edit','id'=>$data->urlID));
?>   
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('albums/delete'),array('id'=>'delete_album','target'=>$data->urlID,'title
'=>$data->name)); ?>  
</div> 
<div class="span-17 last" style="padding-bottom:20px">
<?php
$i=0;
foreach ($data->companiesphotos as $p)
{
    if ($i<3)
    {
echo '<a class="grouped_elements" rel="group'.$data->id.'" href="/images/companies/photos/'.$p->name.'">
<img  style="margin-right: 25px; float:left" src="/images/companies/photos/thumbs/'.$p->name.'"/></a>'; 
}
 
    $i++;
}
?>
</div>

</div>
<br><br>