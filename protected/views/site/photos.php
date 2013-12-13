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


    $(".lastPhotos__item img").on('click', function ( e ) {
        //e.preventDefault();
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

    });
});

$(document).on('click','#close',function(e){
     $("#module").hide("slow");
});

EOL;

Yii::app()->clientScript->registerScript('galery', $galery, CClientScript::POS_END);



?>

<script type="text/javascript">
//    $(".lastPhotos__item").on("click", function ( e ) {
//        e.preventDefault();
//        var photoID = $(this).attr("id");
//        alert(photoID);
//    });
</script>
<div class="list-bot izo-list">
    <h1><?php if ($query=='') { ?> Последние фотографии
    <?php } else { ?>
     Фотографии по запросу "<?php echo $query; ?>"
    <?php } ?>
    </h1>
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