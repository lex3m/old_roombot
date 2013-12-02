<?php
/* @var $this UsersController */
/* @var $model Users */




?>

<div class="list-bot">

<?php if(Yii::app()->user->hasFlash('send_letter_for_password')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('send_letter_for_password'); ?>
    </div>
<?php endif; ?> 

</div>