<div class="span-17">
<?php $this->widget('CabinetHeader', array('url_ID'=>$member->urlID));
 ?>
 <div class="span-17 last">
        Альбомы компании <?php echo $company->name; ?>
        <?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('добавить альбом',array('albums/add')); ?> 
   </div>  
   <div class="span-17 last"><br>
  <?php /*
    foreach ($albums as $album){
       echo '<strong>'.CHtml::link($album->name,array('albums/view','id'=>$album->urlID)).'</strong> ';  
      if ($member->id==Yii::app()->user->getId()) echo '<span style="margin-right:10px;">'.CHtml::link('Редактировать',array('albums/edit','id'=>$album->urlID)).'</span>';
      if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('albums/delete'),array('id'=>'delete_album','target'=>$album->urlID,'title
'=>$album->name)); 
       echo '<br><br>';
    }*/
  $this->widget('zii.widgets.CListView', array('viewData' => array( 'member' => $member),'dataProvider'=>$albums,'itemView'=>'_albumsrow','ajaxUpdate'=>false)); 
  ?>
  </div>
</div>
 <div  class="span-1 last">
<?php $this->widget('CompanyControlPanel', array('id'=>$member->urlID));
 ?>
</div>  
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'confirm_delete_album',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
    ), 
)); echo 'Вы точно хотите удалить этот альбом?<br>'; 
 echo CHtml::button('Да', array('id'=>'yes_confirm_delete_album')); 
 echo CHtml::button('Нет', array('id'=>'no_confirm_delete_album'));  
$this->endWidget('zii.widgets.jui.CJuiDialog');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/albumEdit.js");

?>