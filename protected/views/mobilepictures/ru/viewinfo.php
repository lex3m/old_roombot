<div class="list-bot izo-list">
<h1>Просмотр изображения</h1><h2><?php echo $model->name; ?></h2>
<span>Добавил:&nbsp;<?php echo CHtml::link($model->member->login,array('member/dashboard','id'=>$model->member->urlID));  ?></span><br/>
<?php //echo CHtml::link('Назад к списку',array('member/dashboard','id'=>$member->urlID));?>
<?php // echo $model->name; ?><!--<br>-->
<div class="photo-description">
    <?php if (!empty($model->info)): ?><span>Описание: </span> <?php echo $model->info; ?><?php endif;?>
</div>
<br>
    <script type="text/javascript">(function() {
            if (window.pluso)if (typeof window.pluso.start == "function") return;
            if (window.ifpluso==undefined) { window.ifpluso = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                var h=d[g]('body')[0];
                h.appendChild(s);
            }})();</script>
    <div class="pluso" data-background="#000000" data-options="small,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,digg,pinme,pinterest,liveinternet,linkedin,memori,webdiscover,moikrug,yandex,print"></div>
<img class="main" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $model->image; echo '?' . time() ?>"/><br/>
<a class="addBookmarkLink" id="<?php echo $model->id; ?>" onclick="return false;" href="#">Добавить в книгу идей</a>&nbsp;&nbsp; 
<?php echo $model->date; ?>&nbsp;&nbsp;  
<?php if (count($tags)>0):  ?>
Теги:&nbsp;
<?php
   echo implode(", ",$tagNameArray);
    
?>
<?php endif; ?>  
<br>
<?php if (!Yii::app()->user->isGuest) { ?>
    <div class="photo__footer">
        <div class="photos__photoActions">
            <div class="photoActions rb-button-toolbar photoActions__medium">
                <div class="rb-button-group rb-button-group-medium">
                    <button data-likes="<?php echo $model->countLikes; ?>" data-id="<?php echo $model->id; ?>" class="rb-button rb-button-like rb-button-medium rb-button-responsive" tabindex="0">
                       <?php echo $model->countLikes; ?>
                    </button>
                    <!-- <a class="rb-button rb-button-download rb-button-medium rb-button-responsive" tabindex="0" title="Download this track (196.6MB)" download="The Labyrinth #17 - Roots of &quot;Reality&quot; Part 1 -">Загрузить</a>-->
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>

<div id="commentsContainer">
    <?php foreach ($comments as $comment): ?>
        <div id="<?php echo $comment->id; ?>" class="commentBodyContent">
            <div class="commentThumb">
                <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" class="userAvatar">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo Memberinfo::model()->findbyPk($comment->member->id)->avatar; ?>"></a>
            </div>      
            <div class="comment-actions">
                <?php if($comment->member->id == Yii::app()->user->id): ?>
                <a id="<?php echo $comment->id; ?>" class="commentIcon commentDeleteIcon" title="Delete">
                   <img class="buttonsCommentAction buttonCommentDeleteIcon" src="">
                </a>    
                <a id="<?php echo $comment->id; ?>" class="commentIcon commentEditIcon" title="Edit">
                  <img class="buttonsCommentAction buttonCommentEditIcon" src="">
                </a>
                <?php endif; ?>
            </div>
            <a class="rb-username"  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" data-type="profile"><?php echo $comment->member->login; ?></a>             
            <div class="commentBodyText"><?php echo $comment->content; ?></div>        
        <div class="commentInfo tiny-text">
            <span>
                <abbr title="<?php echo $comment->dateTime;?>">
                    <?php echo CHtml::openTag('abbr',array('class'=>'timeago',
                     'title'=>$comment->dateTime,
                    ));?>
                </abbr>    
            </span>
            <span class="likeContainer">&nbsp;&nbsp;&nbsp;
                <a class="likeIcon"  id="<?php echo $comment->id; ?>" href="#"><img src=""><?php echo $comment->countlikes; ?></a>
            </span> 
        </div>
        </div>
     <?php endforeach; ?>
</div>

<?php if (!Yii::app()->user->isGuest) { ?>
<div class="addComment">
    <div class="commentError"></div>
    <form id="commentForm" class="commentForm" enctype="multipart/form-data" method="post" action="">
        <input type="hidden" name="photoID" value="<?php echo $model->id; ?>">
            <div class="commentBodyContainer">
                <textarea style="width:100%;" class="commentBody" name="comment" maxlength="10000" placeholder="Напишите комментарий" style="resize: none; height: 32px; overflow: hidden; word-wrap: break-word;"></textarea>
            <div style="clear:both"></div>
            <div class="addCommentExtra" style="display: block;">     
                <input id="addCommentButton" type="button" class="rbBtn submitAddComment" value="Отправить">
            </div>   
    </form>
    </div>
</div>

<?php
/************окно редактирования комментария*****************/
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'edit_comment',
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
        'title'=>'Редактирование комментария',
    ), 
));  
?>
<form id="commentFormPopup" class="commentFormPopup" enctype="multipart/form-data" method="post" action="">
            <input type="hidden" name="photoID" value="">
            <div class="commentBodyContainerPopup">
                <textarea style="width:100%;height:100px;" class="commentBodyPopup" name="comment" maxlength="10000" style="resize: none; height: 32px; overflow: hidden; word-wrap: break-word;"></textarea>
            <div style="clear:both"></div>
            <div style="display: block;">     
                <input id="addCommentButtonPopup" type="button" class="rbBtn submitAddComment" value="Ок">
            </div>       
            </div>
