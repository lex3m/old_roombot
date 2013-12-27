<?php if ($data->moderation==1)     
            $checkImage='checkepicture.png';
        else 
            $checkImage='uncheckepicture.png';
?>


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
     <span id="name_picture" name="912" class="name_picture_id_912"><?php echo $data->name; ?></span>
     </div>
     <div class="daty"><?php echo $data->date; ?>
         &nbsp;|&nbsp;
         <?php if ($data->countComments==0) { ?>
         нет комментариев
         <?php } else { ?>
         <a  target="_blank" href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>"><?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $data->countComments);  ?></a>
         <?php } ?>
    </div>

<div id="company_photo" style="margin-bottom:10px;" class="" name="<?php echo $data->id; ?>">
         <a href="/mobilepictures/viewinfo/<?php echo $data->id; ?>" target="_blank">
             <img width="150px" height="150px" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $data->image; ?>" class="photo-img">
         </a>
         
         <?php if (Yii::app()->user->id == $member->id): ?>
            <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" target="<?php echo $data->id; ?>" id="delete_picture" title="Удалить"><img width="12px" height="12px" src="<?php echo Yii::app()->baseUrl; ?>/images/site/delete_icon.png" style="float:left"></a>
         <?php endif; ?>
        <div style="margin-left:20px;" class="izo-tegi">
            <?php if(!empty($data->info)): ?>
                <span class="tegss">Описание:</span>
                <div id="tags" class="tag_box">
                  <?php echo $data->info; ?>
                </div>
            <?php endif; ?>
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
     
