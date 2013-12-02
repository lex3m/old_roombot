<div class="span-17 last">
   <div class="span-17 last"> <strong>
<?php $file_extn = substr($data->document, strrpos($data->document, '.')+1); ?>
<a download="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" href="<?php echo Yii::app()->getBaseUrl(true); ?>/images/companies/docs/<?php echo $data->document; ?>"><?php echo $data->title.'.'.$file_extn; ?></a></strong>     
 
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('pricelists/delete'),array('id'=>'delete_pricelist','target'=>$data->urlID,'title
'=>$data->title)); ?>  
</div> 

</div>
<br><br>