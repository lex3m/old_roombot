<div id="<?php echo $data->id; ?>" name="photo" class="span-22 last" style="margin-bottom:30px;" id="company_photo" name="99">
        <img name="downphoto" style="float:left;padding-right:40px;" width="24px" height="24px" src="<?php echo Yii::app()->request->getBaseUrl() ?>/images/site/down.png"  />
        <img name="passphoto" style="padding-right:10px; float:left" width="24px" height="24px" src="<?php echo Yii::app()->request->getBaseUrl() ?>/images/site/check.png"  />
        <span style="float:left; padding-right:50px;"><?php echo $data->name; ?></span>      
</div>