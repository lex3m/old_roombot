<div class="list-bot">
<?php if ($member->id==Yii::app()->user->id): ?><h1 style = "margin-bottom: 0;">Dashboard</h1><?php endif; ?>
<br>
<div class="rightBlockMemeberInfo">
<div class="leftBar">
<div class="memberCabinetPic">
            <a onclick="return false;" href="">  
            <img height="150px" id="mainMemberCabinetPic" src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $member->memberinfo->avatar;?>"/>
        </a>
</div>
    <div id="friendsFollowDiv">
    <?php if (Yii::app()->user->id !== $member->id && !Yii::app()->user->isGuest):?>
         <?php if (!MemberFollowers::checkFollower($member->id)): ?>
            <div class="knopky1 follow" style="display: block;">
                <?php echo CHtml::link('Follow',array('member/addfollower','id'=>$member->urlID), array('id'=>'addfollower')); ?>
            </div>
            <div class="knopky1 unfollow" style="display: none;">
                <?php echo CHtml::link('Unfollow',array('member/rmfollower','id'=>$member->urlID), array('id'=>'rmfollower')); ?>
            </div>
        <?php else: ?>
            <div class="knopky1 follow" style="display: none;">
                <?php echo CHtml::link('Follow',array('member/addfollower','id'=>$member->urlID), array('id'=>'addfollower')); ?>
            </div>
            <div class="knopky1 unfollow" style="display: block;">
                <?php echo CHtml::link('Unfollow',array('member/rmfollower','id'=>$member->urlID), array('id'=>'rmfollower')); ?>
            </div>
         <?php endif; ?>
        <div class="followers">
            <?php if ($member->countFollowing > 0): ?>
                <div class="sidebar">
                    <div class="sidebar-header">Following (<?php echo $member->countFollowing;?>)</div>
                    <div class="sidebar-body">
                        <ul id="followingsBox">
                            <li class="profileThumbBox">
                                <?php $i = 0;
                                 foreach($following as $f): ?>
                                    <div class="thumbFollowUserDiv">
                                        <?php echo CHtml::link(CHtml::image('/images/members/avatars/'.$f->following->memberinfo->avatar, 'title'.$f->following->login, array('title'=>$f->following->login)), array('member/dashboard','id'=>$f->following->urlID)); ?>
                                    </div>
                                <?php $i++; if ($i == 5) break;
                                 endforeach;?>
                                <?php if ($member->countFollowing > 5): ?>
                                    <?php echo CHtml::link( 'Show all '.$member->countFollowing, array('member/following', 'id'=>$f->followed->urlID), array('class'=>'view-all') ); ?>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($member->countFollowed > 0): ?>
                <div class="sidebar">
                    <div class="sidebar-header">Followed by (<?php echo $member->countFollowed;?>)</div>
                    <div class="sidebar-body">
                        <ul id="followingsBox">
                            <li class="profileThumbBox">
                                <?php $i = 0;
                                foreach($followed as $f): ?>
                                    <div class="thumbFollowUserDiv">
                                        <?php echo CHtml::link(CHtml::image('/images/members/avatars/'.$f->followed->memberinfo->avatar, 'title'.$f->followed->login, array('title'=>$f->followed->login)), array('member/dashboard','id'=>$f->followed->urlID)); ?>
                                    </div>
                                    <?php $i++; if ($i == 5) break;
                                endforeach;?>
                                <?php if ($member->countFollowed > 5): ?>
                                    <?php echo CHtml::link( 'Show all '.$member->countFollowed, array('member/followed', 'id'=>$f->followed->urlID), array('class'=>'view-all') ); ?>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif (!Yii::app()->user->isGuest) : ?>
            <div class="knopky1" style="display: block;">
                <?php echo CHtml::link('Following',array('member/following'), array('id'=>'followers')); ?>

            </div>
            <div class="knopky1" style="display: block;">
                <?php echo CHtml::link('Followed',array('member/followed'), array('id'=>'followers')); ?>
            </div>

        <?php if (isset($userFriends) && !empty($userFriends)): ?>
            <div class="userFriends">
                <div class="sidebar">
                    <div class="sidebar-header">Friends from VK (<?php echo count($userFriends);?>)</div>
                    <div class="sidebar-body">
                        <ul id="followingsBox">
                            <li class="profileThumbBox">
                                <?php foreach($userFriends as $friend): ?>
                                    <div class="thumbFollowUserDiv">
                                        <?php echo CHtml::link(CHtml::image($friend['photo'], $friend['photo'], array('title'=>$friend['name'])), array('member/dashboard','id'=>$friend['urlID'])); ?>
                                    </div>
                                <?php endforeach;?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    </div>

