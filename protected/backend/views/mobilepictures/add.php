<h1>Добавление фотографий</h1>

 <div class="span-17 last">
        <div class="form">
            <br>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?> 




 <div class="span-17 last">
<?php 
 $form=$this->beginWidget('CActiveForm', array(
    'id'=>'mobilepictures-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
)); ?>


<div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <p style="margin:0px;font-size:11px">*Ссылка на ваш сайти или блог(без http://)</p>
        <?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?> 
        <?php echo $form->error($model,'name'); ?>
</div> 

 



    <div class="row">
        <?php echo $form->fileField($model,'img'); ?>
        <?php echo $form->error($model,'img'); ?>
    </div>
 <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить изображение'); ?> 
    </div>

<?php $this->endWidget(); ?>
<br>
</div>
<div class="span-17 last">
<?php

 $this->widget('zii.widgets.CListView', array('viewData' => array( 'member' => $member),'dataProvider'=>$dataProvider,'itemView'=>'_mobilepicturesrow','ajaxUpdate'=>false)); 
?>
</div>
<?php
    foreach ($pictures as $image)
{/*
echo    '<div class="span-22 last" style="margin-bottom:10px;" id="company_photo" name="'.$image->id.'">';
echo '<a target="_blank" href="'.$this->createUrl('mobilepictures/viewinfo',array('id'=>$image->id)).'"><img  width="100px" height="100px" style="margin-right: 25px; float:left" src="/images/mobile//images/'.$image->image.'"/></a>';
//echo CHtml::link('удалить',"#",array("submit"=>array('delete', 'id'=>$image->id), 'confirm' => 'Вы уверены?')); 
echo CHtml::link('<img style="float:left" width="12px" height="12px" src="http://potolokportal.ru/images/site/delete_icon.png"  />', array('delete'),array('id'=>'delete_picture','target'=>$image->id));
echo '</div>';*/
}
?> 
</div>
   </div>

 

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
       'width'=>50, 
       'maxlength'=>50)); 
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
                          $('div#tags'+json.pictureid).append('<div id=\'taglinkk'+json.taglinkid+'\' style=\'margin-bottom:10px;\'>'+json.tagname+'<a id=\'delete_tag\' target=\'20\' href=\'/mobilepictures/delete\'><img id=\''+json.taglinkid+'\' style=\'float:right\' width=\'12px\' height=\'12px\' src=\'http://potolokportal.ru/images/site/delete_icon.png\'></a></div>'); 
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
        
    
    ",CClientScript::POS_READY);
?>