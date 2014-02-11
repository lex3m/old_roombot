<?php
Yii::app()->clientScript->registerScript('helper-messages', '
          yiim = {
              messages: {
                submit: "'.Yii::t('sitePhotos', 'Submit').'",
                eprice: "'.Yii::t('sitePhotos', 'Estimated price').'",
                aptag: "'.Yii::t('sitePhotos', 'Add photo tag').'",
                eptag: "'.Yii::t('sitePhotos', 'Edit photo tag').'",
                confirm: "'.Yii::t('sitePhotos', 'Are you sure want to delete this tag?').'",
              }
          };
      ');

Yii::app()->clientScript->registerScript('pluso-start', "
    pluso.start();
", CClientScript::POS_END);
if (Yii::app()->user->id == $model->member->id):
    /*****Adding tag to photo*****/
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'photoTag',
        'options'=>array(
            'autoOpen'=>false,
            'closeOnEscape'=> true,
            'width'=>400,
            'height'=>385,
            'show'=>'show',
            'hide'=>'explode',
            'resizable'=>false,
            'title'=> Yii::t('sitePhotos','Add photo tag'),
        ),
    ));
    ?>
    <form id="tagFormPopup" class="tagFormPopup" method="post" action="" style="display: none;" enctype="multipart/form-data">
        <input type="hidden" name="photoID" value="<?php echo $model->id;?>">
        <div class="tagBodyContainerPopup">
            <div class="row-form">
                <b><?php echo Yii::t('sitePhotos','Tag name');?> </b> (<?php echo Yii::t('sitePhotos','max 100 chars');?>) <span style="color: red">*</span>
                <input type="text" class="tagBodyPopup" id="name" name="name" maxlength="100" style="width:365px"/> </br>
            </div>
            <div class="row-form">
                <b><?php echo Yii::t('sitePhotos','Description');?> </b> ( <?php echo Yii::t('sitePhotos','max 255 chars');?>) <span style="color: red">*</span>
                <textarea style="resize: none; height: 80px;  width: 365px; overflow: hidden; word-wrap: break-word;" class="tagBodyPopup" id="description" name="description" maxlength="255" ></textarea> </br>
            </div>
            <div class="row-form">
                <b><?php echo Yii::t('sitePhotos','Image');?></b> (<?php echo Yii::t('sitePhotos', 'Allowed .jpg, .png, .gif extensions')?>)
                <?php echo CHtml::activeFileField(new Phototag(), 'image', array('id'=>'image','class'=>'tagBodyPopup', 'accept'=>'image/jpg, image/jpeg, image/png, image/gif')); ?>
            </div>
            <div class="row-form">
                <b><?php echo Yii::t('sitePhotos','Link to product');?></b> (http://example.com/product)
                <input type="text" class="tagBodyPopup" id="image_link" name="image_link" maxlength="2048" style="width:365px"/> </br>
            </div>
            <div class="row-form">
                <b><?php echo Yii::t('sitePhotos','Estimated price');?></b>
                $ <input type="text" class="tagBodyPopup" id="price" name="price" maxlength="6" size="6"/> </br>
            </div>
            <span class="phtError"></span>
            <div style="clear:both"></div>
            <div style="display: block;" class="confirmDialog">
                <input style="cursor: pointer;" id="addTagButtonPopup" type="button" class="rbBtn submitAddTag" value="<?php echo Yii::t('sitePhotos','Submit');?>">
            </div>
        </div>
        <input type="hidden" name="tid" value="">
    </form>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');

    Yii::app()->clientScript->registerScript('add-photo-tags', "
        $('img.image_full').css('cursor', 'crosshair');

        $('.tagBodyPopup').on('keypress', function ( e ) {
            $(this).removeClass( 'ui-state-error');
        });

        $('img.image_full').on('click', function ( e ) {
            e.stopPropagation();
            var that = $(this).parent();
            x = e.clientX;
            y = e.clientY;
            $('.phtError').hide();
            $('.tagBodyPopup').val('');
            $('.tagBodyPopup').removeClass( 'ui-state-error' );

            $('#photoTag').dialog( 'option', 'hide', { effect: 'explode', duration: 500 } );
            $('#photoTag').dialog('close');
            $('#photoTag').dialog({ position: [x,  y + 40]});
            $('#tagFormPopup').show();
            $('input[name=\"tid\"]').val('');
            $('#image').val('');
            $('.submitAddTag').remove();
            var button = '<input style=\"cursor: pointer;\" type=\"button\" class=\"rbBtn submitAddTag\" value=\"'+yiim.messages.submit+'\" id=\"addTagButtonPopup\">';
            $('.confirmDialog').html(button);
            $('#photoTag').dialog('option', 'title', yiim.messages.aptag);

            $('#photoTag').dialog('open');

            if(e.offsetX==undefined) // this works for Firefox
            {
                tagX = Math.round(e.pageX-$('.main').offset().left);
                tagY = Math.round(e.pageY-$('.main').offset().top);
            }
            else  // works in Google Chrome
            {
                tagX = e.offsetX;
                tagY = e.offsetY;
            }

            $('#none.img-tags').remove();
            that.append(\"<div class='img-tags' id='none'/></div>\");
            $('#none.img-tags').show();
            $('#none.img-tags').css('left', tagX);
            $('#none.img-tags').css('top',  tagY);

            $( '#photoTag' ).dialog({
                beforeClose: function( event, ui ) {
                    $('#none.img-tags').remove();
                }
            });
        });

         $(document).on('click', '#addTagButtonPopup', function ( e ) {

           var formData = $('#tagFormPopup').serializefiles();
           formData.append('coordX', tagX);
           formData.append('coordY', tagY);

           $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('phototag/add')."',
                       data: formData,
                       async: false,
                       cache: false,
                       contentType: false,
                       processData: false,
                       success: function(msg){
                             var msg = $.parseJSON(msg);
                             if (msg.saved == true) {
                                var pid = $('input[name=\"photoID\"]').val();
                                var name = $('#name').val();
                                var description = $('#description').val();
                                var link = $('#image_link').val();
                                if (link != '') {
                                    link = 'href=\"'+link+'\"';
                                }
                                var price = $('#price').val();
                                if (price != '') {
                                   price = 'yiim.messages.eprice $ <span class=\"imageTagPopupPriceNotLinked\">'+price+'</span>';
                                }
                                var image = '';
                                if (msg.image !== null) {
                                    image = '<img src=\"".Yii::app()->baseUrl."/images/products/'+msg.image+'\" style=\"max-width: 100px; height:100px\">';
                                }

                                var newPhotoTag = $('#none.img-tags').attr('id', pid);

                                var newImageTagPopup = '<div id=\"'+msg.tid+'\" class=\"imageTagPopup\" style=\"left: '+tagX+'px; top: '+tagY+'px; display: none;\">\
                                                            <div id=\"imageTagBackground\" style=\"width: 300px;\"></div>\
                                                            <div class=\"imageTagPopupContainer\" style=\"position:relative;top:0;left:0;opacity:1;\">\
                                                                <div class=\"imageTagPopupActions\">\
                                                                    <a id=\"'+msg.tid+'\" class=\"tagIcon\" style=\"margin-left: 130px;\">\
                                                                        <img class=\"buttonsCommentAction buttonTagEditIcon\" title=\"Edit\">\
                                                                    </a>\
                                                                    <a id=\"'+msg.tid+'\" class=\"tagIcon\" >\
                                                                        <img class=\"buttonsCommentAction buttonTagDeleteIcon\" title=\"Delete\">\
                                                                    </a>\
                                                                </div>\
                                                                <div id=\"imageTagPopupTitle\" style=\"padding-left: 25px; padding-right: 40px;\">\
                                                                    <a class=\"imageTagPopupProductImage\" style=\"float:left;margin-right:5px\" '+link+' target=\"_blank\">\
                                                                        '+image+'\
                                                                    </a>\
                                                                    <div class=\"imageTagPopupProductTitle\"><a '+link+' target=\"_blank\">'+name+'</a></div>\
                                                                    <div style=\"clear:both\"></div>\
                                                                </div>\
                                                                <div id=\"imageTagPopupBody\">\
                                                                    <div class=\"imageTagPopupDescription\">'+description+'</div>\
                                                                    <div class=\"imageTagPopupBottom\">\
                                                                        '+price+'\
                                                                    </div>\
                                                                </div>\
                                                            </div>\
                                                        </div>';
                                newPhotoTag.after(newImageTagPopup);
                                $('#image').val('');
                                $('#photoTag').dialog( 'option', 'hide', { effect: 'fold', duration: 500 } );
                                $('#photoTag').dialog('close');
                             } else {
                                $('.phtError').html('');
                                $.each(msg, function ( i, val ) {
                                    $('#'+i).addClass( 'ui-state-error');
                                    $('.phtError').append(val[0]);
                                });
                                $('.phtError').show();
                             }
                       }, error: function(){
                            alert('error handling here');
                       }
           });
        });

         $(document).on('click', '.buttonTagEditIcon', function ( e ) {
             var tagId = $(this).parent().attr('id');
             $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('phototag/getInfo')."',
                       data: {id: tagId},
                       success: function(msg) {
                            data = $.parseJSON(msg);
                            if (data.id !== '') {
                                $('#photoTag').dialog({ position: [e.clientX - 130 ,  e.clientY + 40]});
                                $.each(data, function ( i, val ) {
                                    if (i !== 'image')
                                        $('#'+i).val(val);
                                });
//                                $('#photoTag').dialog('close');
                                $('.imageTagPopup').hide();
                                $('input[name=\"tid\"]').val(tagId);
                                $('.submitAddTag').remove();
                                var button = '<input style=\"cursor: pointer;\" type=\"button\" class=\"rbBtn submitAddTag\" value=\"'+yiim.messages.submit+'\" id=\"editTagButtonPopup\">';
                                $('.confirmDialog').html(button);
                                $('.phtError').hide();
                                $('.tagBodyPopup').removeClass( 'ui-state-error' );
                                $('#tagFormPopup').show();
                                $('#photoTag').dialog('option', 'title', yiim.messages.eptag);
                                $('#photoTag').dialog('open');
                            } else {
                                alert('error handling here');
                            }
                       }
                    });
        });

        $(document).on('click', '#editTagButtonPopup',function(e){
           var formData = $('#tagFormPopup').serializefiles();
           $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('phototag/edit')."',
                       data: formData,
                       async: false,
                       cache: false,
                       contentType: false,
                       processData: false,
                       success: function(msg){
                            msg = $.parseJSON(msg);
                            if (msg.saved == true) {
                                $('.tagBodyPopup').removeClass('ui-state-error');
                                $('.phtError').html('');

                                var pid = $('input[name=\"photoID\"]').val();
                                var tid = $('input[name=\"tid\"]').val();

                                var name = $('#name').val();
                                var description = $('#description').val();
                                var link = $('#image_link').val();
                                var price = $('#price').val();
                                var image = msg.image;

                                var obj = $('#'+tid+'.imageTagPopup');
                                var n = obj.find('.imageTagPopupProductTitle a');
                                var d = obj.find('.imageTagPopupDescription');
                                n.html(name);
                                d.html(description);
                                var i = obj.find('.imageTagPopupProductImage');
                                if (image !== '')
                                    i.html('<img src=\"".Yii::app()->baseUrl."/images/products/'+image+'\" style=\"max-width: 100px; height:100px\">');
                                else
                                    i.html('');
                                var p = obj.find('.imageTagPopupBottom');
                                if (price == '' || price == 0)
                                    p.html('');
                                else
                                    p.html('yiim.messages.eprice $ <span class=\"imageTagPopupPriceNotLinked\">'+price+'</span>');

                                if (link !== '') {
                                    n.attr('href', link);
                                    i.attr('href', link);
                                } else {
                                    n.removeAttr('href');
                                    i.removeAttr('href');
                                }

                                $('#image').val('');
                                $('#photoTag').dialog( 'option', 'hide', { effect: 'fold', duration: 500 } );
                                $('#photoTag').dialog('close');
                            } else {
                                $('.phtError').html('');
                                $.each(msg, function ( i, val ) {
                                    $('#'+i).addClass( 'ui-state-error');
                                    $('.phtError').append(val[0]);
                                });
                                $('.phtError').show();
                            }
                        },
                        error: function(msg){
                            alert(msg.responseText);
                        }
           });
        });
       $(document).on('click', '.buttonTagDeleteIcon', function ( e ) {
             var tagId = $(this).parent().attr('id');
             if (confirm(yiim.messages.confirm)) {
                $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('phototag/delete')."',
                       data: {id: tagId},
                       dataType: 'json',
                       success: function(msg) {
                            if (msg) {
                                var obj = $('.imageTagPopup#'+tagId);
                                var prevObj = $('.imageTagPopup#'+tagId).prev();
                                obj.remove();
                                prevObj.remove();
                            } else {
                                alert('error handling here');
                            }
                       }
                });
             } else {
                return false;
             }
        });
    ",CClientScript::POS_READY);
