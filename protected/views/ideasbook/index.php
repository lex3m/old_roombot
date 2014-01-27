<div class="list-bot izo-list">
<h1><?php if ($member->id==Yii::app()->user->id) echo'My ideabooks'; else  echo 'Ideabooks of user '.$member->login; ?></h1>
<br>
    <?php if ($member->id==Yii::app()->user->id):?> <div class="addIdeaBookLink"><?php echo CHtml::link('Create new ideabook',array('ideasbook/add')); ?></div><?php endif; ?>
    <?php if ((count($ideasbooks)==0)&&($member->id!=Yii::app()->user->id)): ?><p>This user don't have any ideabooks</p><?php endif;  ?>
    <?php foreach ($ideasbooks as $ideabook): ?>
    <div class="myIdeasBookBlock" id="<?php echo $ideabook->id; ?>">      
                            <a href="<?php echo Yii::app()->createUrl('ideasbook/view',array('id'=>$ideabook->id)); ?>">
                                     <img
                                         <?php if ($ideabook->countIdeaPhotos==0) { ?>
                                         src="<?php echo Yii::app()->baseUrl; ?>/images/no_image_ideaBook.jpg"
                                    <?php } else {
                                             $lastIdeasPhoto = Ideaphotos::model()->with('ideaphotos')->find('ideaBooksID=:ideaBooksID',array(':ideaBooksID'=>$ideabook->id));
                                        ?>
                                          src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $lastIdeasPhoto->ideaphotos->image; ?>"
                                    <?php } ?>
                                          class="galleryIdeasBlockImg" width="150" height="150">
                            </a>
                            <div class="ideasBookPanel">
                                <div class="ideasBookActions">  
                                    <?php if($ideabook->member->id == Yii::app()->user->id): ?>
                                        <a id=<?php echo $ideabook->id; ?>" class="ideasBookIcon  ideasBookDeleteIcon" title="Удалить">
                                           <img class="buttonsIdeasBookAction buttonIdeasBookDeleteIcon" src="">
                                        </a>      
                                        <a id="<?php echo $ideabook->id; ?>" class="ideasBookIcon  ideasBookEditIcon" title="Редактировать">
                                          <img class="buttonsIdeasBookAction buttonIdeasBookEditIcon" src="">
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="ideasBookDesc">
                                    <span class="ideasBookDescTitle"><?php echo $ideabook->name; ?></span> 
                                    <div style="display: none;" class="ideasBookDescription"><?php echo $ideabook->description; ?></div> 
                                    <div class="ideasBookDescTitlePhotoCount"><?php echo Yii::t('app', '{n} photo|{n} photos', $ideabook->countIdeaPhotos);?></div>
                               </div>
                           </div>
    </div>
    <?php endforeach; ?>
</div> 

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'edit_ideaBook',
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
        'title'=>'Edit ideabook',
    ), 
));  
?>
<form id="editIdeaBookFormPopup" class="form" enctype="multipart/form-data" method="post" action="">
            <input type="hidden" name="ideaBookID" value="">
            <div class="editIdeaBookBodyContainerPopup">  
                <div style="width: 100%;padding-bottom:20px;">
                    <input size="34" maxlength="50" name="name" type="text">
                </div>
                <textarea style="width:100%;height:100px;"  name="description" maxlength="10000" style="resize: none; height: 32px; overflow: hidden; word-wrap: break-word;"></textarea>
                <div style="clear:both"></div>
                <div style="display: block;">     
                    <input id="editIdeaBookButtonPopup" type="button" class="rbBtn submitEditIdeasBook" value="Save">
                </div>       
            </div>
</form>  
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');  

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'delete_ideaBook',
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
        'title'=>'Delete ideabook',
    ), 
));  
?>
   <p>Are you really want to delete this ideabook?</p>
   <input id="" type="button" class="rbBtn okDeleteIdeasBook" value="Yes">
   <input id="" type="button" class="rbBtn cancelDeleteIdeasBook" value="Cancel">
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog'); 

Yii::app()->clientScript->registerScript('bbb',"
         $('.ideasBookEditIcon').live('click',function(event){
             var ideasBookName = $('.myIdeasBookBlock#'+this.id+' .ideasBookDescTitle').text();   
             var ideasBookDescription = $('.myIdeasBookBlock#'+this.id+' .ideasBookDescription').text();  
             $('#edit_ideaBook').dialog('open');
             $('#editIdeaBookFormPopup [name=\"ideaBookID\"]').val(this.id);
             $('#editIdeaBookFormPopup [name=\"name\"]').val(ideasBookName);
             $('#editIdeaBookFormPopup [name=\"description\"]').val(ideasBookDescription); 
             return false;
         });
         
         $('#editIdeaBookFormPopup #editIdeaBookButtonPopup').live('click', function(event){
             var ideaBookID=$('#editIdeaBookFormPopup [name=\"ideaBookID\"]').val();
             var ideaBookName=$('#editIdeaBookFormPopup [name=\"name\"]').val();
             var ideaBookDescription=$('#editIdeaBookFormPopup [name=\"description\"]').val(); 
                 $.ajax({
                           type: 'POST',
                           url: '".Yii::app()->createUrl('ideasbook/edit')."',
                           data: {id: ideaBookID, name:ideaBookName, description:ideaBookDescription},  
                           success: function(msg){
                                var data = jQuery.parseJSON(msg);
                                $('.myIdeasBookBlock#'+data.id+' .ideasBookDescTitle').empty().append(data.name);
                                $('.myIdeasBookBlock#'+data.id+' .ideasBookDescription').empty().append(data.description);
                                $('#edit_ideaBook').dialog('close');  
                           }
                    });
                
         });
         
         $('.ideasBookDeleteIcon').live('click',function(event){
             $('#delete_ideaBook').dialog('open');
             $('#delete_ideaBook .okDeleteIdeasBook').attr('id', this.id);    
             return false;
         });
         
         $('.cancelDeleteIdeasBook').live('click',function(event){
             $('#delete_ideaBook').dialog('close');
             return false;
         });
         
         $('.okDeleteIdeasBook').live('click',function(event){
                 $.ajax({  
                           type: 'POST',
                           url: '".Yii::app()->createUrl('ideasbook/delete')."',
                           data: {id: this.id},  
                           success: function(msg){
                                var data = jQuery.parseJSON(msg);
                                if (data.id!=''){
                                    $('.myIdeasBookBlock#'+data.id).remove();
                                    $('#delete_ideaBook').dialog('close');  
                                }
                           }
                    });
             return false;
         });
         
",CClientScript::POS_READY);

?>
