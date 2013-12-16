<?php
/**
 * Страница отображения последних фотографий
 */
?>

<?php
    // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/lightbox.css');
    // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/lightbox-2.6.min.js', CClientScript::POS_END);
$galery = <<<EOL
function showModule(){
//    $("#module").show("slow");
}

$(function(){


   /* $(".lastPhotos__item img").on('click', function ( e ) {
        //e.preventDefault();
//        $('body').css('overflow', 'hidden');
        var photoID = $(this).parents('li').attr('id');
        var nextPhotoID = $(this).parents('li').next().attr('id');
        var prevPhotoID = $(this).parents('li').prev().attr('id');
        var photoObj = {
                            prevPhotoID: prevPhotoID,
                            photoID: photoID,
                            nextPhotoID: nextPhotoID
                        };
        console.log(photoObj);
        $.ajax({
            type: "POST",
            url: "/site/ajaxGetPhoto",
            dataType: "html",
            data: photoObj
        })
        .done(function( msg ) {
            $(".spoiler_body").html(msg);
            $("#module").show("slow");
        });

    });*/
});

$(document).on('click','#close',function(e){
//     $('body').css('overflow', '');
     $("#module").hide("slow");
     $("#add_toIdeasBook").dialog("close");
     $('#tmpInfoPopup').dialog('close');
     $('.phtError').hide();
});

$(document).on('click', 'button.rb-button-like', function(event){
     event.preventDefault();
     var photoID = $(this).data('id');
     var currentLikes = $(this).data('likes');
     $.ajax({
               type: 'POST',
               url: "/photolike/add",
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
    console.log(photoObj);
    $.ajax({
        type: "POST",
        url: "/site/ajaxGetPhoto",
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
EOL;

Yii::app()->clientScript->registerScript('galery', $galery, CClientScript::POS_END);



?>

<div class="list-bot izo-list">
    <h1> Последние фотографии </h1>
    <?php if(!empty($_GET['id'])): ?>
    <h2> с тегом <i><?php echo Mobiletags::getTagName(intval($_GET['id']));?></i></h2>
    <?php elseif(!empty($query)): ?>
    <h2> по запросу "<?php echo $query; ?>" </h2>
    <?php endif; ?>

    <div id="lastPhotosContainer">
        <ul class="lastPhotosList rb-list-nostyle rb-clearfix setka">
        <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$photos,
        'itemView'=>'_photos',
        'ajaxUpdate'=>false,
        'summaryText' => 'Фотографии {start}-{end} из {count}.',));
        ?>
       <ul>
    </div>
</div>

<!-- Spoyler -->
<div id="module" class="spoiler_body spoiler_container">

</div>
<!-- Spoyler -->