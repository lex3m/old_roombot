<h1>Пользователь <?php echo $model->login; ?></h1> 
<?php 

$this->widget('zii.widgets.CMenu',array(
                        'items'=>array(
                                array('label'=>'Мой профайл', 'url'=>$this->createUrl('profile', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Мои обьявления', 'url'=>$this->createUrl('ads', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Мои фото', 'url'=>$this->createUrl('photos', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Мое резюме', 'url'=>$this->createUrl('cv', array('id'=>$member->urlID)), 'visible'=>!Yii::app()->user->isGuest),
                        ), 
                )); 
?> 