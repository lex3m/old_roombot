<?php
/* @var $this MemberController */
/* @var $data Member */
?>

<div>
    <div class="followerDiv">
        <?php if (Yii::app()->controller->action->id == 'followed'): ?>
            <div class="followerImageDiv">
                <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$data->followed->urlID)); ?>">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $data->followed->memberinfo->avatar; ?>">
                </a>
            </div>
            <div class="followerContentDiv">
                <div class="followerTextDiv">
                    <?php echo CHtml::link(CHtml::encode($data->followed->login), array('member/dashboard', 'id'=>$data->followed->urlID)); ?>
                </div>
            </div>
        <?php else:?>
            <div class="followerImageDiv">
                <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$data->following->urlID)); ?>">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $data->following->memberinfo->avatar; ?>">
                </a>
            </div>
            <div class="followerContentDiv">
                <div class="followerTextDiv">
                    <?php echo CHtml::link(CHtml::encode($data->following->login), array('member/dashboard', 'id'=>$data->following->urlID)); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
