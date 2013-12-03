<?php
/**
 * Страница отображения последних фотографий
 */
?>

<div class="list-bot izo-list">
    <h1><?php if ($query=='') { ?> Последние фотографии
    <?php } else { ?>
     Фотографии по запросу "<?php echo $query; ?>"
    <?php } ?>
    </h1>
    <div id="lastPhotosContainer">
        <ul class="lastPhotosList rb-list-nostyle rb-clearfix">
        <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$photos,
        'itemView'=>'_photos',
        'ajaxUpdate'=>false,
        'summaryText' => 'Фотографии {start}-{end} из {count}.',));
        ?>
       <ul>
    </div>
</div>