endif;
?>
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
                <img class="image_full" height="580" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $model->image; echo '?' . time() ?>" ondragstart="return false" onselectstart="return false" />
                <?php if (!empty($photoTags)): ?>
                    <?php foreach ($photoTags as $pt): ?>
                        <div class="img-tags" id="<?php echo $pt->photoID;?>" style="left: <?php echo $pt->coordX . 'px';?>; top: <?php echo $pt->coordY . 'px';?>;"></div>
                        <div id="<?php echo $pt->id;?>" class="imageTagPopup" style="left: <?php echo $pt->coordX . 'px';?>; top: <?php echo $pt->coordY . 'px';?>;">
                            <div id="imageTagBackground" style="width: 300px;"></div>
                            <div class="imageTagPopupContainer" style="position:relative;top:0;left:0;opacity:1;">
                                <?php if (Yii::app()->user->id == $model->member->id): ?>
                                    <div class="imageTagPopupActions">
                                        <a id="<?php echo $pt->id; ?>" class="tagIcon" style="margin-left: 130px;">
                                            <img class="buttonsCommentAction buttonTagEditIcon" title="Edit">
                                        </a>
                                        <a id="<?php echo $pt->id; ?>" class="tagIcon" >
                                            <img class="buttonsCommentAction buttonTagDeleteIcon" title="Delete">
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div id="imageTagPopupTitle" style="padding-left: 30px; padding-right: 30px;">
                                    <a class="imageTagPopupProductImage" style="float:left;margin-right:5px; width: 100px;" <?php echo !empty($pt->image_link) ? 'href="'.$pt->image_link.'"': '';?> target="_blank">
                                        <?php if (!empty($pt->image)): ?>
                                            <img src="<?php echo Yii::app()->baseUrl. '/images/products/'. $pt->image;?>" style="max-width: 100px; height:100px">
                                        <?php endif; ?>
                                    </a>
                                    <div class="imageTagPopupProductTitle"><a <?php echo !empty($pt->image_link) ? 'href="'.$pt->image_link.'"': '';?> target="_blank"><?php echo $pt->name;?></a></div>
                                    <div style="clear:both"></div>
                                </div>
                                <div id="imageTagPopupBody">
                                    <div class="imageTagPopupDescription">
                                        <?php echo $pt->description; ?>
                                    </div>
                                    <div class="imageTagPopupBottom">
                                        <?php if ($pt->price > 0): ?>
                                           <?php echo Yii::t('sitePhotos', 'Estimated price');?> $<span class="imageTagPopupPriceNotLinked"><?php echo $pt->price;?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif;?>
            </div>
        </div>

        <div class="sotcial">
            <div class="photoElement__stats stats-left">
                <?php if (!Yii::app()->user->isGuest):?>
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="<?php echo Yii::t('sitePhotos', 'Like photo. Count of likes');?> - <?php echo $model->countLikes; ?>" class="rb-ministats-item">
                                <div class="rb-button-group rb-button-group-medium">
                                    <button id="likePhoto" data-likes="0" data-id="<?php echo $model->id?>" class="rb-button rb-button-like rb-button-medium rb-button-responsive" tabindex="0">
                                        <?php echo $model->countLikes; ?>
                                    </button>
                                </div>
                            </li>
                            <li title="<?php echo Yii::t('sitePhotos', 'Add to ideabook. Aready in'); ?> -  <?php echo Yii::t('sitePhotos', '{n} ideabook| {n} ideabooks', $model->countIdeasBooks); ?>" class="rb-ministats-item">
                                <a class="addBookmarkLink" id="<?php echo $model->id; ?>" >
                                    <span class="graybuttonIcon uiButtonIconAddToIdeabook"><img height="20" width="20" src="<?php echo Yii::app()->baseUrl; ?>/images/fav.jpg"/></span>
                                    <span class="addBookmark"><?php echo Yii::t('sitePhotos', 'Add to Ideabook');?></span>
                                </a>
                            </li>
                            <li class="rb-ministats-item">
                                <div class="pluso" data-options="small,square,line,horizontal,counter,theme=04" data-services="vkontakte,facebook,twitter,google,email"></div>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="<?php echo Yii::t('sitePhotos', '{n} comment|{n} comments', $model->countComments); ?>" class="rb-ministats-item">
                                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$model->id)); ?>" class="rb-ministats rb-ministats-small rb-ministats-comments">
                                    <span class="small_comments_i small_i"></span>
                                    <span ><?php echo $model->countComments;  ?> &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </a>
                            </li>
                            <li title="<?php echo Yii::t('sitePhotos', '{n} ideabook| {n} ideabooks', $model->countIdeasBooks); ?>" class="rb-ministats-item">
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
                    <?php echo CHtml::link($model->name ,array('mobilepictures/viewinfo','id'=>$model->id), array('target'=>'_blank', 'class'=>'rb-dark-link', 'title'=>Yii::t('sitePhotos', 'Show photo')));  ?>
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
                        <span><strong><?php echo Yii::t('sitePhotos', 'Tags');?>:</strong></span>
                        <?php echo implode(", ",$tagNameArray); ?>
                    <?php endif;?>
                </div>
            </div>
            <div class="foto-kommentariy">
                <?php if ($model->countComments > 0): ?>
                    <div class="foto-kom-info">
                        <span><?php echo Yii::t('sitePhotos', '{n} comment|{n} comments', $model->countComments); ?></span>
                        <?php if($model->countComments > 5): ?> <a class="showAllComments" id="<?php echo $model->id; ?>" href="#"><?php echo Yii::t('sitePhotos', 'Show all comments');?></a> <?php endif; ?>
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
                                            <a id="<?php echo $comment->id; ?>" class="commentIcon commentDeleteIcon" title="<?php echo Yii::t('sitePhotos', 'Delete comment');?>">
                                                <img class="buttonsCommentAction buttonCommentDeleteIcon" src="">
                                            </a>
                                            <a id="<?php echo $comment->id; ?>" class="commentIcon commentEditIcon" title="<?php echo Yii::t('sitePhotos', 'Edit comment');?>">
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
                        <span><?php echo Yii::t('sitePhotos', 'No comments yet');?></span>
                    </div>
                    <div class="komments-users">
                    </div>
                <?php endif; ?>
                <?php if (!Yii::app()->user->isGuest): ?>
                <div class="napisat-komment">
                    <div class="commentError"></div>
                    <form id="commentForm" class="commentForm" method="post" action="">
                        <input type="hidden" name="photoID" value="<?php echo $model->id; ?>">
                        <div class="commentBodyContainer">
                            <textarea onkeydown="if(event.keyCode==9) return false;" onkeyup="if(event.keyCode==37 || event.keyCode==39) event.stopPropagation(); return false;" class="commentBody" name="comment" maxlength="10000" cols="50" rows="3" placeholder="<?php echo Yii::t('sitePhotos', 'Leave your comment');?>" style="resize: none;  overflow: hidden; word-wrap: break-word;"></textarea>
                            <div style="clear:both"></div>
                            <div class="addCommentExtra" style="display: block;">
                                <input id="addCommentButton" type="button" class="rbBtn submitComment" value="<?php echo Yii::t('sitePhotos','Submit');?>">
                            </div>
                    </form>
                </div>
            </div>
                <?php else : ?>
                    <?php echo CHtml::link(Yii::t('sitePhotos','Sign up'), array('companies/register'));?> <?php echo Yii::t('siteIndex','or'); ?> <?php echo CHtml::link(Yii::t('sitePhotos','log in'), array('site/login'));?> <?php echo Yii::t('sitePhotos','in your account to comment photos');?>
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
        'title'=>Yii::t('sitePhotos', 'Add photo to ideabook'),
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
                array('empty' => Yii::t('sitePhotos', 'Choose your ideabook') ));  ?>
        </div>
        <input id="" type="button" class="rbBtn addPhotoToIdeasBookBtn" value="<?php  echo Yii::t('sitePhotos', 'Add'); ?>">
        <div class="phtError">
            <?php  echo Yii::t('sitePhotos', 'You have already added this photo to ideabook.') ?>
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
            'title'=>Yii::t('sitePhotos', 'Add photo to ideabook'),
        ),
    ));
    ?>
    <p class="tmpInfoMsg">
        <?php  echo Yii::t('sitePhotos', 'You have successfully added this photo to ideabook') ?>
    </p>
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
        'title'=>Yii::t('sitePhotos', 'Edit comment'),
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
Yii::app()->clientScript->registerScript('messages', '
translate = {
    message: {
        deleteComment: "'.Yii::t('sitePhotos', 'Delete comment').'",
        editComment: "'.Yii::t('sitePhotos', 'Edit comment').'",
        emptyIdeabook: "'.Yii::t('sitePhotos', 'You do not have any ideabook.').'",
        createIdeabook: "'.Yii::t('sitePhotos', 'Create').'",
        inIdeabook: "'.Yii::t('sitePhotos', 'You have already added this photo to ideabook.').'",
        chooseIdeabook: "'.Yii::t('sitePhotos', 'Choose your ideabook').'",
        leaveComment: "'.Yii::t('sitePhotos', 'Leave your comment').'",
    }
};
');
?>
<?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>
<?php
Yii::app()->clientScript->registerScript('photo-tags', "
        $('.img-tags').addClass('animated swing');

        $('.image_full').on('mouseenter', function ( e )  {
            $('.imageTagPopup').hide();
            $('.img-tags').css('z-index', 5);
        });

        /*$('.usfot').on('mouseenter', function ( e ) {
            $('.img-tags').show();
            $('#photoTag').parents('.ui-dialog').mouseenter(function() {
                var tid = $('input[name=\"tid\"]').val();
                if (tid !== '')
                    $('.imageTagPopup#'+ tid).prev().show();
                else
                    $('#none').show();
            });
        });

        $('#photoTag').parents('.ui-dialog').on('mouseenter', function ( e ) {
            $('.img-tags').show();
        });

        $('.usfot').on('mouseleave', function ( e ) {
            $('.img-tags').hide();
        });*/

        $('.usfot').on('mouseenter', '.img-tags', function( e ) {
            $(this).css('z-index', 20);
            if ($('.imageTagPopup').is(':visible'))
                $('.imageTagPopup').hide();

            var imgHeight = $('.usfot').height();
            var imgWidth = $('.usfot').width();

            var tagWidth = this.offsetLeft;
            var tagHeight = this.offsetTop;

            var popup =  $(this).next();

            /*Detect coords for tag corner*/
            if (imgWidth - tagWidth < popup.width()) {
                popup.css('left', tagWidth - popup.width() + 40);
            }
            if (imgHeight - tagHeight < popup.height()) {
                popup.css('top', tagHeight - popup.height() + 40);
            }

            popup.show();
        });

        $('.imageTagPopup').on('mouseleave', function ( e ) {
             $(this).hide();
        });
", CClientScript::POS_READY);

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
        $('p.tmpInfoMsg').text(translate.message.emptyIdeabook);
        $('#tmpInfoPopupBtn').val(translate.message.createIdeabook);
        $('#tmpInfoPopup').dialog('open');
    }
    return event.defaultPrevented || event.returnValue == false;
});

