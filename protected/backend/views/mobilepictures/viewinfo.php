<?php
Yii::app()->clientScript->registerScript('user-tags', "
        $('.img-tags').addClass('animated swing');

        $('.main').on('mouseenter', function ( e )  {
            $('.imageTagPopup').hide();
            $('.img-tags').css('z-index', 5);
        });

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

    /*****Adding tag to photo*****/
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'photoTag',
        'options'=>array(
            'autoOpen'=>false,
            'closeOnEscape'=> true,
            'width'=>400,
            'height'=>420,
            'show'=>'show',
            'hide'=>'explode',
            'resizable'=>false,
            'title'=>'Добавить ярлык на фото',
        ),
    ));
    ?>
    <form id="tagFormPopup" class="tagFormPopup" method="post" action="" style="display: none;" enctype="multipart/form-data">
        <input type="hidden" name="photoID" value="<?php echo $model->id;?>">
        <div class="tagBodyContainerPopup">
            <div class="row-form">
                <b>Имя ярлыка</b> (макс 100 символов) <span style="color: red">*</span>
                <input type="text" class="tagBodyPopup" id="name" name="name" maxlength="100" style="width:365px"/> </br>
            </div>
            <div class="row-form">
                <b>Описание</b> (макс 255 символов) <span style="color: red">*</span>
                <textarea style="resize: none; height: 80px;  width: 365px; overflow: hidden; word-wrap: break-word;" class="tagBodyPopup" id="description" name="description" maxlength="255" ></textarea> </br>
            </div>
            <div class="row-form">
                <b>Изображение</b> (типы .jpg, .png, .gif)
                <?php echo CHtml::activeFileField(new Phototag(), 'image', array('id'=>'image','class'=>'tagBodyPopup', 'accept'=>'image/jpg, image/jpeg, image/png, image/gif')); ?>
            </div>
            <div class="row-form">
                <b>Ссылка на продукт</b> (http://example.com/pro)
                <input type="text" class="tagBodyPopup" id="image_link" name="image_link" maxlength="2048" style="width:365px"/> </br>
            </div>
            <div class="row-form">
                <b>Примерная стоимость</b>
                $ <input type="text" class="tagBodyPopup" id="price" name="price" maxlength="6" size="6"/> </br>
            </div>
            <span class="phtError"></span>
            <div style="clear:both"></div>
            <div style="display: block;" class="confirmDialog">
                <input style="cursor: pointer;" id="addTagButtonPopup" type="button" class="rbBtn submitAddTag" value="Отправить">
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
            var button = '<input style=\"cursor: pointer;\" type=\"button\" class=\"rbBtn submitAddTag\" value=\"Отправить\" id=\"addTagButtonPopup\">';
            $('.confirmDialog').html(button);
            $('#photoTag').dialog('option', 'title', 'Добавить ярлык на фото');

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
                       url: '".Yii::app()->baseUrl. '/phototag/add'."',
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
                                   price = 'Примерная стоимость $ <span class=\"imageTagPopupPriceNotLinked\">'+price+'</span>';
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
                                                                        <img class=\"buttonsCommentAction buttonTagEditIcon\" title=\"Редактировать\">\
                                                                    </a>\
                                                                    <a id=\"'+msg.tid+'\" class=\"tagIcon\" >\
                                                                        <img class=\"buttonsCommentAction buttonTagDeleteIcon\" title=\"Удалить\">\
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
                       url: '".Yii::app()->baseUrl. '/phototag/getInfo'."',
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
                                var button = '<input style=\"cursor: pointer;\" type=\"button\" class=\"rbBtn submitAddTag\" value=\"Отправить\" id=\"editTagButtonPopup\">';
                                $('.confirmDialog').html(button);
                                $('.phtError').hide();
                                $('.tagBodyPopup').removeClass( 'ui-state-error' );
                                $('#tagFormPopup').show();
                                $('#photoTag').dialog('option', 'title', 'Редактировать ярлык');
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
                       url: '".Yii::app()->baseUrl. '/phototag/edit'."',
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
                                    p.html('Примерная стоиомость $ <span class=\"imageTagPopupPriceNotLinked\">'+price+'</span>');

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
             if (confirm('Вы уверены, что хотите удалить этот ярлык?')) {
                $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->baseUrl. '/phototag/delete'."',
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

?>
<div class="list-bot izo-list">
    <h1>Просмотр изображения</h1><h2><?php echo $model->name; ?></h2>
    <span>Добавил:&nbsp;<?php echo CHtml::link($model->member->login,array('managemember','id'=>$model->member->id));  ?></span><br/>
<?php echo CHtml::link('Назад к списку',array('mobilepictures/index'));?>
    <?php // echo $model->name; ?><!--<br>-->
    <div class="photo-description">
        <?php if (!empty($model->info)): ?><span>Описание: </span> <?php echo $model->info; ?><?php endif;?>
    </div>
    <div class="images">
        <img class="main" height="580px" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $model->image; echo '?' . time() ?>" alt="<?php echo $model->name;?>"  ondragstart="return false" onselectstart="return false"/><br/>
        <?php if (!empty($photoTags)): ?>
            <?php foreach ($photoTags as $pt): ?>
                <div class="img-tags" id="<?php echo $pt->photoID;?>" style="left: <?php echo $pt->coordX . 'px';?>; top: <?php echo $pt->coordY . 'px';?>;"></div>
                <div id="<?php echo $pt->id;?>" class="imageTagPopup" style="left: <?php echo $pt->coordX . 'px';?>; top: <?php echo $pt->coordY . 'px';?>;">
                    <div id="imageTagBackground" style="width: 300px;"></div>
                    <div class="imageTagPopupContainer" style="position:relative;top:0;left:0;opacity:1;">

                            <div class="imageTagPopupActions">
                                <a id="<?php echo $pt->id; ?>" class="tagIcon" style="margin-left: 130px;">
                                    <img class="buttonsCommentAction buttonTagEditIcon" title="Редактировать">
                                </a>
                                <a id="<?php echo $pt->id; ?>" class="tagIcon" >
                                    <img class="buttonsCommentAction buttonTagDeleteIcon" title="Удалить">
                                </a>
                            </div>

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
                                    Примерная стоимость $<span class="imageTagPopupPriceNotLinked"><?php echo $pt->price;?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif;?>
    </div>
<?php echo $model->date; ?>&nbsp;&nbsp;
<?php if (count($tags)>0):  ?>
    Теги:&nbsp;
    <?php
    echo implode(", ",$tagNameArray);

    ?>
<?php endif; ?>
