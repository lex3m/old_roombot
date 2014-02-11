<div class="list-bot izo-list">
<h1><?php echo $ideasBook->name; ?></h1>
<div id="ideasBookDesc"><?php echo $ideasBook->description; ?></div>
    <?php if($ideasBook->member->id != Yii::app()->user->id): ?>
        <div id="ideasBookOwnerSignature">
            <div class="ideasPhotoOwnerThumb">
            <a href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$ideasBook->member->urlID))?>" class="userAvatar">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $ideasBook->memberinfo->avatar; ?>">
            </a>
           </div>
            from user
            <a href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$ideasBook->member->urlID))?>">
                <?php echo $ideasBook->member->login;  ?>
            </a>
        </div>
    <?php endif; ?>
<div id="mainIdeasPhotos">
    <?php foreach ($ideasPhotos as $ideasPhoto):?>
            <div id="<?php echo $ideasPhoto->id; ?>" class="ideaPhotosInBookBlock" style="padding: 0px 20px 30px 20px; float: left; overflow: hidden;
                display: block;">
                <a data-lightbox="ideabook" href="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $ideasPhoto->photozz->image;?>" class="ideaPhotosInBookLink">
                    <img style="width: 190px; height:190px; " src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $ideasPhoto->photozz->image;?>"/>
                </a>
                <div class="ideasPhotosPanel">
                    <div class="ideasPhotosActions">
                        <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$ideasPhoto->photozz->id)); ?>">View photo</a>
                        <?php if($ideasBook->member->id == Yii::app()->user->id): ?>
                            <a id="<?php echo $ideasPhoto->id; ?>" class="ideasPhotosIcon  ideasPhotosDeleteIcon" title="Delete">
                                    <img class="buttonsIdeasPhotosAction buttonIdeasPhotosDeleteIcon" src="">
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="ideasPhotosDesc">
                        <span class="ideasPhotosDescTitle"><?php echo $ideasPhoto->photozz->name; ?></span>
                        <?php $photoOwnerMember = Member::model()->findbyPk($ideasPhoto->photozz->companyID); ?>
                        <div class="ideasPhotoOwner">from user
                            <div class="ideasPhotoOwnerThumb">
                                <a href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$photoOwnerMember->urlID))?>" class="userAvatar">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $photoOwnerMember->memberinfo->avatar; ?>"></a>
                            </div>
                            <a href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$photoOwnerMember->urlID))?>">
                                <?php echo $photoOwnerMember->login;  ?>
                           </a>
                        </div>
                        <?php $comments= Comments::model()->count('photoID=:photoID',array(':photoID'=>$ideasPhoto->photozz->id));  ?>
                        <div class="ideasPhotosDescTitlePhotoCount"><?php echo Yii::t('app', '{n} comment|{n} comments', $comments);?></div>
                    </div>
                </div>
            </div>
    <?php
    endforeach;
    ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'delete_ideasPhotos',
'options'=>array(
'autoOpen'=>false,
'closeOnEscape'=> 'true',
'width'=>'400',
'show'=>'show',
'title'=>'Deleting photo from ideabook',
),
));
?>
    <p>Are you sure to want delete this photo from ideabook?</p>
<input id="" type="button" class="rbBtn okDeleteideasPhotos" value="ОK">
<input id="" type="button" class="rbBtn cancelDeleteideasPhotos" value="Cancel">
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');

Yii::app()->clientScript->registerScript('aaa',"
    var idOfCurrentPhoto;
    $('.ideasPhotosDeleteIcon').live('click',function(event){
             idOfCurrentPhoto = this.id;
             $('#delete_ideasPhotos').dialog('open');
             return false;
         });

         $('.cancelDeleteIdeasPhotos').live('click',function(event){
             $('#delete_ideasPhotos').dialog('close');
             return false;
         });
    $('.okDeleteideasPhotos').live('click',function(event){
                 $.ajax({
                           type: 'POST',
                           url: '".Yii::app()->createUrl('ideasphotos/delete')."',
                           data: {id: idOfCurrentPhoto},
                           success: function(msg){
                                var data = jQuery.parseJSON(msg);
                                if (data.id!=''){
                                    $('.ideaPhotosInBookBlock#'+data.id).remove();
                                    $('#delete_ideasPhotos').dialog('close');
                                }
                           }
                    });
             return false;
         });

",CClientScript::POS_READY);

?>
