<li class="lastPhotos__item">
<div class="lastPhotosElement rb-media rb-border-light-bottom">
    <a class="photoImgPreview rb-media-image" target="_blank" href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>">
        <div class="image  left"  style="height: 120px; width: 120px;">
            <img class="image__full" width="120" height="120" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $data->image; ?>">
        </div>
    </a>
        <div class="rb-media-content">
                <h2 class="photoElement__title">
                    <a target="_blank" href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" class="rb-dark-link" title="Visit timewriter’s profile"><?php echo $data->name; ?></a>
                </h2>
                <a href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$data->memberUrlID)); ?>"><h3 class="photoElement__details rb-type-light"><?php echo $data->memberLogin; ?></h3></a>
                <div class="photoElement__stats">
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="12254 followers" class="rb-ministats-item">
                                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" class="rb-ministats rb-ministats-small rb-ministats-comments">
                                    <span ><?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $data->countComments);  ?> &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                      </a>
                            </li>
                            <li title="23 tracks" class="sc-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span><?php echo Yii::t('app', '{n} книга идей|{n} две книги идей|{n} книг идей|{n} книг идей', $data->countIdeasBooks); ?></span>
                                </span>
                            </li>
                        </ul>

                </div> </div>
        </div>

</div>
</li>