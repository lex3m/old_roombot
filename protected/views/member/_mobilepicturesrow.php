<?php if ($data->moderation==1)     
            $checkImage='checkepicture.png';
        else 
            $checkImage='uncheckepicture.png';
?>

<div class="user-photo" name="<?php echo $data->id; ?>">
    <div class="info-userfoto">
        <?php if (Yii::app()->user->id == $member->id): ?>
             <img width="21px" height="18px" src="/images/site/<?php echo $checkImage; ?>" style="float:left; padding-right:5px;">
             <span id="moderat">
                 <?php if ($data->moderation==0)
                            echo 'Фото на модерации';
                    else
                            echo 'Фото прошло модерацию';?>
             </span>
        <?php endif; ?>
        <span id="site-user">Сайт:</span>
        <span class="name_picture" id="picture-<?php echo $data->id; ?>"><?php echo $data->name; ?></span>
            <?php if (Yii::app()->user->id == $member->id):?>
               <span id="name_picture" data-id="<?php echo $data->id; ?>"><img class="buttonsCommentAction buttonCommentEditIcon" style="padding-top: 0px; margin-top: -5px; cursor:pointer;" src=""></span>
            <?php endif; ?>

    </div>
     <div class="daty"><?php echo $data->date; ?>
         &nbsp;|&nbsp;
         <?php if ($data->countComments==0) { ?>
         нет комментариев
         <?php } else { ?>
         <a  target="_blank" href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>"><?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $data->countComments);  ?></a>
         <?php } ?>
    </div>

    <div id="company_photo" style="margin-bottom:10px;" class="" >
             <?php if (Yii::app()->user->id == $member->id): ?>
                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" target="<?php echo $data->id; ?>" id="rotate_picture" title="Повернуть фото"><img width="15px" height="15px" src="<?php echo Yii::app()->baseUrl; ?>/images/rotate.png" style="float:left; margin-right: 5px;"></a>
             <?php endif ;?>
             <a id="img-<?php echo $data->id; ?>" href="/mobilepictures/viewinfo/<?php echo $data->id; ?>" target="_blank">
                 <?php if (is_file(realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg']."/thumbs/" )."/".$data->image)): ?>
                    <img height="100px" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/thumbs/<?php echo $data->image; echo '?' . time() ?>" class="photo-img">
                 <?php else :?>
                     <img height="100px" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $data->image; echo '?' . time() ?>" class="photo-img">
                 <?php endif; ?>
             </a>

             <?php if (Yii::app()->user->id == $member->id): ?>
                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" target="<?php echo $data->id; ?>" id="delete_picture" title="Удалить"><img width="12px" height="12px" src="<?php echo Yii::app()->baseUrl; ?>/images/site/delete_icon.png" style="float:left"></a>
             <?php endif; ?>
            <div style="margin-left:20px;" class="izo-tegi">
                <span class="tegss">Описание:</span> <span id="picture_info" data-id="<?php echo $data->id; ?>" ><?php if (Yii::app()->user->id == $member->id): ?><img class="buttonsCommentAction buttonCommentEditIcon" style="padding-top: 0px; margin-top: -5px; cursor:pointer;" src=""></span><?php endif;?>
                <div id="info-<?php echo $data->id;?>" class="info_box">
                  <?php echo $data->info; ?>
                </div>
            </div>
             <div style="margin-left:20px;" class="izo-tegi">
                 <span class="tegss">Теги:</span>
                 <div id="tags<?php echo $data->id; ?>" class="tag_box">
                    <?php foreach ($data->taglinks as $m) {
                        $tag=Mobiletags::model()->findByPk($m->tagId);?>
                         <div style="margin-bottom:10px;" id="taglinkk<?php echo $m->id; ?>">
                             <?php echo $tag->name; ?>
                             <?php if (Yii::app()->user->id == $member->id): ?>
                                <a href="/mobilepictures/delete" target="<?php echo $m->id; ?>" id="delete_tag" title="Удалить"><img width="12px" height="12px" src="<?php echo Yii::app()->baseUrl; ?>/images/site/delete_icon.png" style="float:right" id="<?php echo $m->id; ?>" /></a>
                             <?php endif; ?>
                         </div>
                    <?php } ?>
                 </div>
             </div>
             <?php if (Yii::app()->user->id == $member->id): ?>
             <div class="izo-tegi2">
                  <a href="#" id="<?php echo $data->id; ?>" name="new_tag" class="a-teg">Добавить теги</a>
             </div>
             <?php endif; ?>
     </div>
</div>
