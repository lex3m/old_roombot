<h1>Модерация фотографий</h1>

<?php $this->widget('AdminHeadMenu', array()); ?>

<?php
$this->widget('zii.widgets.CMenu',array(
    'items'=>array(
        array('label'=>'Прошли модерацию', 'url'=>array('mobilepictures/index','active'=>"yes")),
        array('label'=>'Не прошли модерацию', 'url'=>array('mobilepictures/index','active'=>"no")),
    )));
?>

<?php
 $this->widget('zii.widgets.CListView', array('viewData' => array(),'dataProvider'=>$dataProvider,'itemView'=>'_photos','ajaxUpdate'=>false)); 
?>

<br>
  

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'add_tag',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
    ), 
)); 

echo CHtml::dropDownList('tags_array','',CHtml::listData(Mobiletags::model()->findAll(), 'id', 'name'));
echo '<br><br>';
echo CHtml::button('Да', array('id'=>'confirm_tag_option','name'));    
$this->endWidget('zii.widgets.jui.CJuiDialog');


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'change_name_picture',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
    ), 
)); 

echo CHtml::textField('Text', '',
 array('id'=>'name_picture_textField', 
       'width'=>100,
       'maxlength'=>100));
echo '<br><br>';
echo CHtml::button('Да', array('id'=>'confirm_name_picture','name'));    
$this->endWidget('zii.widgets.jui.CJuiDialog');


    Yii::app()->clientScript->registerScript('mobilePicturesScript',"
    
    $( 'span#name_picture').on('click', function(event){
        var name;
        name = $(this).attr('name');
         $('#change_name_picture').dialog('option','title', 'Изменить название');
                $('#change_name_picture').dialog('open');
                $( 'input#confirm_name_picture').attr('name',name); 
        });
        
    $( 'input#confirm_name_picture').on('click', function(event){
            picturename = $('input[id=\'name_picture_textField\']').val(); 
            pictureid = $(this).attr('name'); 
                $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/editpicturename')."',
                       data: {id: pictureid, name: picturename},  
                       success: function(msg){
                         
                          $('#change_name_picture').dialog('close'); 
                          json = jQuery.parseJSON(msg);
                          $('span.name_picture_id_'+json.id).text(json.name); 
                          $('input[id=\'name_picture_textField\']').val('');  
                       }
                     });
                return false;
        });
        
        
        $( 'a#delete_picture').on('click', function(event){
                var id;
                id = $(this).attr('target');
                $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/delete')."',
                       data: 'id='+id,
                       success: function(msg){
                         $('[name='+msg+']').remove()
                       }
                     }); 
                return false;
        });  
        $( 'a[name=\'new_tag\']').on('click', function(event){
               id = $(this).attr('id'); 
                $('#add_tag').dialog('option','title', 'Добавить тег');
                $('#add_tag').dialog('open');
                $( 'input#confirm_tag_option').attr('name',id); 
                return false;
        });
        $( '#confirm_tag_option').on('click', function(event){
            select = $('select[name=\'tags_array\']').val();  
                $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/addtag')."',
                       data: {id: id, select: select},  
                       success: function(msg){
                        
                          $('#add_tag').dialog('close'); 
                          json = jQuery.parseJSON(msg);
                          $('div#tags'+json.pictureid).append('<div id=\'taglinkk'+json.taglinkid+'\' style=\'margin-bottom:10px;\'>'+json.tagname+'<a id=\'delete_tag\' target=\'20\' href=\'/mobilepictures/delete\'><img id=\''+json.taglinkid+'\' style=\'float:right\' width=\'12px\' height=\'12px\' src=\'/images/site/delete_icon.png\'></a></div>');
                       }
                     });
                return false;
        });
        
        $( 'a#delete_tag').live('click', function(){
            var id;
            id = $(this).children().attr('id');
            $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/tagsdelete')."',
                       data: 'id='+id,
                       success: function(msg){ 
                         $('div#taglinkk'+msg).remove(); 
                       }
                     });
            return false;
        });
        
     $('img[name=\'checkImage\']').hover(
          function() {
             $(this).css('cursor','pointer');
       }, function() {
             $(this).css('cursor','default');
     });
     
     $('img[name=\'checkImage\']').live('click', function(){
         $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/check')."',
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