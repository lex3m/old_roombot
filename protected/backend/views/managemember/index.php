<?php
/* @var $this ManagememberController */
/* @var $dataProvider CActiveDataProvider */
  
?>
<?php $this->widget('AdminHeadMenu', array()); ?>

<?php
$this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Все', 'url'=>array('managemember/index','time'=>'all','active'=>$isActive)),
                array('label'=>'За день', 'url'=>array('managemember/index','time'=>'day','active'=>$isActive)),
                array('label'=>'За неделю', 'url'=>array('managemember/index','time'=>'week','active'=>$isActive)),
                array('label'=>'За месяц', 'url'=>array('managemember/index','time'=>'month','active'=>$isActive)),
        )));
?>


<?php
$this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Активирован', 'url'=>array('managemember/index','time'=>$time,'active'=>"yes")),
                array('label'=>'Не активирован', 'url'=>array('managemember/index','time'=>$time,'active'=>"no")),
        )));
?> 
<h1>Пользователи</h1> <?php 
switch ($time) {
    case "all": $timeText = "все время"; break;
    case "day": $timeText = "день"; break;
    case "week": $timeText = "неделя"; break;
    case "month": $timeText = "месяц"; break;
    default: $timeText = "Все"; break;
}
switch ($isActive) {
    case "yes": $isActiveText = "активные"; break;
    case "no": $isActiveText = "не активные"; break;
    default: $isActiveText = "все"; break;
}
?>
<span> <?php echo 'Время:'.$timeText;?> <?php echo 'Статус:'.$isActiveText; ?></span>


</br>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
