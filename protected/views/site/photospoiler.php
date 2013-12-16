    <script type="text/javascript">(function() {
            if (window.pluso)if (typeof window.pluso.start == "function") return;
            if (window.ifpluso==undefined) { window.ifpluso = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                var h=d[g]('body')[0];
                h.appendChild(s);
            }})();
    </script>
    <div class="closer">
        <img src="<?php echo Yii::app()->baseUrl; ?>/images/close.png" id="close" />
    </div>

    <div class="spoiler-content-1">

        <div class="gallery-sliger">
            <?php if (!empty($prevPhoto)):?>
                <a class="gallery-nav-left" href="#" id="<?php echo $prevPhoto;?>">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/str_oransh_l.png" />
                </a>
            <?php endif; ?>
            <?php if (!empty($nextPhoto)):?>
                <a class="gallery-nav-right" href="#" id="<?php echo $nextPhoto;?>">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/str_oransh_r.png" />
                </a>
            <?php endif; ?>
            <div class="usfot">
                <img class="image__full" height="580" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $model->image; ?>" />
            </div>
        </div>

        <div class="sotcial">
            <div class="photoElement__stats stats-left">
                <?php if (!Yii::app()->user->isGuest):?>
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="Поставить лайк. Количество лайков - <?php echo $model->countLikes; ?>" class="rb-ministats-item">
                                <div class="rb-button-group rb-button-group-medium">
                                    <button id="likePhoto" data-likes="0" data-id="<?php echo $model->id?>" class="rb-button rb-button-like rb-button-medium rb-button-responsive" tabindex="0">
                                        <?php echo $model->countLikes; ?>
                                    </button>
                                </div>
                            </li>
                            <li title="Добавить в книгу идей. Уже есть <?php echo Yii::t('app', '{n} книга идей|{n} две книги идей|{n} книг идей|{n} книг идей', $model->countIdeasBooks); ?>" class="rb-ministats-item">
                                <a class="graybutton" href="" id="AddToIdeabook" >
                                    <span class="graybuttonIcon uiButtonIconAddToIdeabook"><img height="20" width="20" src="<?php echo Yii::app()->baseUrl; ?>/images/fav.jpg"/></span>
                                    <span class="addBookmarkLink" id="<?php echo $model->id; ?>">Добавить в книгу идей</span>
                                </a>
                            </li>
                            <li class="rb-ministats-item">
<!--                                <div class="pluso" data-options="small,square,line,horizontal,counter,theme=04" data-services="vkontakte,facebook,twitter,google,email"></div>-->
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="<?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $model->countComments); ?>" class="rb-ministats-item">
                                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$model->id)); ?>" class="rb-ministats rb-ministats-small rb-ministats-comments">
                                    <span class="small_comments_i small_i"></span>
                                    <span ><?php echo $model->countComments;  ?> &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </a>
                            </li>
                            <li title="<?php echo Yii::t('app', '{n} книга идей|{n} две книги идей|{n} книг идей|{n} книг идей', $model->countIdeasBooks); ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_albums_i small_i"></span>
                                    <span><?php echo $model->countIdeasBooks; ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </span>
                            </li>
                            <li title="<?php echo $model->countLikes; ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_likes_i small_i"></span>
                                    <span><?php echo $model->countLikes; ?></span>
                                </span>
                            </li>
                            <li class="rb-ministats-item" style="margin-left: 5px;">
                                <div class="pluso" data-options="small,square,line,horizontal,counter,theme=04" data-services="vkontakte,facebook,twitter,google,email"></div>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="sotssety">
            </div>
        </div>

    </div>

    <div class="spoiler-content-2">
        <div class="scroll-content2">
            <div class="awtor">
                <img id="mainMemberCabinetPic"  src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo $model->member->memberinfo->avatar; ?>" width="45" height="55">
                <h2 class="photoElement__title">
                    <?php echo CHtml::link($model->name ,array('mobilepictures/viewinfo','id'=>$model->id), array('target'=>'_blank', 'class'=>'rb-dark-link', 'title'=>'Просмотр фотографии'));  ?>
                </h2>
                <?php echo CHtml::link(CHtml::tag('h3',array('class'=>'photoElement__details rb-type-light'),$model->member->login),array('member/dashboard','id'=>$model->member->urlID), array('target'=>'_blank'));  ?>
            </div>
            <div class="info-foto">
