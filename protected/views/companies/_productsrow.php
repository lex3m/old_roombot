<div class="span-17 last">
   <div class="span-17 last"> <strong>
<?php echo CHtml::link(CHtml::encode($data->name),array('products/view','id'=>$data->urlID)); ?></strong>     
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Редактировать',array('products/edit','id'=>$data->urlID));
?>  
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('products/delete'),array('id'=>'delete_product','target'=>$data->urlID,'title
'=>$data->name)); ?> 
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Фотографии',array('productsphotos/add','id'=>$data->urlID)); ?>

</div> 
<br><br>
<?php
$i=0;
foreach ($data->productsphotos as $p)
{
    if ($i<3)
    {
echo '<a class="grouped_elements" rel="group'.$data->id.'" href="/images/companies/products/'.$p->name.'">
<img  style="margin-right: 25px; float:left" src="/images/companies/products/thumbs/'.$p->name.'"/></a>'; 
}
//echo '<img style="float:left" src="/images/companies/products/thumbs/'.$p->name.'"/>'; 
    $i++;
}
?><br>
Виды потолков:<br>
<?php
foreach ($data->productskindceilings as $kindceilings)
{
    $kindCeiling = KindSubCeilings::model()->findbyPk($kindceilings->kindCeilingID);
    echo $kindCeiling->name.'<br>';
}
?>

<br>

</div>
<br><br>