</div>
    <div id="memberCommonInfo">
    <h2><?php echo $member->login; ?></h2>
       <div class="memberCountComments">
           Photos: <?php echo $member->countPhotos; ?>
           &nbsp;|&nbsp;
           Comments: <?php echo $member->countComments; ?>
       </div>
    </div>
    <div style="margin-bottom: 0px"></div>
    <div id="memberDescriptionInfo" class="kabinet-colonka-right">
        <?php if ($member->memberinfo->showEmail==1): ?>
            <span class="zagolowok-info">Email:</span>
            <?php echo $member->email; ?>
            <br>
        <?php endif; ?>
        <?php if (!empty($member->memberinfo->fio)): ?>
            <span class="zagolowok-info">Full name:</span>
            <?php echo $member->memberinfo->fio; ?>
            <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->website!=""): ?>
            <span class="zagolowok-info">Site:</span>
            <?php echo $member->memberinfo->website; ?>
            <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->phone!=""): ?>
            <span class="zagolowok-info">Phone number:</span>
            <?php echo $member->memberinfo->phone; ?>
            <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->about!=""): ?>
            <div id="memberAbout">
                <span class="zagolowok-info">About:</span>
                <?php echo $member->memberinfo->about; ?>
            </div>
            <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->cityIsSet==1): ?>
            <span class="zagolowok-info">City:</span>
                <?php echo $memberCity->city->cityName; ?>, &nbsp<?php echo Countries::model()->findbyPk($memberCity->city->countryID)->countryName; ?>
                <br>
        <?php endif; ?>

		<div class="knopky3">
           <?php echo CHtml::link('Ideabooks',array('ideasbook/index','id'=>$member->urlID)); ?>
        <?php if (Yii::app()->user->id == $member->id): ?>
            
            <?php echo CHtml::link('Change account',array('member/change')); ?>
            
            <?php echo CHtml::link('Change avatar',array('member/avatar')); ?>
		</div>
        <div class="knopky1">
            <?php echo CHtml::link('Change social accounts',array('member/social')); ?>
        </div>
        <?php endif; ?>
    </div>
</div>

 <div class="span-17 last">
        <div class="form width-form">
            <?php
            $flashMessages = Yii::app()->user->getFlashes();
            if ($flashMessages) {
                echo '<ul class="flashes">';
                foreach($flashMessages as $key => $message) {
                    echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
                }
                echo '</ul>';
            }
            ?>

            <?php if (Yii::app()->user->id == $member->id): ?>

                    <?php if (isset($userPhotos) && !empty($userPhotos)): ?>
                        <div class="showVkPhotos">
                            <div class="knopky1">
                                <a href="#">Show photos from VKontakte</a>
                            </div>
                        </div>
                        <div class='vkUserPhotos' style="display:none;">
                            You can add your photos from your Vkontakte account (please refresh page after adding photos)<br/>
                            <?php foreach($userPhotos as $photo):?>
                                <?php echo CHtml::image($photo['src'], $photo['photo_id'], array('height'=>100, 'width'=>100)); ?>
                                <?php echo CHtml::link('<img height="20" width="20" src="/images/fav.jpg">', '#', array('data-id'=>$photo['photo_id'],'class'=>'add_to_photos', 'data-src'=>$photo['src_big'])); ?>
                            <?php endforeach; ?>
                            <br/>
                            <?php echo CHtml::button('Refresh',array('id'=>'refresh_page', 'style'=>'display:none;', 'onClick'=>'window.location.reload()')); ?>
                        </div>
                    <?php endif; ?>

                <br>
                <!-- Put this script tag to the <head> of your page -->
                <script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>

                <script type="text/javascript">
                    VK.init({apiId: 4111118, onlyWidgets: true});
                </script>

                <!-- Put this div tag to the place, where the Poll block will be -->
                <div id="vk_poll"></div>
                <script type="text/javascript">
                    VK.Widgets.Poll("vk_poll", {width: "500"}, "119467387_ad82d127491b1f09bc");
                </script>
                <br>
            <?php endif; ?>
