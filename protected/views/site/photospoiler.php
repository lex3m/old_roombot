    <script type="text/javascript">(function() {
            if (window.pluso)if (typeof window.pluso.start == "function") return;
            if (window.ifpluso==undefined) { window.ifpluso = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                var h=d[g]('body')[0];
                h.appendChild(s);
            }})();
    </script>
    <div class="closer">
        <img src="<?php echo Yii::app()->baseUrl; ?>/images/close.png" id="close" />
    </div>

    <div class="spoiler-content-1">

        <div class="gallery-sliger">
            <?php if (!empty($prevPhoto)):?>
                <a class="gallery-nav-left" href="#" id="<?php echo $prevPhoto;?>">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/str_oransh_l.png" />
                </a>
            <?php endif; ?>
            <?php if (!empty($nextPhoto)):?>
                <a class="gallery-nav-right" href="#" id="<?php echo $nextPhoto;?>">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/str_oransh_r.png" />
                </a>
            <?php endif; ?>
            <div class="usfot">
                <img class="image__full" height="580" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $model->image; ?>" />
            </div>
        </div>

        <div class="sotcial">
            <div class="photoElement__stats stats-left">
                <?php if (!Yii::app()->user->isGuest):?>
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="Поставить лайк. Количество лайков - <?php echo $model->countLikes; ?>" class="rb-ministats-item">
                                <div class="rb-button-group rb-button-group-medium">
                                    <button id="likePhoto" data-likes="0" data-id="<?php echo $model->id?>" class="rb-button rb-button-like rb-button-medium rb-button-responsive" tabindex="0">
                                        <?php echo $model->countLikes; ?>
                                    </button>
                                </div>
                            </li>
                            <li title="Добавить в книгу идей. Уже есть <?php echo Yii::t('app', '{n} книга идей|{n} две книги идей|{n} книг идей|{n} книг идей', $model->countIdeasBooks); ?>" class="rb-ministats-item">
                                <a class="graybutton" href="" id="AddToIdeabook" >
                                    <span class="graybuttonIcon uiButtonIconAddToIdeabook"><img height="20" width="20" src="<?php echo Yii::app()->baseUrl; ?>/images/fav.jpg"/></span>
                                    <span class="addBookmarkLink" id="<?php echo $model->id; ?>">Добавить в книгу идей</span>
                                </a>
                            </li>
                            <li class="rb-ministats-item">
<!--                                <div class="pluso" data-options="small,square,line,horizontal,counter,theme=04" data-services="vkontakte,facebook,twitter,google,email"></div>-->
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="<?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $model->countComments); ?>" class="rb-ministats-item">
                                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$model->id)); ?>" class="rb-ministats rb-ministats-small rb-ministats-comments">
                                    <span class="small_comments_i small_i"></span>
                                    <span ><?php echo $model->countComments;  ?> &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </a>
                            </li>
                            <li title="<?php echo Yii::t('app', '{n} книга идей|{n} две книги идей|{n} книг идей|{n} книг идей', $model->countIdeasBooks); ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_albums_i small_i"></span>
                                    <span><?php echo $model->countIdeasBooks; ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </span>
                            </li>
                            <li title="<?php echo $model->countLikes; ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_likes_i small_i"></span>
                                    <span><?php echo $model->countLikes; ?></span>
                                </span>
                            </li>
                            <li class="rb-ministats-item" style="margin-left: 5px;">
                                <div class="pluso" data-options="small,square,line,horizontal,counter,theme=04" data-services="vkontakte,facebook,twitter,google,email"></div>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="sotssety">
            </div>
        </div>

    </div>

    <div class="spoiler-content-2">
        <div class="scroll-content2">
            <div class="awtor">
                <img id="mainMemberCabinetPic"  src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $model->member->memberinfo->avatar; ?>" width="45" height="55">
                <h2 class="photoElement__title">
                    <?php echo CHtml::link($model->name ,array('mobilepictures/viewinfo','id'=>$model->id), array('target'=>'_blank', 'class'=>'rb-dark-link', 'title'=>'Просмотр фотографии'));  ?>
                </h2>
                <?php echo CHtml::link(CHtml::tag('h3',array('class'=>'photoElement__details rb-type-light'),$model->member->login),array('member/dashboard','id'=>$model->member->urlID), array('target'=>'_blank'));  ?>
            </div>
            <div class="info-foto">