</form>  
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
/************конец окна редактирования комментария*****************/

/************окно добавления фотографии в книгу идей*****************/
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'add_toIdeasBook',
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
        'title'=>'Добавление фотографии в книгу идей',      
    ), 
));  
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'selectIdeasBookForm',
    'enableAjaxValidation'=>false,
)); ?>

    <div class="row">
        <?php echo CHtml::dropDownList('ideasBookList', '', 
              CHtml::listData(Ideasbook::model()->findAll('memberID=:m',array(':m'=>Yii::app()->user->id)), 'id', 'name'),  
              array('empty' => '(Выберите книгу идей)'));  ?>
    </div>
     <input id="" type="button" class="rbBtn addPhotoToIdeasBookBtn" value="Добавить">  
<?php $this->endWidget(); ?>
</div><!-- form -->

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
/************конец окна добавления фотографии в книгу идей****************/

/************окно успешного добавления фотографии к книге идей*****************/
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'tmpInfoPopup',
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
        'title'=>'Добавление фотографии в книгу идей',
    ),
));
?>
<p class="tmpInfoMsg">Вы успешно добавили эту фотография в книгу идей</p>
<div class="form">
    <input id="tmpInfoPopupBtn" type="button" class="rbBtn tmpInfoBtn" value="Ok">
