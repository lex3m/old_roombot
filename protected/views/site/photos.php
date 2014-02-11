<?php
/**
 * Страница отображения последних фотографий
 */
?>

<?php
    // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/lightbox.css');
    // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/lightbox-2.6.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('pluso', "
                                    (function() {
                                    if (window.pluso)if (typeof window.pluso.start == 'function') return;
                                    if (window.ifpluso==undefined) {
                                    window.ifpluso = 1;
                                    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                                    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                                    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                                    var h=d[g]('body')[0];
                                    h.appendChild(s);
                                    }

                                    })();
                                ", CClientScript::POS_END);

Yii::app()->clientScript->registerScript('helpersss', '
          yii = {
              urls: {
                  likeComment: '.CJSON::encode(Yii::app()->createUrl('commentlike/change')).',
                  photolikeAdd: '.CJSON::encode(Yii::app()->createUrl('photolike/add')).',
                  ajaxGetPhoto: '.CJSON::encode(Yii::app()->createUrl('site/ajaxGetPhoto')).',
                  allcomments: '.CJSON::encode(Yii::app()->createUrl('site/allcomments')).',
                  commentsdelete: '.CJSON::encode(Yii::app()->createUrl('comments/delete')).',
                  commentsedit: '.CJSON::encode(Yii::app()->createUrl('comments/edit')).',
                  base: '.CJSON::encode(Yii::app()->baseUrl).'
              },
              messages: {
                deleteComment: "'.Yii::t('sitePhotos', 'Are you really want to delete this comment?').'",
                showAll: "'.Yii::t('sitePhotos', 'Show all comments').'",
                inputComment: "'.Yii::t('sitePhotos', 'Input your comment').'",
              }
          };
      ');

$galery = <<<EOL
$(document).on('keyup', function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code === 27) {
        $('#close').trigger('click');
    }
    if (code === 37) {
        $('.gallery-nav-left').trigger('click');
    }
    if (code === 39) {
        $('.gallery-nav-right').trigger('click');
    }
});

$(document).on('click','#close',function(e){
//     $('body').css('overflow', '');
     $("#module").hide("slow");
     $("#add_toIdeasBook").dialog("close");
     $('#tmpInfoPopup').dialog('close');
     $('#edit_comment').dialog('close');
     $('#photoTag').dialog('close');
     $('.phtError').hide();
});

$(document).on('click', 'button.rb-button-like', function(event){
     event.preventDefault();
     var photoID = $(this).data('id');
     var currentLikes = $(this).data('likes');
     $.ajax({
               type: 'POST',
               url: yii.urls.photolikeAdd,
               data: {id: photoID},
               success: function(msg){
                         var data = jQuery.parseJSON(msg);
                         $('button.rb-button-like').text(data.countLikes);
                         $('button.rb-button-like').attr('data-likes', data.countLikes);
               }
     });
});

$(document).on('click', '.lastPhotos__item img, .gallery-nav-right, .gallery-nav-left', function ( event ) {
    //event.preventDefault();
    var photoID = $(this).attr('id');
    var nextPhotoID = $('.lastPhotos__item#'+photoID).next().attr('id');
    var prevPhotoID = $('.lastPhotos__item#'+photoID).prev().attr('id');
    var photoObj = {
                            prevPhotoID: prevPhotoID,
                            photoID: photoID,
                            nextPhotoID: nextPhotoID
                   };
    $("#add_toIdeasBook").dialog("close");
    $('#tmpInfoPopup').dialog('close');
    $('#edit_comment').dialog('close');
    $('#photoTag').dialog('close');
    $.ajax({
        type: "POST",
        url: yii.urls.ajaxGetPhoto,
        dataType: "html",
        data: photoObj,
        beforeSend: function (){
            $("#module").addClass('loading');
        },
        complete: function() {
            $("#module").removeClass('loading');
        }
    })
    .done(function( msg ) {
        $(".spoiler_body").html(msg);
        $("#module").show("slow");
    });

});

$(document).on('click', '.likeIcon', function(event){
     event.preventDefault();
     $.ajax({
               type: 'POST',
               url: yii.urls.likeComment,
               data: {commentID: this.id},
               success: function(msg){
                    var data = jQuery.parseJSON(msg);
                         $('#'+data.commentID+'.likeIcon').empty().append('<img src=\"\">'+data.countLikes);

               }
            });
});

