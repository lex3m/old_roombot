<?php
/**
 * Страница отображения последних фотографий
 */
?>

<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/lightbox.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/lightbox-2.6.min.js', CClientScript::POS_END);

?>

<style>

</style>
<div class="list-bot izo-list">
    <h1><?php if ($query=='') { ?> Последние фотографии
    <?php } else { ?>
     Фотографии по запросу "<?php echo $query; ?>"
    <?php } ?>
    </h1> <h2><?php echo ($tagID !== '') ? 'с тэгом <i>'.Mobiletags::getTagName($tagID).'</i>' : '' ?></h2>
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