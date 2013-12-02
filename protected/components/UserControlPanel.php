<?php

class UserControlPanel extends CWidget {
   public function run() {
	  $member = Member::model()->findbyPk(Yii::app()->user->getId());
	  $user = Users::model()->findbyPk($member->id);
      $this->render('usercontrolpanel',array(
			'model'=>$user,
			'member'=>$member,
			));
   }
}