$('.addPhotoToIdeasBookBtn').on('click',function(event){
     event.preventDefault();
     var selectedIdeasBook = $('#ideasBookList option:selected').val();
     if (selectedIdeasBook !== '') {
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
                                $('.phtError').html(translate.message.inIdeabook).show();
                             }
                   }
            });
     } else {
        $('.phtError').html(translate.message.chooseIdeabook).show();
     }

});

$('#tmpInfoPopupBtn').on('click',function(event){
  if (issetIdeasBooks)
        $('#tmpInfoPopup').dialog('close');
  else window.location.href = '".Yii::app()->createUrl('ideasbook/add')."';
});

var newComment ='';

$('.commentBody').on('keydown', function (e) {
  if (e.ctrlKey && e.keyCode == 13) {
    // Ctrl-Enter pressed
    $('#addCommentButton').trigger('click');
  }
});

$('#addCommentButton').on('click', function(event){
    if ($('.commentBody').val() == '') {
        $('.commentError').html(translate.message.leaveComment);
        return false;
    } else {
            $.ajax({
                   type: 'POST',
                   url: '".Yii::app()->createUrl('comments/add')."',
                   data: $('#commentForm').serialize(),
                   beforeSend: function (){
                        $('.spoiler-content-2').addClass('loading');
                   },
                   complete: function() {
                        $('.spoiler-content-2').removeClass('loading');
                   },
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
                                        <a id=\"'+data.commentID+'\" class=\"commentIcon commentDeleteIcon\" title=\"'+translate.message.deleteComment+'\">\
                                            <img class=\"buttonsCommentAction buttonCommentDeleteIcon\" src=\"\">\
                                        </a>\
                                        <a id=\"'+data.commentID+'\" class=\"commentIcon commentEditIcon\" title=\"'+translate.message.editComment+'\">\
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