<!--                <div class="foto-nazwa">-->
<!--                    <h3>Картинка 1</h3>-->
<!--                </div>-->
                <div class="foto-opys">
                    <p><?php echo $model->info; ?></p>
                </div>
                <div class="foto-tegi">
                    <?php if (count($tags)>0):  ?>
                        <span><strong>Теги:</strong></span>
                        <?php echo implode(", ",$tagNameArray); ?>
                    <?php endif;?>
                </div>
            </div>
            <div class="foto-kommentariy">
                <?php if ($model->countComments > 0): ?>
                    <div class="foto-kom-info">
                        <span><?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $model->countComments); ?></span>
                        <?php if($model->countComments > 5): ?> <a class="showAllComments" id="<?php echo $model->id; ?>" href="#">Показать все</a> <?php endif; ?>
                    </div>
                    <?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>
                    <div class="komments-users">
                        <?php foreach ($comments as $comment): ?>
                            <div class="oneComment" id="<?php echo $comment->id; ?>">
                                <div class="commentInfo tiny-text">
                                        <span>
                                            <abbr title="<?php echo $comment->dateTime;?>">
                                                <?php echo CHtml::openTag('abbr',array('class'=>'timeago',
                                                    'title'=>$comment->dateTime,
                                                ));?>
                                            </abbr>
                                        </span>
                                        <?php if (!Yii::app()->user->isGuest): ?>
                                            <span class="likeContainer">&nbsp;&nbsp;&nbsp;
                                                <a class="likeIcon"  id="<?php echo $comment->id; ?>" href="#"><img src=""><?php echo $comment->countlikes; ?></a>
                                            </span>
                                        <?php endif; ?>
                                </div>
                                <span class="user">
                                    <div class="commentThumb">
                                        <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" class="userAvatar">
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo$comment->member->memberinfo->avatar; ?>">
                                        </a>
                                    </div>
                                    <div class="comment-actions">
                                        <?php if($comment->member->id == Yii::app()->user->id): ?>
                                            <a id="<?php echo $comment->id; ?>" class="commentIcon commentDeleteIcon" title="Удалить комментарий">
                                                <img class="buttonsCommentAction buttonCommentDeleteIcon" src="">
                                            </a>
                                            <a id="<?php echo $comment->id; ?>" class="commentIcon commentEditIcon" title="Редактировать комментарий">
                                                <img class="buttonsCommentAction buttonCommentEditIcon" src="">
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <h4><?php echo CHtml::link($comment->member->login,array('member/dashboard', 'id'=>$comment->member->urlID));?></h4>
                                    <p><?php echo CHtml::encode($comment->content); ?></p>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="foto-kom-info">
                        <span>Еще нет комментариев</span>
                    </div>
                    <div class="komments-users">
                    </div>
                <?php endif; ?>
                <?php if (!Yii::app()->user->isGuest): ?>
<!--                    <div class="napisat-komment">-->
<!--                        <table class="table-comment">-->
<!--                            <tr>-->
<!--                                <td>-->
<!--                                    <form id="usercomment"action="fotocomment.php" method="POST" name="commentform">-->
<!--                                        <span>Напишите ваш комментарий к фото</span><br />-->
<!--                                        <textarea name="usercomment" cols="40" rows="5">-->
<!--                                        </textarea><br />-->
<!--                                        <input type="submit" name="button" value="Опубликовать" class="opublik">-->
<!--                                    </form>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                        </table>-->
<!--                    </div>-->
                <div class="napisat-komment">
                    <div class="commentError"></div>
                    <form id="commentForm" class="commentForm" method="post" action="">
                        <input type="hidden" name="photoID" value="<?php echo $model->id; ?>">
                        <div class="commentBodyContainer">
                            <textarea onkeydown="if(event.keyCode==9) return false;" class="commentBody" name="comment" maxlength="10000" cols="50" rows="3" placeholder="Напишите комментарий" style="resize: none;  overflow: hidden; word-wrap: break-word;"></textarea>
                            <div style="clear:both"></div>
                            <div class="addCommentExtra" style="display: block;">
                                <input id="addCommentButton" type="button" class="rbBtn submitComment" value="Отправить">
                            </div>
                    </form>
                </div>
            </div>
                <?php else : ?>
                    <?php echo CHtml::link('Зарегистрируйстесь', array('companies/register'));?> или <?php echo CHtml::link('войдите', array('site/login')); ?> под своим аккаунтом для возможности комментирования фотографий
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php
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
        <div class="phtError">
            Вы добавили уже это фото в данную книгу идей.
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    /************конец окна добавления фотографии в книгу идей****************/
?>

