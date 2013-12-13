<?php

class CompanyControlPanel extends CWidget {
   public $id;
   
   public function init(){
      
   }
   
   public function run() {
       $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$this->id));
	 $company = Companies::model()->findbyPk($member->id);
      $this->render('companycontrolpanel',array(
			'company'=>$company,
			'member'=>$member,
			));
   }
} 