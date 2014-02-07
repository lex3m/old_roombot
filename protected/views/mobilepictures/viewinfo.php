<script type="text/javascript">
    //USAGE: $("#form").serializefiles();
    (function($) {
        $.fn.serializefiles = function() {
            var obj = $(this);
            /* ADD FILE TO PARAM AJAX */
            var formData = new FormData();
            $.each($(obj).find("input[type='file']"), function(i, tag) {
                $.each($(tag)[0].files, function(i, file) {
                    formData.append(tag.name, file);
                });
            });
            var params = $(obj).serializeArray();
            $.each(params, function (i, val) {
                formData.append(val.name, val.value);
            });
            return formData;
        };
    })(jQuery);
</script>
<?php
Yii::app()->clientScript->registerScript('user-tags', "
        $('.img-tags').addClass('animated swing');

        $('.main').on('mouseenter', function ( e )  {
            $('.imageTagPopup').hide();
            $('.img-tags').css('z-index', 5);
        });


        /*$('.images').on('mouseenter', function ( e ) {
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

        $('.images').on('mouseleave', function ( e ) {
            $('.img-tags').hide();
        });*/

        $('.images').on('mouseenter', '.img-tags', function( e ) {
            $(this).css('z-index', 20);
            if ($('.imageTagPopup').is(':visible'))
                $('.imageTagPopup').hide();

            var imgHeight = $('.main').height();
            var imgWidth = $('.main').width();

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
            'title'=>'Add photo tag',
        ),
    ));
    ?>
    <form id="tagFormPopup" class="tagFormPopup" method="post" action="" style="display: none;" enctype="multipart/form-data">
        <input type="hidden" name="photoID" value="<?php echo $model->id;?>">
        <div class="tagBodyContainerPopup">
            <div class="row-form">
                <b>Tag name</b> (max 100 chars) <span style="color: red">*</span>
                <input type="text" class="tagBodyPopup" id="name" name="name" maxlength="100" style="width:365px"/> </br>
            </div>
            <div class="row-form">
                <b>Description</b> (max 255 chars) <span style="color: red">*</span>
                <textarea style="resize: none; height: 80px;  width: 365px; overflow: hidden; word-wrap: break-word;" class="tagBodyPopup" id="description" name="description" maxlength="255" ></textarea> </br>
            </div>
            <div class="row-form">
                <b>Image</b> (Allowed .jpg, .png, .gif extensions)
                <?php echo CHtml::activeFileField(new Phototag(), 'image', array('id'=>'image','class'=>'tagBodyPopup', 'accept'=>'image/jpg, image/jpeg, image/png, image/gif')); ?>
<!--                <input type="file" accept="image/jpg, image/jpeg, image/png, image/gif" class="tagBodyPopup" id="image" name="image" style="width:365px"/> </br>-->
            </div>
            <div class="row-form">
                <b>Link to product</b> (e.g. http://example.com/product)
                <input type="text" class="tagBodyPopup" id="image_link" name="image_link" maxlength="2048" style="width:365px"/> </br>
            </div>
            <div class="row-form">
                <b>Estimated price</b>
                $ <input type="text" class="tagBodyPopup" id="price" name="price" maxlength="6" size="6"/> </br>
            </div>
            <span class="phtError"></span>
            <div style="clear:both"></div>
            <div style="display: block;" class="confirmDialog">
                <input style="cursor: pointer;" id="addTagButtonPopup" type="button" class="rbBtn submitAddTag" value="Confirm">
            </div>
        </div>
        <input type="hidden" name="tid" value="">
    </form>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');

    Yii::app()->clientScript->registerScript('photo-tags', "
        $('img.main').css('cursor', 'crosshair');

        $('.tagBodyPopup').on('keypress', function ( e ) {
            $(this).removeClass( 'ui-state-error');
        });

        $('img.main').on('click', function ( e ) {

            var that = $(this).parent();
            /*x = e.pageX - this.offsetLeft;
            y = e.pageY - this.offsetTop;

            var height = this.height;
            var width = this.width;

            var imgHeight = this.naturalHeight;
            var imgWidth = this.naturalWidth;

            var dX = imgHeight / height;
            var dY = imgWidth / width;

            imgX = Math.round(dX * x);
            imgY = Math.round(dY * y);*/

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
            var button = '<input style=\"cursor: pointer;\" type=\"button\" class=\"rbBtn submitAddTag\" value=\"Confirm\" id=\"addTagButtonPopup\">';
            $('.confirmDialog').html(button);
            $('#photoTag').dialog('option', 'title', 'Add photo tag');

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
                                   price = 'Estimated price $ <span class=\"imageTagPopupPriceNotLinked\">'+price+'</span>';
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
                                $('#photoTag').dialog('close');
                                $('.imageTagPopup').hide();
                                $('input[name=\"tid\"]').val(tagId);
                                $('.submitAddTag').remove();
                                var button = '<input style=\"cursor: pointer;\" type=\"button\" class=\"rbBtn submitAddTag\" value=\"Confirm\" id=\"editTagButtonPopup\">';
                                $('.confirmDialog').html(button);
                                $('.phtError').hide();
                                $('.tagBodyPopup').removeClass( 'ui-state-error' );
                                $('#tagFormPopup').show();
                                $('#photoTag').dialog('option', 'title', 'Edit photo tag');
                                $('#photoTag').dialog('open');
                            } else {
                                alert('error handling here');
                            }
                       }
                    });
        });

        $(document).on('click','#editTagButtonPopup',function(e){
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
                                    p.html('Estimated price $ <span class=\"imageTagPopupPriceNotLinked\">'+price+'</span>');

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
             if (confirm('Are you sure want to delete this tag?')) {
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

<style>

</style>
<div class="list-bot izo-list">
<h1>View photo</h1><h2><?php echo $model->name; ?></h2>
<span>Uploaded by:&nbsp;<?php echo CHtml::link($model->member->login,array('member/dashboard','id'=>$model->member->urlID));  ?></span><br/>
<?php //echo CHtml::link('Назад к списку',array('member/dashboard','id'=>$member->urlID));?>
<?php // echo $model->name; ?><!--<br>-->
<div class="photo-description">
    <?php if (!empty($model->info)): ?><span>Description: </span> <?php echo $model->info; ?><?php endif;?>
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
                }
            })();
    </script>
    <div class="pluso" data-background="#000000" data-options="small,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,digg,pinme,pinterest,liveinternet,linkedin,memori,webdiscover,moikrug,yandex,print"></div>
    <div class="images">
