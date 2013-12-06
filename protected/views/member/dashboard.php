<div class="list-bot">
<?php if ($member->id==Yii::app()->user->id): ?><h1 style = "margin-bottom: 0;">Мой кабинет</h1><?php endif; ?>
<br>
<!--<div class="leftBar">
<div class="memberCabinetPic">
            <a onclick="return false;" href="">  
            <img id="mainMemberCabinetPic" src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $member->memberinfo->avatar;?>"/>
        </a>
</div>
<!--<div id="friendsFollowDiv">  
    <a class="specialBtn whiteBtn Btnfollow" href="" onclick="" onmouseover="" onmouseout="" title="Follow" id="">
        <span id="" class="label">Follow</span>
        <span id="followButton_coffeewithanarchitect_icon__" class="whitebuttonIcon  buttonIconAddToIdeabook">
        
        </span>
    </a>                  
    <input id="followOp_coffeewithanarchitect" type="hidden" value="f">
</div>-->
<!--</div>-->
<div class="rightBlockMemeberInfo">

<div class="leftBar">
<div class="memberCabinetPic">
            <a onclick="return false;" href="">  
            <img id="mainMemberCabinetPic" src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $member->memberinfo->avatar;?>"/>
        </a>
</div>
    <div id="friendsFollowDiv">
    <?php if (Yii::app()->user->id !== $member->id && !Yii::app()->user->isGuest):?>
         <?php if (!MemberFollowers::checkFollower($member->id)): ?>
            <div class="knopky1 follow" style="display: block;">
                <?php echo CHtml::link('Подписаться',array('member/addfollower','id'=>$member->urlID), array('id'=>'addfollower')); ?>
            </div>
            <div class="knopky1 unfollow" style="display: none;">
                <?php echo CHtml::link('Отписаться',array('member/rmfollower','id'=>$member->urlID), array('id'=>'rmfollower')); ?>
            </div>
        <?php else: ?>
            <div class="knopky1 follow" style="display: none;">
                <?php echo CHtml::link('Подписаться',array('member/addfollower','id'=>$member->urlID), array('id'=>'addfollower')); ?>
            </div>
            <div class="knopky1 unfollow" style="display: block;">
                <?php echo CHtml::link('Отписаться',array('member/rmfollower','id'=>$member->urlID), array('id'=>'rmfollower')); ?>
            </div>
         <?php endif; ?>
        <div class="followers">
            <?php if ($member->countFollowing > 0): ?>
                <div class="sidebar">
                    <div class="sidebar-header">Подписки (<?php echo $member->countFollowing;?>)</div>
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
                                    <?php echo CHtml::link( 'Просмотреть всех '.$member->countFollowing, array('member/following', 'id'=>$f->followed->urlID), array('class'=>'view-all') ); ?>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($member->countFollowed > 0): ?>
                <div class="sidebar">
                    <div class="sidebar-header">Подписчики (<?php echo $member->countFollowed;?>)</div>
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
                                    <?php echo CHtml::link( 'Просмотреть всех '.$member->countFollowed, array('member/followed', 'id'=>$f->followed->urlID), array('class'=>'view-all') ); ?>

                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif (!Yii::app()->user->isGuest) : ?>
            <div class="knopky1" style="display: block;">
                <?php echo CHtml::link('Мои подписки',array('member/following'), array('id'=>'followers')); ?>

            </div>
            <div class="knopky1" style="display: block;">
                <?php echo CHtml::link('Мои подписчики',array('member/followed'), array('id'=>'followers')); ?>
            </div>
    <?php endif; ?>
    </div>
