<?php
/* @var $this MemberController */
/* @var $data Member */
?>
<div class="view">
    <div class="userinfo">
    <?php if (Yii::app()->controller->action->id == 'followed'): ?>

        <h3><b><?php echo CHtml::encode($data->getAttributeLabel('User')); ?>:</b>
        <?php echo CHtml::link(CHtml::encode($data->followed->login), array('member/dashboard', 'id'=>$data->followed->urlID)); ?> </h3><br />


        <div id="commentsContainer">
        <b><?php echo CHtml::encode($data->getAttributeLabel('Last comments'));  ?>:</b>
        <?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>
        <?php if (count($data->followed->comments) > 0): ?>
            <?php foreach($data->followed->comments as $comment): ?>
                  <div id="<?php echo $comment->id; ?>" class="commentBodyContent">
                      <div class="commentThumb">
                          <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" class="userAvatar">
                              <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $data->followed->memberinfo->avatar; ?>"></a>
                      </div>
                      <a class="rb-username"  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" data-type="profile"><?php echo $comment->member->login; ?></a> commented <?php echo CHtml::link('photo', array('/mobilepictures/viewinfo/'.$comment->photoID), array('target'=>'blank')) ;?>
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
            <?php endforeach; ?>
        <?php else: ?>
            Нет комментариев
        <?php endif; ?>
        </div>

        <div id="commentsContainer">
            <b><?php echo CHtml::encode($data->getAttributeLabel('Last uploaded photos'));  ?>:</b> <br />
            <?php if (count($data->followed->photos) > 0): ?>
                <?php foreach($data->followed->photos as $photo): ?>
                    <a class="photoImgPreview" target="_blank" href="/mobilepictures/viewinfo/<?php echo $photo->id;?>">
                        <img class="image__full" width="120" height="120" src="/images/mobile/images/<?php echo $photo->image;?>">
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                No photos
            <?php endif; ?>
        </div>
    <?php else: ?>
        <h3>
            <b><?php echo CHtml::encode($data->getAttributeLabel('User')); ?>:</b>
            <?php echo CHtml::link(CHtml::encode($data->following->login), array('member/dashboard', 'id'=>$data->following->urlID)); ?>
            <?php if ($data->memberID == Yii::app()->user->id):?>
                <?php echo CHtml::link('<img width="21px" height="18px" src="/images/site/uncheckepicture.png" style="float:right; padding-right:5px;">', array('member/rmfollower', 'id'=>$data->following->urlID), array('class'=>'rmfollower')); ?>
            <?php endif; ?>
        </h3>
        <br />

        <div id="commentsContainer">
            <b><?php echo CHtml::encode($data->getAttributeLabel('Last comments'));  ?>:</b>
            <?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>
            <?php if (count($data->following->comments) > 0): ?>
                <?php foreach($data->following->comments as $comment): ?>
                    <div id="<?php echo $comment->id; ?>" class="commentBodyContent">
                        <div class="commentThumb">
                            <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" class="userAvatar">
                                <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $data->following->memberinfo->avatar; ?>"></a>
                        </div>
                        <a class="rb-username"  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" data-type="profile"><?php echo $comment->member->login; ?></a> commented <?php echo CHtml::link('photo', array('/mobilepictures/viewinfo/'.$comment->photoID), array('target'=>'blank')) ;?>
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
                <?php endforeach; ?>
            <?php else: ?>
                No comments
            <?php endif; ?>

        </div>
        <div id="commentsContainer">
            <b><?php echo CHtml::encode($data->getAttributeLabel('Last uploaded photos'));  ?>:</b> <br />
            <?php if (count($data->following->photos) > 0): ?>
                <?php foreach($data->following->photos as $photo): ?>
                    <a class="photoImgPreview" target="_blank" href="/mobilepictures/viewinfo/<?php echo $photo->id;?>">
                        <img class="image__full" width="120" height="120" src="/images/mobile/images/<?php echo $photo->image;?>">
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                No photos
            <?php endif; ?>
        </div>
    <?php endif; ?>
    </div>
</div>
