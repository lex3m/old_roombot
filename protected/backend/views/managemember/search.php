<?php
/* @var $this ManagememberController */
/* @var $dataProvider CActiveDataProvider */

$this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Фотографии', 'url'=>array('mobilepictures/index')),  
                array('label'=>'Пользователи', 'url'=>array('managemember/index','time'=>'all','active'=>'all')),
        )));

?>
<h1>Фотографии пользователя</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>