</div>


    <div id="memberCommonInfo">
    <h2><?php echo $member->login; ?></h2>
       <div class="memberCountComments">
           Фотографии: <?php echo $member->countPhotos; ?>
           &nbsp;|&nbsp;
           Комментарии: <?php echo $member->countComments; ?>
       </div>
    </div>
    <div style="margin-bottom: 0px"></div>
    <div id="memberDescriptionInfo" class="kabinet-colonka-right">
        <?php if ($member->memberinfo->cityIsSet==1): ?>
            <span class="zagolowok-info">Город:</span>
                <?php echo $memberCity->city->cityName; ?>, &nbsp<?php echo Countries::model()->findbyPk($memberCity->city->countryID)->countryName; ?>
                <br>
        <?php endif; ?>
        
        <?php if ($member->memberinfo->showEmail==1): ?>
            <span class="zagolowok-info">Email:</span>
                <?php echo $member->email; ?>
                <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->website!=""): ?>
            <span class="zagolowok-info">Сайт:</span>
               <?php echo $member->memberinfo->website; ?>
               <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->phone!=""): ?>
            <span class="zagolowok-info">Телефон:</span>
               <?php echo $member->memberinfo->phone; ?>
               <br>
        <?php endif; ?> 
        <?php if ($member->memberinfo->about!=""): ?>
            <div id="memberAbout">
                <span class="zagolowok-info">Краткая информация:</span>
               <?php echo $member->memberinfo->about; ?>
            </div>  
            <br>
        <?php endif; ?>
		<div class="knopky3">
           <?php echo CHtml::link('Книги идей',array('ideasbook/index','id'=>$member->urlID)); ?>
        <?php if (Yii::app()->user->id == $member->id): ?>
            
            <?php echo CHtml::link('Изменить профайл',array('member/change')); ?>
            
            <?php echo CHtml::link('Сменить аватар',array('member/avatar')); ?>
		</div>
        <?php endif; ?>
    </div>
</div>


 <div class="span-17 last">
        <div class="form width-form">
            <br>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div style="font-weight:bold; color: red" class="flash-' . $key . '">' . $message . "</div>\n";
    }
?> 


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
        <?php echo $form->labelEx($model,'name'); ?>
        <p style="margin:0px;font-size:11px">*Ссылка на ваш сайти или блог(без http://)</p>
        <?php echo $form->textField($model,'name',array('size'=>34,'maxlength'=>50)); ?> 
        <?php echo $form->error($model,'name'); ?>
</div> 

        <?php echo $form->fileField($model,'img',array("class"=>"vvv")); ?>
        <?php echo $form->error($model,'img'); ?>

 <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить изображение'); ?> 
    </div>

<?php $this->endWidget(); ?>
</div>
<div id="poisk">
     <form id="poisk11" action=" " name="poiskroomb" method="post">
     
     
         <div class="poisks">
             <span class="nazwa1">Поиск</span><br />         
             <input id="infowvod" type="text" size="30" maxlength="50" name="wvod">
         </div>
         <div class="buttons2">
             <?php echo CHtml::submitButton('Найти', array('id' => 'poiskknopka', 'name' => 'button'));  ?>
            
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
         'summaryText' => 'Фотографии {start}-{end} из {count}.',));
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
                              $('div#tags'+json.pictureid).append('<div id=\'taglinkk'+json.taglinkid+'\' style=\'margin-bottom:10px;\'>'+json.tagname+'<a id=\'delete_tag\' target=\'20\' href=\'/mobilepictures/delete\'><img id=\''+json.taglinkid+'\' style=\'float:right\' width=\'12px\' height=\'12px\' src=\'".Yii::app()->baseUrl."/images/site/delete_icon.png\'></a></div>'); 
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
                              alert('Введите в это поле, что вы хотите найти.');
                          }     
                    return false;});


        ",CClientScript::POS_READY);
else:
    Yii::app()->clientScript->registerScript('mobilePicturesScript',"
     $( '#addfollower').on('click', function(event){
           event.preventDefault();
           var followerUrl = $(this).attr('href');
           var urlID = followerUrl.split('/')[3];
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
           var urlID = followerUrl.split('/')[3];
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
