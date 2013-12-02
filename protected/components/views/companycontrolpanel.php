<?php 

$this->widget('zii.widgets.CMenu',array(
                        'items'=>array(
                                array('label'=>'Профайл', 'url'=> Yii::app()->createUrl('companies/profile', array('id'=>$member->urlID))),
                                array('label'=>'Товары', 'url'=> Yii::app()->createUrl('companies/products', array('id'=>$member->urlID))),
                                array('label'=>'Новости', 'url'=> Yii::app()->createUrl('companies/news', array('id'=>$member->urlID))),
                                array('label'=>'Прайс-листы', 'url'=> Yii::app()->createUrl('companies/pricelists', array('id'=>$member->urlID))),
                                array('label'=>'Тендеры', 'url'=> Yii::app()->createUrl('companies/tenders', array('id'=>$member->urlID))),
                                array('label'=>'Консультанты', 'url'=> Yii::app()->createUrl('companies/consultants', array('id'=>$member->urlID))),
                                array('label'=>'Вакансии', 'url'=> Yii::app()->createUrl('companies/vacancies', array('id'=>$member->urlID))),
                                array('label'=>'Акции', 'url'=> Yii::app()->createUrl('companies/offers', array('id'=>$member->urlID))),
                                array('label'=>'Фото', 'url'=> Yii::app()->createUrl('companies/albums', array('id'=>$member->urlID))),
                                array('label'=>'Фото для мобильных', 'url'=> Yii::app()->createUrl('mobilepictures/add', array('id'=>$member->urlID))),
                        ), 
                )); 
?> 