<?php
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
?>

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
?>

<?php
Yii::app()->clientScript->registerScript('galery', "

var issetIdeasBooks = true;
$('.addBookmarkLink').on ('click', function(event){
    event.preventDefault();
    $('#selectIdeasBookForm .addPhotoToIdeasBookBtn').attr('id',this.id);
    var selectedIdeasBook = $('#ideasBookList option:selected').val();
    var lengthOfIdeasBooks = $('#ideasBookList > option').length;
    if (lengthOfIdeasBooks!=1){
        $('.phtError').hide();
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

$('.addPhotoToIdeasBookBtn').on('click',function(event){
     event.preventDefault();
     var selectedIdeasBook = $('#ideasBookList option:selected').val();
         $.ajax({
                   type: 'POST',
                   url: '".Yii::app()->createUrl('ideasphotos/add')."',
                   data: {id: this.id, selectedIdeasBook: selectedIdeasBook},
                   success: function(msg){
                             var data = jQuery.parseJSON(msg);
                             if (data.id!='') {
                                $('#add_toIdeasBook').dialog('close');
                                $('.phtError').hide();
                                $('#tmpInfoPopup').dialog('open');
                             } else {
                                $('.phtError').show();
                             }
                   }
            });

});

$('#tmpInfoPopupBtn').on('click',function(event){
  if (issetIdeasBooks)
        $('#tmpInfoPopup').dialog('close');
  else window.location.href = '".Yii::app()->createUrl('ideasbook/add')."';
});

var newComment ='';
$('#addCommentButton').on('click', function(event){
    if ($('.commentBody').val() == '') {
        $('.commentError').html('Пожалуйста, напишите Ваш комментарий');
        return false;
    } else {
            $.ajax({
                   type: 'POST',
                   url: '".Yii::app()->createUrl('comments/add')."',
                   data: $('#commentForm').serialize(),
                   success: function(msg){
                   var data = jQuery.parseJSON(msg);


            var newComment = '<div class=\"oneComment\" id=\"'+data.commentID+'\">\
                                <div class=\"commentInfo tiny-text\">\
                                        <span> \
                                            <abbr class=\"timeago\" title=\"'+data.dateTime+'\">'+data.dateTime+'</abbr> \
                                        </span> \
                                        <span class=\"likeContainer\">&nbsp;&nbsp;&nbsp; \
                                             <a class=\"likeIcon\"  id=\"'+data.commentID+'\" href=\"#\"><img src=\"\">0</a> \
                                        </span> \
                                </div>\
                                <span class=\"user\">\
                                    <div class=\"commentThumb\"> \
                                       <a href=\"".Yii::app()->baseUrl."/member/dashboard/'+data.urlID+'\" class=\"userAvatar\"> \
                                         <img src=\"".Yii::app()->baseUrl."/images/members/avatars/'+data.avatar+'\"> \
                                       </a> \
                                    </div> \
                                    <div class=\"comment-actions\">\
                                        <a id=\"'+data.commentID+'\" class=\"commentIcon commentDeleteIcon\" title=\"Удалить комментарий\">\
                                            <img class=\"buttonsCommentAction buttonCommentDeleteIcon\" src=\"\">\
                                        </a>\
                                        <a id=\"'+data.commentID+'\" class=\"commentIcon commentEditIcon\" title=\"Редактировать комментарий\">\
                                            <img class=\"buttonsCommentAction buttonCommentEditIcon\" src=\"\">\
                                        </a>\
                                    </div>\
                                    <h4><a href=\"".Yii::app()->baseUrl."/member/dashboard/'+data.urlID+'\" class=\"userAvatar\">'+data.login+'</a></h4>\
                                    <p>'+data.comment+'</p>\
                                </span>\
                            </div>';


                     $('div.foto-kom-info').html(data.countComments);
                     $('.komments-users').append(newComment);
                     $('abbr.timeago').timeago();
                     $('.commentError').html();
                     $('textarea.commentBody').val('');
                   }
                 });
    }
    return event.defaultPrevented || event.returnValue == false;
});



", CClientScript::POS_END);
?>
