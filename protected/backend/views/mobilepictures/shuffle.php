<h1>Фотографии</h1> 
<?php echo CHtml::link('Назад', array('mobilepictures/index')); ?>
<?php
 $this->widget('zii.widgets.CListView', array('viewData' => array(),'dataProvider'=>$dataProvider,'itemView'=>'_shuffle','ajaxUpdate'=>false)); 
?>
<?php
 Yii::app()->clientScript->registerScript('photosScript'," 
     $('img[name=\'downphoto\']').hover(
          function() {
             $(this).css('cursor','pointer');
       }, function() {
             $(this).css('cursor','default');
     });
     
     $('img[name=\'downphoto\']').live('click', function(){
         $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/check777')."',
                       data: 'id='+this.id,
                       success: function(msg){
                         json = jQuery.parseJSON(msg); 
                         if(json.check==1)
                            $('img#'+json.id).attr('src','".Yii::app()->request->getBaseUrl(true)."/images/site/checkepicture.png'); 
                         else 
                            $('img#'+json.id).attr('src','".Yii::app()->request->getBaseUrl(true)."/images/site/uncheckepicture.png');  
                       }
                     });
            return false;
     });   
     
     $('img[name=\'passphoto\']').hover(
          function() {
             $(this).css('cursor','pointer');
       }, function() {
             $(this).css('cursor','default');
     });
     
     $('img[name=\'passphoto\']').live('click', function(){
         $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/check777')."',
                       data: 'id='+this.id,
                       success: function(msg){
                         json = jQuery.parseJSON(msg); 
                         if(json.check==1)
                            $('img#'+json.id).attr('src','".Yii::app()->request->getBaseUrl(true)."/images/site/checkepicture.png'); 
                         else 
                            $('img#'+json.id).attr('src','".Yii::app()->request->getBaseUrl(true)."/images/site/uncheckepicture.png');  
                       }
                     });
            return false;
     });
    
    ",CClientScript::POS_READY);
?>