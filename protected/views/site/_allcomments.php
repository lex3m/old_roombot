<?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>
<?php foreach ($comments as $comment): ?>
    <div class="oneComment" id="<?php echo $comment->id; ?>">
    <div class="commentInfo tiny-text">
            <span>
                <abbr title="<?php echo $comment->dateTime;?>">
                    <?php echo CHtml::openTag('abbr',array('class'=>'timeago',
                        'title'=>$comment->dateTime,
                    ));?>
                </abbr>
            </span>
            <?php if (!Yii::app()->user->isGuest): ?>
                <span class="likeContainer">&nbsp;&nbsp;&nbsp;
                    <a class="likeIcon"  id="<?php echo $comment->id; ?>" href="#"><img src=""><?php echo $comment->countlikes; ?></a>
                </span>
            <?php endif; ?>
        </div>
            <span class="user">
                <div class="commentThumb">
                    <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" class="userAvatar">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo$comment->member->memberinfo->avatar; ?>">
                    </a>
                </div>
                <div class="comment-actions">
                    <?php if($comment->member->id == Yii::app()->user->id): ?>
                        <a id="<?php echo $comment->id; ?>" class="commentIcon commentDeleteIcon" title="Удалить комментарий">
                            <img class="buttonsCommentAction buttonCommentDeleteIcon" src="">
                        </a>
                        <a id="<?php echo $comment->id; ?>" class="commentIcon commentEditIcon" title="Редактировать комментарий">
                            <img class="buttonsCommentAction buttonCommentEditIcon" src="">
                        </a>
                    <?php endif; ?>
                </div>
                <h4><?php echo CHtml::link($comment->member->login,array('member/dashboard', 'id'=>$comment->member->urlID));?></h4>
                <p><?php echo CHtml::encode($comment->content); ?></p>
            </span>
    </div>
<?php endforeach; ?>