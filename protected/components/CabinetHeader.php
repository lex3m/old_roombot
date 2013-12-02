<?php

class CabinetHeader extends CWidget {
   public $url_ID;
   
   public function init(){
     
   }
    
   public function run() { 
      $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$this->url_ID));
      $company = Companies::model()->findbyPk($member->id);
      $phones = CompanyPhones::model()->findAll('companyID=:companyID', array(':companyID'=>$member->id));
        $this->render('cabinetheader',array(
            'model'=>$company,
            'member'=>$member,
            'phones'=>$phones,
        ));    
   }
} 