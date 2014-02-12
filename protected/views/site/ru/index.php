<style>
    .alert-block {
        width: 696px;
        padding: 10px 0 0 135px;
    }
    .alert h4 {
        color: #c09853;
        font-weight: bold;
    }
    .alert {
        padding: 8px 35px 8px 14px;
        margin-bottom: 20px;
        text-shadow: 0 1px 0 rgba(255,255,255,0.5);
        background-color: #fcf8e3;
        border: 1px solid #fbeed5;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        color: #c09853;
    }
    .alert-block>p, .alert-block>ul {
        margin-bottom: 0;
        font-size: 13.5px;
    }
</style>
<div style="padding-left:135px">
    <div class="alert alert-block alert-warning">
        <h4 class="alert-heading">Внимание!</h4>
        <p>
            Уважаемые пользователи Румбот-приложения, Play маркет по ошибке заблокировал наше приложение.
            Мы его уже восстановили, но для получения обновлений просим его переустановить по ссылке <a href="https://play.google.com/store/apps/details?id=com.astam.roombot" target="_blank">https://play.google.com/store/apps/details?id=com.astam.roombot</a> <br/>
            Спасибо, друзья, что Вы с нами!
        </p>
    </div>
</div>
<div class="instrukciya">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/instrukciya.png" width="738" height="265" alt="Инструкция" title="<?php echo Yii::t('mainLayout', 'Instruction');?>" />
        </div>
        <div class="infobot">
             <div class="knopka-registr">
                <a href="<?php echo $this->createUrl('companies/register'); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo Yii::t('siteIndex', 'create_account.png')?>" class="imgakkaunt1" width="221" height="31" alt="<?php echo Yii::t('mainLayout', 'Sign up');?>" title="<?php echo Yii::t('mainLayout', 'Sign up');?>" /></a>
             </div>
</div>
  
  