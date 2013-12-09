<div class="list-bot">

<?php if ($member->id==Yii::app()->user->id): ?><h1 style = "margin-bottom: 0;">Мой кабинет</h1><?php endif; ?>
<br>
<!--<div class="leftBar">
<!--</div>-->
<div class="rightBlockMemeberInfo">

    <div class="leftBar">
        <div class="memberCabinetPic">
            <a onclick="return false;" href="">
                <img id="mainMemberCabinetPic" src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $member->memberinfo->avatar;?>"/>
            </a>
        </div>
        <div id="friendsFollowDiv">
            <?php if (Yii::app()->user->id !== $member->id && !Yii::app()->user->isGuest):?>
                <?php if (!MemberFollowers::checkFollower($member->id)): ?>
                    <div class="knopky1 follow" style="display: block;">
                        <?php echo CHtml::link('Подписаться',array('member/addfollower','id'=>$member->urlID), array('id'=>'addfollower')); ?>
                    </div>
                    <div class="knopky1 unfollow" style="display: none;">
                        <?php echo CHtml::link('Отписаться',array('member/rmfollower','id'=>$member->urlID), array('id'=>'rmfollower')); ?>
                    </div>
                <?php else: ?>
                    <div class="knopky1 follow" style="display: none;">
                        <?php echo CHtml::link('Подписаться',array('member/addfollower','id'=>$member->urlID), array('id'=>'addfollower')); ?>
                    </div>
                    <div class="knopky1 unfollow" style="display: block;">
                        <?php echo CHtml::link('Отписаться',array('member/rmfollower','id'=>$member->urlID), array('id'=>'rmfollower')); ?>
                    </div>
                <?php endif; ?>
                <div class="followers">
                    <?php if ($member->countFollowing > 0): ?>
                        <div class="sidebar">
                            <div class="sidebar-header">Подписки (<?php echo $member->countFollowing;?>)</div>
                            <div class="sidebar-body">
                                <ul id="followingsBox">
                                    <li class="profileThumbBox">
                                        <?php $i = 0;
                                        foreach($following as $f): ?>
                                            <div class="thumbFollowUserDiv">
                                                <?php echo CHtml::link(CHtml::image('/images/members/avatars/'.$f->following->memberinfo->avatar, 'title'.$f->following->login, array('title'=>$f->following->login)), array('member/dashboard','id'=>$f->following->urlID)); ?>
                                            </div>
                                            <?php $i++; if ($i == 5) break;
                                        endforeach;?>
                                        <?php if ($member->countFollowing > 5): ?>
                                            <?php echo CHtml::link( 'Просмотреть всех '.$member->countFollowing, array('member/following', 'id'=>$f->followed->urlID), array('class'=>'view-all') ); ?>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($member->countFollowed > 0): ?>
                        <div class="sidebar">
                            <div class="sidebar-header">Подписчики (<?php echo $member->countFollowed;?>)</div>
                            <div class="sidebar-body">
                                <ul id="followingsBox">
                                    <li class="profileThumbBox">
                                        <?php $i = 0;
                                        foreach($followed as $f): ?>
                                            <div class="thumbFollowUserDiv">
                                                <?php echo CHtml::link(CHtml::image('/images/members/avatars/'.$f->followed->memberinfo->avatar, 'title'.$f->followed->login, array('title'=>$f->followed->login)), array('member/dashboard','id'=>$f->followed->urlID)); ?>
                                            </div>
                                            <?php $i++; if ($i == 5) break;
                                        endforeach;?>
                                        <?php if ($member->countFollowed > 5): ?>
                                            <?php echo CHtml::link( 'Просмотреть всех '.$member->countFollowed, array('member/followed', 'id'=>$f->followed->urlID), array('class'=>'view-all') ); ?>

                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (!Yii::app()->user->isGuest) : ?>
                <div class="knopky1" style="display: block;">
                    <?php echo CHtml::link('Мои подписки',array('member/following'), array('id'=>'followers')); ?>

                </div>
                <div class="knopky1" style="display: block;">
                    <?php echo CHtml::link('Мои подписчики',array('member/followed'), array('id'=>'followers')); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <div id="memberCommonInfo">
        <h2><?php echo  CHtml::link($member->login, array('member/dashboard', 'id'=>$member->urlID)); ?></h2>
        <div class="memberCountComments">
            Фотографии: <?php echo $member->countPhotos; ?>
            &nbsp;|&nbsp;
            Комментарии: <?php echo $member->countComments; ?>
        </div>
    </div>
    <div style="margin-bottom: 0px"></div>
    <div id="memberDescriptionInfo" class="kabinet-colonka-right">

        <?php if ($member->memberinfo->showEmail==1): ?>
            <span class="zagolowok-info">Email:</span>
            <?php echo $member->email; ?>
            <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->website!=""): ?>
            <span class="zagolowok-info">Сайт:</span>
            <?php echo $member->memberinfo->website; ?>
            <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->phone!=""): ?>
            <span class="zagolowok-info">Телефон:</span>
            <?php echo $member->memberinfo->phone; ?>
            <br>
        <?php endif; ?>
        <?php if ($member->memberinfo->about!=""): ?>
            <div id="memberAbout">
                <span class="zagolowok-info">Краткая информация:</span>
                <?php echo $member->memberinfo->about; ?>
            </div>
            <br>
        <?php endif; ?>
        <div class="knopky3">
            <?php echo CHtml::link('Книги идей',array('ideasbook/index','id'=>$member->urlID)); ?>
            <?php if (Yii::app()->user->id == $member->id): ?>

            <?php echo CHtml::link('Изменить профайл',array('member/change')); ?>

            <?php echo CHtml::link('Сменить аватар',array('member/avatar')); ?>
        </div>
    <?php endif; ?>
    </div>
</div>


<div class="span-17 last">
    <div class="form width-form">
        <div class="span-17 last">
            <div class="items list3">
                <?php if (isset($_GET['id']) && !empty($_GET['id'])): ?>
                <div class="newsFeedMainContent">
                    <div class="followingTitle">Люди (<?php echo $dataProvider->getItemCount(); ?>)</div>
                    <?php $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$dataProvider,
                        'itemView'=>'_follow',
                        'summaryText' => 'Показаны {start}-{end} из {count}.',
                        'emptyText' => 'У вас еще нет подписок',
                        'pagerCssClass' => 'pager-left'
                    )); ?>
                </div>
                <?php else: ?>
                    <h2><?php echo (Yii::app()->controller->action->id == 'followed') ? 'Мои подписчики' : 'Мои подписки'?></h2>
                        <?php $this->widget('zii.widgets.CListView', array(
                            'dataProvider'=>$dataProvider,
                            'itemView'=>'_follower',
                            'summaryText' => 'Показаны {start}-{end} из {count}.',
                            'emptyText' => 'У вас еще нет подписок',
                            'pagerCssClass' => 'pager-left'
                        )); ?>
                    <?php endif; ?>
            </div>
        </div>

    </div>
</div>
</div>
</div>

<?php
Yii::app()->clientScript->registerScript('remove-follower',"

     $( '.rmfollower').on('click', function(event){
           event.preventDefault();
           var followerUrl = $(this).attr('href');
           var urlID = followerUrl.split('/')[3];
           var parent = $(this).parent();
                $.ajax({
                       type: 'POST',
                       url: followerUrl,
                       data: {urlID: urlID},
                       success: function(msg){
                            if (msg == 1){
                                parent.remove();
                            }
                       }
                });
            return false;
     });
            ", CClientScript::POS_END);
?>