<!--                <div class="foto-nazwa">-->
<!--                    <h3>Картинка 1</h3>-->
<!--                </div>-->
                <div class="foto-opys">
                    <p><?php echo $model->info; ?></p>
                </div>
                <div class="foto-tegi">
                    <?php if (count($tags)>0):  ?>
                        <span><strong>Теги:</strong></span>
                        <?php echo implode(", ",$tagNameArray); ?>
                    <?php endif;?>
                </div>
            </div>
            <?php if ($model->countComments > 0): ?>
                <div class="foto-kommentariy">
                    <div class="foto-kom-info">
                    <span><?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $model->countComments); ?></span>
                    <?php if($model->countComments > 10): ?> <a href="#">Показать все</a> <?php endif; ?>
                </div>
                <?php $this->widget('ext.timeago.JTimeAgo', array('selector' => ' .timeago',));   ?>
                    <div class="komments-users">
                        <?php foreach ($comments as $comment): ?>
                            <span class="user">
                                <div class="commentThumb">
                                    <a  href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$comment->member->urlID)); ?>" class="userAvatar">
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/members/avatars/<?php echo$comment->member->memberinfo->avatar; ?>"></a>
                                </div>
                                <h4><?php echo CHtml::link($comment->member->login,array('member/dashboard',array('id'=>$comment->member->urlID)));?></h4>

                                 <p><?php echo CHtml::encode($comment->content); ?></p>
                            </span>
                        <?php endforeach; ?>

<!--                            <span class="user user_2">-->
<!--                                 <h4>User 102:</h4>-->
<!--                                 <p>fkdnlv fkjvbdlkfv  kfjvkv slkjfls очень длинное описание</p>-->
<!--                            </span>-->
<!--                            <span class="user user_3">-->
<!--                                 <h4>User 103:</h4>-->
<!--                                 <p>tgkmnbl lodhvb ljp ndpfvndpf lkfnpfpvk lkfkf vlkfgmp; nldifjppeoi lfkgengkneg lefkgnelkgnkb flgnlegknmelrnfk lkbgfbm kgbngknlef ldfknlfdkbm lvkglkn lfkgvndlkfn </p>-->
<!--                            </span>-->
<!--                            <span class="user user_1">-->
<!--                                 <h4>User 101:</h4>-->
<!--                                 <p>Это супер - пупер крвсивое фотоkgndvv lk;ldfnlsj ,fjnlskfn</p>-->
<!--                            </span>-->
<!--                            <span class="user user_2">-->
<!--                                 <h4>User 102:</h4>-->
<!--                                 <p>fkdnlv fkjvbdlkfv  kfjvkv slkjfls очень длинное описание</p>-->
<!--                            </span>-->
<!--                            <span class="user user_3">-->
<!--                                 <h4>User 103:</h4>-->
<!--                                 <p>tgkmnbl lodhvb ljp ndpfvndpf lkfnpfpvk lkfkf vlkfgmp; nldifjppeoi lfkgengkneg lefkgnelkgnkb flgnlegknmelrnfk lkbgfbm kgbngknlef ldfknlfdkbm lvkglkn lfkgvndlkfn </p>-->
<!--                            </span>-->
<!--                            <span class="user user_1">-->
<!--                                 <h4>User 101:</h4>-->
<!--                                 <p>Это супер - пупер крвсивое фотоkgndvv lk;ldfnlsj ,fjnlskfn</p>-->
<!--                            </span>-->
<!--                            <span class="user user_2">-->
<!--                                 <h4>User 102:</h4>-->
<!--                                 <p>fkdnlv fkjvbdlkfv  kfjvkv slkjfls очень длинное описание</p>-->
<!--                            </span>-->
<!--                            <span class="user user_3">-->
<!--                                 <h4>User 103:</h4>-->
<!--                                 <p>tgkmnbl lodhvb ljp ndpfvndpf lkfnpfpvk lkfkf vlkfgmp; nldifjppeoi lfkgengkneg lefkgnelkgnkb flgnlegknmelrnfk lkbgfbm kgbngknlef ldfknlfdkbm lvkglkn lfkgvndlkfn </p>-->
<!--                            </span>-->
                </div>
            <?php endif; ?>
                <?php if (!Yii::app()->user->isGuest): ?>
                    <div class="napisat-komment">
                        <table class="table-comment">
                            <tr>
                                <td>
                                    <form id="usercomment"action="fotocomment.php" method="POST" name="commentform">
                                        <span>Напишите ваш комментарий к фото</span><br />
                                        <textarea name="usercomment" cols="40" rows="5">
                                        </textarea><br />
                                        <input type="submit" name="button" value="Опубликовать" class="opublik">
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php else : ?>
                    Зарегистрируйстесь или войдите под своим аккаунтом для возможности комментирования фотографий
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php
/************окно добавления фотографии в книгу идей*****************/
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'add_toIdeasBook',
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
        'title'=>'Добавление фотографии в книгу идей',
    ),
));
?>
    <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'selectIdeasBookForm',
            'enableAjaxValidation'=>false,
        )); ?>

        <div class="row">
            <?php echo CHtml::dropDownList('ideasBookList', '',
                CHtml::listData(Ideasbook::model()->findAll('memberID=:m',array(':m'=>Yii::app()->user->id)), 'id', 'name'),
                array('empty' => '(Выберите книгу идей)'));  ?>
        </div>
        <input id="" type="button" class="rbBtn addPhotoToIdeasBookBtn" value="Добавить">
        <div class="phtError">
            Вы добавили уже это фото в данную книгу идей.
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    /************конец окна добавления фотографии в книгу идей****************/
?>

