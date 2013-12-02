<div class="span-17">
   <?php $this->widget('CabinetHeader', array('url_ID'=>$member->urlID));
    ?>
   <div class="span-17">
        Информация о компании
        <?php echo CHtml::link('Скрыть/Показать',array('controller/action')); ?> 
        <?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Редактировать',array('controller/action')); ?>
   </div>
   <div class="span-17 last">
        <div class="span-4"> 
            <?php
            if(($model->logo!="company_default.jpg"))
                        echo CHtml::image('./images/companies/logo/'.$model->logo,'Avatar',
                                                                array(
                                                           
                                                                ));
                        else
                        echo CHtml::image('/images/companies/logo/company_default.jpg','No photo',
                                                                array(
  
                                                                ));
                                                                ?>
        </div>
        <div class="span-13 last">
           <?php if (count($companyInfo)!=0) { ?>
            <ul>
                <?php if ($companyInfo->legal_name!="") {  ?><li>Юридическое наименование:<?php echo $companyInfo->legal_name; ?></li><?php } ?>
                <?php if ($companyInfo->city) {  ?><li>Страна:<?php $city=Cities::model()->findbyPk($companyInfo->city);$country=Countries::model()->findbyPk($city->countryID); echo $country->name; ?></li><?php } ?>
                <?php if ($companyInfo->city) {  ?><li>Город:<?php echo $city->name; ?></li><?php } ?>
                <?php if ($companyInfo->address) {  ?><li>Адрес:<?php echo $companyInfo->address; ?></li><?php } ?>
                <?php if (count($phones)>0) {  ?><li>Телефоны:<?php for($i=0;$i<count($phones);$i++) { echo $phones[$i]->phone; if ($i<(count($phones)-1)) echo ' ,'; } ?>  </li><?php } ?>
                <?php if ($companyInfo->official_email) {  ?><li>Email:<?php echo $companyInfo->official_email; ?></li><?php } ?>
                <?php if ($companyInfo->fax) {  ?><li>Факс:<?php echo $companyInfo->fax; ?></li><?php } ?>
             </ul>
             <?php } ?>
             
              
             Прайс-листы: <br>
             Товары: <br>
             Скидки: <br><br><br>
             </div>
             </div>
             <div class="span-17 last">
             История Подробнее<br><br>
             Товары компании<br><br>
             Бренды компании<br><br>
             </div>
        
  
</div>
<div  class="span-1 last">
<?php $this->widget('CompanyControlPanel', array('id'=>$member->urlID));
 ?>
</div>