<?php

$this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Фотографии', 'url'=>array('mobilepictures/index')),
                array('label'=>'Пользователи', 'url'=>array('managemember/index','time'=>'all','active'=>'all')),
                array('label'=>'Комментарии', 'url'=>array('comments/index','time'=>'all','active'=>'all')),
                array('label'=>'Статистика', 'url'=>array('site/stat')),
        )));