<?php
    /************окно успешного добавления фотографии к книге идей*****************/
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'tmpInfoPopup',
        'options'=>array(
            'autoOpen'=>false,
            'closeOnEscape'=> 'true',
            'width'=>'400',
            'show'=>'show',
            'title'=>'Добавление фотографии в книгу идей',
        ),
    ));
    ?>
    <p class="tmpInfoMsg">Вы успешно добавили эту фотография в книгу идей</p>
    <div class="form">
        <input id="tmpInfoPopupBtn" type="button" class="rbBtn tmpInfoBtn" value="Ok">
    </div><!-- form -->
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    /************конец окна успешного добавления фотографии к книге идей****************/
?>


    <?php
Yii::app()->clientScript->registerScript('galery', "

var issetIdeasBooks = true;
$('.addBookmarkLink').on ('click', function(event){
    event.preventDefault();
    $('#selectIdeasBookForm .addPhotoToIdeasBookBtn').attr('id',this.id);
    var selectedIdeasBook = $('#ideasBookList option:selected').val();
    var lengthOfIdeasBooks = $('#ideasBookList > option').length;
    if (lengthOfIdeasBooks!=1){
        $('.phtError').hide();
        $('#add_toIdeasBook').dialog('open');
    }
    else
    {
        issetIdeasBooks = false;
        $('p.tmpInfoMsg').text('У вас пока нет ни одной книг идей.');
        $('#tmpInfoPopupBtn').val('Создать');
        $('#tmpInfoPopup').dialog('open');
    }
    return event.defaultPrevented || event.returnValue == false;
});

$('.addPhotoToIdeasBookBtn').live('click',function(event){
     event.preventDefault();
     var selectedIdeasBook = $('#ideasBookList option:selected').val();
         $.ajax({
                   type: 'POST',
                   url: '".Yii::app()->createUrl('ideasphotos/add')."',
                   data: {id: this.id, selectedIdeasBook: selectedIdeasBook},
                   success: function(msg){
                             var data = jQuery.parseJSON(msg);
                             if (data.id!='') {
                                $('#add_toIdeasBook').dialog('close');
                                $('.phtError').hide();
                                $('#tmpInfoPopup').dialog('open');
                             } else {
                                $('.phtError').show();
                             }
                   }
            });

});

$('#tmpInfoPopupBtn').live('click',function(event){
  if (issetIdeasBooks)
        $('#tmpInfoPopup').dialog('close');
  else window.location.href = '".Yii::app()->createUrl('ideasbook/add')."';
});
", CClientScript::POS_END);
?>
