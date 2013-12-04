<?php
/* @var $this MemberController */
/* @var $data Member */
?>
<div class="view">
    <div class="userinfo">
    <?php if (Yii::app()->controller->action->id == 'myfollowers'): ?>

        <h3><b><?php echo CHtml::encode($data->getAttributeLabel('Пользователь')); ?>:</b>
        <?php echo CHtml::link(CHtml::encode($data->followed->login), array('member/dashboard', 'id'=>$data->followed->urlID)); ?> </h3><br />


        <div id="commentsContainer">
        <b><?php echo CHtml::encode($data->getAttributeLabel('Последние комментарии'));  ?>:</b>
        <?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>
        <?php if (count($data->followed->comments) > 0): ?>
            <?php $i = 0;
                  foreach($data->followed->comments as $comment) {
            ?>
                      <div id="<?php echo $comment->id; ?>" class="commentBodyContent">
                          <div class="commentThumb">
                              <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" class="userAvatar">
                                  <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $data->followed->memberinfo->avatar; ?>"></a>
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
                          </div>
                      </div>
            <?php
                $i++;
                if ($i == 5) break;
            } ?>
        <?php else: ?>
            Нет комментариев
        <?php endif; ?>
        </div>

        <div id="commentsContainer">
            <b><?php echo CHtml::encode($data->getAttributeLabel('Последние загруженные фотографии'));  ?>:</b> <br />
            <?php $i = 0;
                foreach($data->followed->photos as $photo):
            ?>
                    <a class="photoImgPreview" target="_blank" href="/mobilepictures/viewinfo/<?php echo $photo->id;?>">
                        <img class="image__full" width="120" height="120" src="/images/mobile/images/<?php echo $photo->image;?>">
                    </a>
            <?php
                    $i++;
                    if ($i == 5) break;
            endforeach; ?>
        </div>
    <?php else: ?>
        <h3><b><?php echo CHtml::encode($data->getAttributeLabel('Пользователь')); ?>:</b>
            <?php echo CHtml::link(CHtml::encode($data->following->login), array('member/dashboard', 'id'=>$data->following->urlID)); ?> </h3><br />


        <div id="commentsContainer">
            <b><?php echo CHtml::encode($data->getAttributeLabel('Последние комментарии'));  ?>:</b>
            <?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>
            <?php if (count($data->following->comments) > 0): ?>
                <?php $i = 0;
                foreach($data->following->comments as $comment) {
                    ?>
                    <div id="<?php echo $comment->id; ?>" class="commentBodyContent">
                        <div class="commentThumb">
                            <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" class="userAvatar">
                                <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $data->following->memberinfo->avatar; ?>"></a>
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
                        </div>
                    </div>
                    <?php
                    $i++;
                    if ($i == 5) break;
                } ?>
            <?php else: ?>
                Нет комментариев
            <?php endif; ?>

        </div>
        <div id="commentsContainer">
            <b><?php echo CHtml::encode($data->getAttributeLabel('Последние загруженные фотографии'));  ?>:</b> <br />
            <?php $i = 0;
            foreach($data->following->photos as $photo):
                ?>
                <a class="photoImgPreview" target="_blank" href="/mobilepictures/viewinfo/<?php echo $photo->id;?>">
                    <img class="image__full" width="120" height="120" src="/images/mobile/images/<?php echo $photo->image;?>">
                </a>
                <?php
                $i++;
                if ($i == 5) break;
            endforeach; ?>
        </div>
    <?php endif; ?>
    </div>
</div>
