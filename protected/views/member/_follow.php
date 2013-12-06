<?php
/* @var $this MemberController */
/* @var $data Member */
?>
<div class="view">
    <div class="userinfo">
        <h3><b><?php echo CHtml::encode($data->getAttributeLabel('Пользователь')); ?>:</b>
        <?php if (Yii::app()->controller->action->id == 'followed'): ?>
            <div class="commentThumb">
                <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$data->followed->urlID)); ?>" class="userAvatar">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $data->followed->memberinfo->avatar; ?>"></a>
            </div>
            <?php echo CHtml::link(CHtml::encode($data->followed->login), array('member/dashboard', 'id'=>$data->followed->urlID)); ?> </h3><br />
        <?php else: ?>
            <div class="commentThumb">
                <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$data->following->urlID)); ?>" class="userAvatar">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $data->following->memberinfo->avatar; ?>"></a>
            </div>
            <?php echo CHtml::link(CHtml::encode($data->following->login), array('member/dashboard', 'id'=>$data->following->urlID)); ?> </h3><br />
        <?php endif; ?>
    </div>
</div>
