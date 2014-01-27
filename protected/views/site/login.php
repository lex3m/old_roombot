<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
/*$this->breadcrumbs=array(
	'Login',
);*/
?>

<div class="list-bot">
<h1>Log in</h1>

<div class="auth-form">
    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

        <?php if(Yii::app()->user->hasFlash('error')): ?>
            <div class="flash-error">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email'); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>

        </div>


        <div class="row rememberMe">
            <?php echo $form->checkBox($model,'rememberMe'); ?>
            <?php echo $form->label($model,'rememberMe'); ?>
            <?php echo $form->error($model,'rememberMe'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Log in'); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->
    <div class="social networks">
        <span>Authorize with social networks and start using our site</span>
        <?php if(Yii::app()->user->isGuest) $this->widget('AuthVK'); ?>
        <?php if(Yii::app()->user->isGuest) $this->widget('AuthFB'); ?>
    </div><!-- end social networks-->
</div>
<div class="ne-vhod">
     Do not have your  account?<br /> In this case you need to create your account now!<br />
     <div class="knopka-srednyaya">
         <a href="/companies/register" class="knopo4ka">Sign up</a>
     </div>
    <?php //echo CHtml::link('Forget password?',array("site/password")); ?>
</div>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>

    <!-- VK Widget -->
    <div id="vk_groups"></div>
    <script type="text/javascript">
        VK.Widgets.Group("vk_groups", {mode: 0, width: "700", height: "290"}, 60899631);
    </script>
</div><!-- list-bot -->
