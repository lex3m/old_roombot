<div class="span-17 last">
   <div class="span-17 last"> <strong>
<?php echo CHtml::link(CHtml::encode($data->title),array('offers/view','id'=>$data->urlID)); ?></strong>     
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Редактировать',array('offers/edit','id'=>$data->urlID));
?>  
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('offers/delete'),array('id'=>'delete_offer','target'=>$data->urlID,'title
'=>$data->title)); ?>  
</div> 
<br><br>
Виды потолков:  <br><?php foreach ($data->subceilinglinks as $subceilinglink)
            {
                $subceilingName = KindSubCeilings::model()->findbyPk($subceilinglink->kindCeilingID);
                echo $subceilingName->name.'<br>';
            }
               ?>
<br><br>
</div>
<br><br>