<?php if (Yii::app()->user->id == $member->id): ?>
<div class="block-a">
    <div class="width-form1">
    <?php
     $form=$this->beginWidget('CActiveForm', array(
        'id'=>'mobilepictures-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
    )); ?>


    <div class="row width-form">
            <?php /*echo $form->labelEx($model,'name'); */?><!--
            <p style="margin:0px;font-size:11px">*Ссылка на ваш сайти или блог(без http://)</p>
            <?php /*echo $form->textField($model,'name',array('size'=>34,'maxlength'=>50)); */?>
            --><?php /*echo $form->error($model,'name'); */?>

            <?php /*echo $form->labelEx($model,'info'); */?><!--
            <p style="margin:0px;font-size:11px">Краткое описание для фотографии</p>
            <?php /*echo $form->textArea($model,'info',array('cols'=>27,'rows'=>3)); */?>
            --><?php /*echo $form->error($model,'info'); */?>
        <?php
            echo $form->labelEx($model, 'images');
        ?>
        <p style="margin:0px;font-size:11px">*Photos with size less 10 Mb and 20 photos per one uploading</p>
        <?php
        $this->widget( 'ext.xupload.XUpload', array(
                'url' => Yii::app( )->createUrl( "member/uploadUserPhotos"),
                //our XUploadForm
                'model' => $photos,
                //We set this for the widget to be able to target our own form
                'htmlOptions' => array('id'=>'mobilepictures-form'),
                'attribute' => 'file',
                'multiple' => true,
                'accept' => 'image/jpg, image/jpeg, image/png, image/gif',
                'options' => array(
                    'stop'=>'js:function(event, files, index, xhr, handler, callBack) {
                         var seconds = 1; //wait 1 seconds after uploading
                         var interval = setInterval( function() {
                            seconds = seconds - 1;
                            $(".upload-timer").html("Ожидайте " + seconds + " сек для завершения загрузки");
                            if (seconds == 0) {
                                clearInterval(interval);
                            }
                         },  1000);

                         setTimeout( function(){ location.reload() }, 1000 );

                         $(window).scrollTop(0);
                    }',
                ),
            )
        );

        ?>
<!--        <div class="row buttons">-->
<!--            --><?php //echo CHtml::submitButton('Добавить изображения'); ?>
<!--        </div>-->
    </div>

    <!--        --><?php //echo $form->fileField($model,'img',array("class"=>"vvv")); ?>
    <!--        --><?php //echo $form->error($model,'img'); ?>
    <!-- <input multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/bmp, image/gif" id="Mobilepictures_images" type="file" value="" name="Mobilepictures[images][]" class="MultiFile-applied">-->


    <?php $this->endWidget(); ?>
    </div>
</div>
<div class="block-a">
    <div id="poisk">
        <form id="poisk11" action=" " name="poiskroomb" method="post">
            <div class="poisks">
                <span class="nazwa1">Search</span><br />
                <input id="infowvod" type="text" size="30" maxlength="50" name="wvod">
            </div>
            <div class="buttons2">
                <?php echo CHtml::submitButton('Search', array('id' => 'poiskknopka', 'name' => 'button'));  ?>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<div class="span-17 last">
    <div class="items list3">
        <?php
         $this->widget('zii.widgets.CListView', array(
         'viewData' => array( 'member' => $member),
         'dataProvider'=>$dataProvider,
         'itemView'=>'_mobilepicturesrow',
         'ajaxUpdate'=>false,
         'summaryText' => 'Photos {start}-{end} from {count}.',));
        ?>
    </div>