$(document).on('click', '.showAllComments', function (e) {
    e.preventDefault();
    var photoID = $(this).attr('id');
     $.ajax({
                   type: 'POST',
                   url: yii.urls.allcomments,
                   data: {id: photoID},
                   dataType: 'html',
                   beforeSend: function (){
                        $('.spoiler-content-2').addClass('loading');
                   },
                   complete: function() {
                        $('.spoiler-content-2').removeClass('loading');
                   },
                   success: function(msg){
                        $('.showAllComments').hide();
                        $('.komments-users').html(msg);
                   }
            });
});

$(document).on('click', '.commentDeleteIcon', function(event){
     var divLen = $("div.oneComment").length;

     var id = this.id;
     if (confirm( yii.messages.deleteComment )) {
         $.ajax({
                       type: 'POST',
                       url: yii.urls.commentsdelete,
                       data: {id: id},
                       success: function(msg){
                            if (divLen > 5) {
                                var data = jQuery.parseJSON(msg);
                                $('.oneComment#'+data.id).remove();
                                $('div.foto-kom-info').html(data.countComments);
                            } else {
                                var data = jQuery.parseJSON(msg);
                                var photoID = $('input[name="photoID"]').val();
                                 $.ajax({
                                       type: 'POST',
                                       url: yii.urls.allcomments,
                                       data: {id: photoID, limit: 5},
                                       dataType: 'html',
                                       beforeSend: function (){
                                            $('.spoiler-content-2').addClass('loading');
                                       },
                                       complete: function() {
                                            $('.spoiler-content-2').removeClass('loading');
                                       },
                                       success: function(msg){
                                            $('.komments-users').html(msg);
                                            $('div.foto-kom-info').html(data.countComments);
                                            if (data.showAddComments === true) {
                                                $('div.foto-kom-info').append('<a class=\"showAllComments\" id=\"'+data.photoID+'\" href=\"\"> yii.messages.showAll</a>');
                                            }
                                       }
                                });
                            }
                       }
                 });
     }
});


$(document).on('click', '.commentEditIcon', function(event){
     $('#edit_comment').data('link', '123').dialog('open');
     var commentContent = $('.oneComment#'+this.id+' p').text();
     $('#edit_comment textarea').val(commentContent);
     $('#edit_comment input[name=photoID]').val(this.id);
});

$(document).on('click', '#edit_comment #addCommentButtonPopup', function(event){
     var idComment = $('#edit_comment input[name=photoID]').val();
     var contentComment = $('#edit_comment textarea').val();
     if (contentComment!='')
     {
         $.ajax({
                   type: 'POST',
                   url: yii.urls.commentsedit,
                   data: {id: idComment, commentContent:contentComment},
                   beforeSend: function (){
                        $('.spoiler-content-2').addClass('loading');
                   },
                   complete: function() {
                        $('.spoiler-content-2').removeClass('loading');
                   },
                   success: function(msg){
                        var data = jQuery.parseJSON(msg);
                        $('.oneComment#'+data.id+' p').empty().append(data.comment);
                   }
            });
        $('#edit_comment').dialog('close');
     } else {
       alert(yii.messages.inputComment);
     }
});

EOL;

Yii::app()->clientScript->registerScript('galery', $galery, CClientScript::POS_END);



?>

<div class="list-bot izo-list">
    <h1> <?php echo Yii::t('sitePhotos', 'Last photos');?> </h1>
    <?php if(!empty($_GET['id'])): ?>
    <h2>  <?php echo Yii::t('sitePhotos', 'with tag');?> <i><?php echo Mobiletags::getTagName(intval($_GET['id']));?></i></h2>
    <?php elseif(!empty($query)): ?>
    <h2> <?php echo Yii::t('sitePhotos', 'by query');?> "<?php echo $query; ?>" </h2>
    <?php endif; ?>

    <div id="lastPhotosContainer">
        <ul class="lastPhotosList rb-list-nostyle rb-clearfix setka">
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$photos,
            'itemView'=>'_photos',
            'ajaxUpdate'=>false,
            'summaryText' => Yii::t('sitePhotos', 'Photos {start}-{end} from {count}.'),
            'pager' => array(
                'class' => 'ext.infiniteScroll.IasPager',
                'rowSelector'=>'.lastPhotos__item',
                'listViewId' => 'yw0',
                'header' => '',
                'loaderText'=> Yii::t('sitePhotos', 'Loading...'),
                'options' => array('history' => false, 'triggerPageTreshold' => 65536, 'trigger'=>  Yii::t('sitePhotos', 'Load more')),
            )
        ));
        ?>
       <ul>
    </div>
</div>

<!-- Spoyler -->
<div id="module" class="spoiler_body spoiler_container">

</div>
<!-- Spoyler -->