</div><!-- form -->
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
/************конец окна успешного добавления фотографии к книге идей****************/


       Yii::app()->clientScript->registerScript('fdgd',"
       
       var newComment ='';  
       $('#addCommentButton').live('click', function(event){   
                    $.ajax({
                           type: 'POST',
                           url: '".Yii::app()->createUrl('comments/add')."',
                           data: $('#commentForm').serialize(),  
                           success: function(msg){
                            var data = jQuery.parseJSON(msg);
      
                            
                                
                       var newComment = '<div id=\"'+data.commentID+'\" class=\"commentBodyContent\"> \
                                        <div class=\"commentThumb\"> \
                                           <a href=\"".Yii::app()->baseUrl."/member/dashboard/'+data.urlID+'\" class=\"userAvatar\"> \
                                             <img src=\"".Yii::app()->baseUrl."/images/members/avatars/'+data.avatar+'\"> \
                                           </a> \
                                         </div> \
                                        <div class=\"comment-actions\"> \
                                        <a id=\"'+data.commentID+'\" class=\"commentIcon commentDeleteIcon\" title=\"Delete\"> \
                                           <img class=\"buttonsCommentAction buttonCommentDeleteIcon\" src=\"\"> \
                                        </a> \
                                        <a id=\"'+data.commentID+'\" class=\"commentIcon commentEditIcon\" title=\"Edit\"> \
                                          <img class=\"buttonsCommentAction buttonCommentEditIcon\" src=\"\"> \
                                        </a> \
                                        </div> \
                                        <a class=\"rb-username\" href=\"".Yii::app()->baseUrl."/member/dashboard/'+data.urlID+'\">'+data.login+'</a> \
                                        <div class=\"commentBodyText\">'+data.comment+'</div> \
                                        <div class=\"commentInfo tiny-text\"> \
                                        <span> \
                                            <abbr class=\"timeago\" title=\"'+data.dateTime+'\">'+data.dateTime+'</abbr> \
                                        </span> \
                                        <span class=\"likeContainer\">&nbsp;&nbsp;&nbsp; \
                                            <a class=\"likeIcon\"  id=\"'+data.commentID+'\" href=\"#\"><img src=\"\">0</a> \
                                        </span> \
                                         </div> \
                                         </div>';  
            
            
                             $('#commentsContainer').append(newComment);
                             $('abbr.timeago').timeago();
                             $('textarea.commentBody').val(''); 
                           }
                         });
                    return event.defaultPrevented || event.returnValue == false;
            });
            
         $('.commentDeleteIcon').live('click', function(event){  
             var id = this.id;
             $.ajax({
                           type: 'POST',
                           url: '".Yii::app()->createUrl('comments/delete')."',
                           data: {id: id},  
                           success: function(msg){
                                var data = jQuery.parseJSON(msg);
                                $('.oneComment#'+data.id).remove();
                            }
                         });
         });  
         
             
         $('.commentEditIcon').live('click', function(event){
             $('#edit_comment').data('link', '123').dialog('open');
             var commentContent = $('.commentBodyContent#'+this.id+' .commentBodyText').text();  
             $('#edit_comment textarea').val(commentContent);    
             $('#edit_comment input[name=photoID]').val(this.id);   
         });     
         
         $('#edit_comment #addCommentButtonPopup').live('click', function(event){
             var idComment = $('#edit_comment input[name=photoID]').val(); 
             var contentComment = $('#edit_comment textarea').val(); 
             if (contentComment!='')
             {
                 $.ajax({
                           type: 'POST',
                           url: '".Yii::app()->createUrl('comments/edit')."',
                           data: {id: idComment, commentContent:contentComment},  
                           success: function(msg){
                                var data = jQuery.parseJSON(msg);
                                $('.commentBodyContent#'+data.id+' .commentBodyText').empty().append(data.comment);
                           }
                    });
                $('#edit_comment').dialog('close');
             }
         });
         
         $('.likeIcon').live('click',function(event){
             $.ajax({
                           type: 'POST',
                           url: '".Yii::app()->createUrl('commentlike/change')."',
                           data: {commentID: this.id},   
                           success: function(msg){
                                var data = jQuery.parseJSON(msg);
                                     $('#'+data.commentID+'.likeIcon').empty().append('<img src=\"\">'+data.countLikes);
    
                           }
                    });
             return event.defaultPrevented || event.returnValue == false;
         });  
         
     
     
     
         var issetIdeasBooks = true;
         $('.addBookmarkLink').live('click',function(event){

                $('#selectIdeasBookForm .addPhotoToIdeasBookBtn').attr('id',this.id);
                var selectedIdeasBook = $('#ideasBookList option:selected').val();
                var lengthOfIdeasBooks = $('#ideasBookList > option').length;
                 if (lengthOfIdeasBooks!=1){
                    $('#add_toIdeasBook').dialog('open');
                 }
                 else
                 {
                    issetIdeasBooks = false;
                    $('p.tmpInfoMsg').text('У вас пока нет ни одной книг идей.');
                    $('#tmpInfoPopupBtn').val('Создать');
                    $('#tmpInfoPopup').dialog('open');
                 }
             return event.defaultPrevented || event.returnValue == false;
         });

         $('.addPhotoToIdeasBookBtn').live('click',function(event){
                 var selectedIdeasBook = $('#ideasBookList option:selected').val();
                     $.ajax({
                               type: 'POST',
                               url: '".Yii::app()->createUrl('ideasphotos/add')."',
                               data: {id: this.id, selectedIdeasBook: selectedIdeasBook},
                               success: function(msg){
                                         var data = jQuery.parseJSON(msg);
                                         if (data.id!='')
                                            {
                                            $('#add_toIdeasBook').dialog('close');
                                            $('#tmpInfoPopup').dialog('open');
                                            }
                               }
                        });

         });

          $('#tmpInfoPopupBtn').live('click',function(event){
              if (issetIdeasBooks)
                    $('#tmpInfoPopup').dialog('close');
              else window.location.href = '".Yii::app()->createUrl('ideasbook/add')."';
           });

          $('button.rb-button-like').live('click',function(event){
                 var photoID = $(this).data('id');
                 var currentLikes = $(this).data('likes');
                     $.ajax({
                               type: 'POST',
                               url: '".Yii::app()->createUrl('photolike/add')."',
                               data: {id: photoID},
                               success: function(msg){
                                         var data = jQuery.parseJSON(msg);
                                         $('button.rb-button-like').text(data.countLikes);
                                         $('button.rb-button-like').attr('data-likes', data.countLikes);
                               }
                        });

         });
         
",CClientScript::POS_READY);
}
else echo 'Зарегистрируйтесь, чтобы добавить комментарии.';
?>