</div>

</div>
</div>
</div> 
</div>
<?php
if (Yii::app()->user->id == $member->id): 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'add_tag',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'autoOpen'=>false,
            'resizable'=>false,
            'closeOnEscape'=> 'true',
            'width'=>'400',
            'height'=>'470',
            'show'=>'show',
        ),

    )); 
    echo '<div class="photo_tags">';
    echo '</div>';
//    echo CHtml::dropDownList('tags_array','',CHtml::listData(Mobiletags::model()->findAll(), 'id', 'name_en'));
    echo '<br>';
    echo '<br>';
    echo CHtml::button('Save', array('id'=>'confirm_tag_option','name'));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'change_name_picture',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'autoOpen'=>false,
            'closeOnEscape'=> 'true',
            'width'=>'400',
            'show'=>'show',
            'resizable' => 'false'
        ), 
    )); 
    
    echo CHtml::textField('Text', '',
     array('id'=>'name_picture_textField', 
           'width'=>100,
           'maxlength'=>100));
    echo '<br><br>';
    echo CHtml::button('Yes', array('id'=>'confirm_name_picture','name'));
    $this->endWidget('zii.widgets.jui.CJuiDialog');


    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'change_picture_info',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'autoOpen'=>false,
            'closeOnEscape'=> 'true',
            'width'=>'400',
            'show'=>'show',
            'resizable' => 'false'
        ),
    ));

    echo CHtml::textArea('Text', '',
        array('id'=>'picture_info_textArea',
            'cols'=>50,
            'rows'=>5,
            'maxlength'=>255
            ));
    echo '<br><br>';
    echo CHtml::button('Yes', array('id'=>'confirm_picture_info','name'));
    $this->endWidget('zii.widgets.jui.CJuiDialog');

    Yii::app()->clientScript->registerScript('mobilePicturesScript',"

        $('.showVkPhotos').on('click', function (e) {
            e.preventDefault();
            $('.vkUserPhotos').toggle(300);
        });

        $( 'a.add_to_photos').on('click', function(event){
            event.preventDefault();
            var that = $(this);
            var id = that.attr('data-id');
            var src = that.attr('data-src');

            //Prevent more than 1 adding photos
            that.removeClass('add_to_photos');
            that.attr('data-id', null);
            that.attr('data-src', null);

            var img = '".CHtml::image('/images/site/checkepicture.png','',array('width'=>21,'height'=>18))."';
            if (id > 0 && src != '') {
                $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/addpicture')."',
                       data: {id: id, src: src},
                       success: function(msg){
                         if (msg) {
                            that.html(img);
                            $('#refresh_page').show();
                         }
                       }
                });
            }
            return false;

        });

        
        $( 'span#name_picture').on('click', function(event){
            var id = $(this).attr('data-id');
            var name = $.trim($('#picture-'+id).html());
             $('#change_name_picture').dialog('option','title', 'Change name');
                    $('#change_name_picture').dialog('open');
                    $( 'input#confirm_name_picture').attr('name',id);
                    $( 'input#name_picture_textField').val(name);
        });

        $('#change_name_picture').keypress(function(e) {
              if (e.keyCode == 13) {
                  $(this).find('#confirm_name_picture').trigger('click');
              }
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
                              $('#picture-'+json.id).text(json.name);
                              $('input[id=\'name_picture_textField\']').val('');  
                           }
                         });
                    return false;
            });

            $( 'span#picture_info').on('click', function(event){
                var id = $(this).attr('data-id');
                var name = $.trim($('#info-'+id).html());
                 $('#change_picture_info').dialog('option','title', 'Change description (max 255 symbols)');
                        $('#change_picture_info').dialog('open');
                        $( 'input#confirm_picture_info').attr('name',id);
                        $( 'textarea#picture_info_textArea').val(name);
            });

            $( 'input#confirm_picture_info').on('click', function(event){
                pictureinfo = $('textarea[id=\'picture_info_textArea\']').val();
                pictureid = $(this).attr('name');
                    $.ajax({
                           type: 'POST',
                           url: '".Yii::app()->createUrl('mobilepictures/editpictureinfo')."',
                           data: {id: pictureid, info: pictureinfo},
                           success: function(msg){

                              $('#change_picture_info').dialog('close');
                              json = jQuery.parseJSON(msg);
                              $('#info-'+json.id).html(json.info);
                              $('input[id=\'picture_info_textArea\']').html('');
                           }
                         });
                    return false;
            });

            $( 'a#rotate_picture').on('click', function(event){
                    var id = $(this).attr('target');

                    $.ajax({
                           type: 'POST',
                           url: '".Yii::app()->createUrl('mobilepictures/rotate')."',
                           data: 'id='+id,
                           success: function(msg){
                             var obj = $.parseJSON(msg);
                             $('#img-'+obj.id).html(obj.image);
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
                    $('#add_tag').dialog('close');
                    id = $(this).attr('id');
                    $('#add_tag').dialog('option','title', 'Add tags');
                    $('#add_tag').dialog('open');
                    $('input#confirm_tag_option').attr('name',id);
                    $.ajax({
                       type: 'POST',
                       dataType: 'html',
                       url: '".Yii::app()->createUrl('mobilepictures/getTags')."',
                       data: {id: id},
                       success: function(msg){
                          $('.photo_tags').html(msg);
                       }
                     });
                    return false;
            });
            $( '#confirm_tag_option').on('click', function(event){
                //select = $('select[name=\'tags_array\']').val();

                var values = new Array();
                $.each( $('input[name=\'tags[]\']:checked'), function() {
                    values.push($(this).val());
                });

                $.ajax({
                       type: 'POST',
                       url: '".Yii::app()->createUrl('mobilepictures/addtag')."',
                       data: {id: id, select: values},
                       success: function(msg){
                          $('#add_tag').dialog('close');
                          json = jQuery.parseJSON(msg);
                          $('div#tags'+id).html('');
                          $.each (json, function(i) {
                            $('div#tags'+json[i].pictureid).append('<div id=\'taglinkk'+json[i].taglinkid+'\' style=\'margin-bottom:10px;\'>'+json[i].tagname+'<a id=\'delete_tag\' target=\'20\' href=\'/mobilepictures/delete\'><img id=\''+json[i].taglinkid+'\' style=\'float:right\' width=\'12px\' height=\'12px\' src=\'".Yii::app()->baseUrl."/images/site/delete_icon.png\'></a></div>');
                          })
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
            
        $('#poiskknopka').click(function(){
                          if ($('#infowvod').val() != '')
                            window.location = '".Yii::app()->baseUrl."/mobilepictures/search/query/'+$('#infowvod').val();
                          else {
                              alert('Put in this field your search request.');
                          }     
                    return false;});


        ",CClientScript::POS_READY);
else:
    Yii::app()->clientScript->registerScript('mobilePicturesScript',"

     $( '#addfollower').on('click', function(event){
           event.preventDefault();
           var followerUrl = $(this).attr('href');
           var splitUrl = followerUrl.split('/');
           var len = splitUrl.length;
           var urlID = splitUrl[len-1]; //fix
                $.ajax({
                       type: 'POST',
                       url: followerUrl,
                       data: {urlID: urlID},
                       success: function(msg){
                            if (msg == 1){
                                $('.follow').hide();
                                $('.unfollow').show();
                            }
                       }
                     });
            return false;
     });

     $( '#rmfollower').on('click', function(event){
           event.preventDefault();
           var followerUrl = $(this).attr('href');
           var splitUrl = followerUrl.split('/');
           var len = splitUrl.length;
           var urlID = splitUrl[len-1]; //fix
                $.ajax({
                       type: 'POST',
                       url: followerUrl,
                       data: {urlID: urlID},
                       success: function(msg){
                            if (msg == 1){
                                $('.unfollow').hide();
                                $('.follow').show();
                            }
                       }
                     });
            return false;
     });
            ", CClientScript::POS_READY);
endif;
?>
