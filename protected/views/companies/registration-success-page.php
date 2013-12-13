<?php
/* @var $this UsersController */
/* @var $model Users */




?>

<div class="list-bot">

<?php if(Yii::app()->user->hasFlash('register-success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('register-success'); ?>
    </div>
<?php endif; ?> 

</div>
