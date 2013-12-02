<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Register Success',
);


?>

<?php if(Yii::app()->user->hasFlash('register-success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('register-success'); ?>
    </div>
<?php endif; ?> 