<li class="lastPhotos__item" id="<?php echo $data->id;?>">
    <div class="lastPhotosElement rb-media rb-border-light-bottom">

        <a class="photoImgPreview rb-media-image" onClick="showModule();" href="#" data-lightbox="last-photos" title="<?php echo $data->name; ?>">
            <?php if (is_file(realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg']."/thumbs/" )."/".$data->image)):?>
                <img id="<?php echo $data->id;?>" class="image__full"  width="120" height="120" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/thumbs/<?php echo $data->image; ?>">
            <?php else: ?>
                <img id="<?php echo $data->id;?>" class="image__full"  width="120" height="120" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $data->image; ?>">
            <?php endif;?>

        </a>

        <div class="rb-media-content">
                <h2 class="photoElement__title">
                    <a  href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" class="rb-dark-link" title="Visit timewriter’s profile"><?php echo $data->name; ?></a>
                </h2>
                <a href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$data->memberUrlID)); ?>"><h3 class="photoElement__details rb-type-light"><?php echo $data->memberLogin; ?></h3></a>
                <div class="photoElement__stats">
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="<?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $data->countComments); ?>" class="rb-ministats-item">
                                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" class="rb-ministats rb-ministats-small rb-ministats-comments">
                                    <span class="small_comments_i small_i"></span>
                                    <span ><?php echo $data->countComments;  ?> &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                      </a>
                            </li>
                            <li title="<?php echo Yii::t('app', '{n} книга идей|{n} две книги идей|{n} книг идей|{n} книг идей', $data->countIdeasBooks); ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_albums_i small_i"></span>
                                    <span><?php echo $data->countIdeasBooks; ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </span>
                            </li>
                            <li title="<?php echo $data->countLikes; ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_likes_i small_i"></span>
                                    <span><?php echo $data->countLikes; ?></span>
                                </span>
                            </li>
                        </ul>

                    </div>
                </div>
        </div>
</div>
</li>








