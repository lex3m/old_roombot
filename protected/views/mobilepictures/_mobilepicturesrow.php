<?php if ($data->moderation==1)     
            $checkImage='checkepicture.png';
        else 
            $checkImage='uncheckepicture.png';
?>


<div class="info-userfoto">
     <img width="21px" height="18px" src="/images/site/<?php echo $checkImage; ?>" style="float:left; padding-right:5px;">
     <span id="moderat">
         <?php if ($data->moderation==0) 
                    echo 'Фото на модерации';
            else 
                    echo 'Фото прошло модерацию';?>
     </span>
     <span id="site-user">Сайт:</span>
     <span id="name_picture" name="912" class="name_picture_id_912"><?php echo $data->name; ?></span>
     </div>
     <div class="daty"><?php echo $data->date; ?>
</div>

<div id="company_photo" style="margin-bottom:10px;" class="" name="<?php echo $data->id; ?>">
         <a href="/mobilepictures/viewinfo/<?php echo $data->id; ?>" target="_blank"><img width="100px" height="100px" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $data->image; ?>" class="photo-img"></a>
         <a href="/mobilepictures/delete" target="<?php echo $data->id; ?>" id="delete_picture" title="Удалить"><img width="12px" height="12px" src="<?php echo Yii::app()->baseUrl; ?>/images/site/delete_icon.png" style="float:left"></a>
        <?php if (!empty($data->info)):?>
            <div style="margin-left:20px;" class="izo-tegi">
                <span class="tegss">Описание:</span>
                <?php echo $data->info; ?>
            </div>
        <?php endif; ?>
         <div style="margin-left:20px;" class="izo-tegi">
             <span class="tegss">Описание:</span>
         </div>
         <div style="margin-left:20px;" class="izo-tegi">
             <span class="tegss">Теги:</span>
             <div id="tags<?php echo $data->id; ?>" class="tag_box">
                <?php foreach ($data->taglinks as $m) { 
                    $tag=Mobiletags::model()->findByPk($m->tagId);?>
                     <div style="margin-bottom:10px;" id="taglinkk<?php echo $m->id; ?>">
                         <?php echo $tag->name; ?>
                         <a href="/mobilepictures/delete" target="<?php echo $m->id; ?>" id="delete_tag" title="Удалить"><img width="12px" height="12px" src="<?php echo Yii::app()->baseUrl; ?>/images/site/delete_icon.png" style="float:right" id="<?php echo $m->id; ?>" /></a>
                     </div>
                <?php } ?>
             </div>
         </div>
         <div class="izo-tegi2">
              <a href="#" id="<?php echo $data->id; ?>" name="new_tag" class="a-teg">Добавить теги</a>
         </div>
     </div>
     
