<h1>Компания <?php echo $model->name; ?></h1>
<?php 

$this->widget('zii.widgets.CMenu',array(
                        'items'=>array(
                                array('label'=>'Профайл', 'url'=>$this->createUrl('profile', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Товары', 'url'=>$this->createUrl('products', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Новости', 'url'=>$this->createUrl('news', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Тендеры', 'url'=>$this->createUrl('tenders', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Консультанты', 'url'=>$this->createUrl('consultants', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Вакансии', 'url'=>$this->createUrl('vacancies', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Акции', 'url'=>$this->createUrl('offers', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Фото', 'url'=>$this->createUrl('photos', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                        ), 
                )); 
?> 