<!--        <img id="mainImage" name="mainImage" class="viewImage" style=";padding:0px 0px;" src="http://st.houzz.com/simgs/40511835025dabed_4-9899/craftsman-kitchen.jpg" alt="Library ladder in Kitchen craftsman kitchen" width="640" height="426" onmouseover="onImageMouseOver(this,event);" onmouseout="onImageMouseOut(this,event);" onmousedown="preventImageDrag(event)"  onclick="">-->
        <img class="main" height="580px" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $model->image; echo '?' . time() ?>" alt="<?php echo $model->name;?>"  ondragstart="return false" onselectstart="return false"/><br/>
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
                                    Estimated price $<span class="imageTagPopupPriceNotLinked"><?php echo $pt->price;?></span>
                                <?php endif; ?>
                                <!--<button
                                    class="rbBtn primary imageTagPopupButton imageTagPopupButtonNoMargin imageTagPopupInfo"
                                    type="button" onclick="imageTagsViewScreen.openProduct()">More Info
                                </button>-->
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif;?>
    </div>
    <?php if (!Yii::app()->user->isGuest) { ?>
    <div class="linkBookmark" style="margin-bottom: 10px;">
        <a class="addBookmarkLink" id="<?php echo $model->id; ?>" onclick="return false;" href="#">
            <span class="graybuttonIcon uiButtonIconAddToIdeabook"><img height="20" width="20" src="/images/fav.jpg"></span>
            <span class="addBookmark">Add to Ideabook</span>
        </a>
    </div>
    <?php  } ?>
    <div class="dateTags">
        <?php echo $model->date; ?> <br/>
        <?php if (count($tags)>0):  ?>
            Tags:&nbsp;
            <?php
               echo implode(", ",$tagNameArray);
            ?>
        <?php endif; ?>
    </div>
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
                <textarea style="width:100%;" class="commentBody" name="comment" maxlength="10000" placeholder="Leave your comment" style="resize: none; height: 32px; overflow: hidden; word-wrap: break-word;"></textarea>
            <div style="clear:both"></div>
            <div class="addCommentExtra" style="display: block;">     
                <input id="addCommentButton" type="button" class="rbBtn submitAddComment" value="Submit">
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
        'title'=>'Edit comment',
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
        'title'=>'Add photo to ideabook',
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
              array('empty' => '(Choose your ideabook)'));  ?>
    </div>
     <input id="" type="button" class="rbBtn addPhotoToIdeasBookBtn" value="Add">
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
        'title'=>'Adding photo to ideabook',
    ),
));
?>
<p class="tmpInfoMsg">You successfully added this photo to ideabook</p>
<div class="form">
    <input id="tmpInfoPopupBtn" type="button" class="rbBtn tmpInfoBtn" value="Ok">
</div><!-- form -->
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
/************конец окна успешного добавления фотографии к книге идей****************/


       Yii::app()->clientScript->registerScript('comment-tags',"

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
                                $('.commentBodyContent#'+data.id).remove();
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
else echo 'Sign up or login to leave your comment.';
?>