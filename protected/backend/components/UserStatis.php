<?php
class UserStatis extends CWidget {
   public $pageSize = 50;

   public function run() {
       $criteria=new CDbCriteria(array(
           'select'=>'DISTINCT(id), ip,date,country',
           'order'=>'date DESC',
       ));
	  $users = new CActiveDataProvider('UserStat',  array(
          'pagination'=>array(
              'pageSize'=> $this->pageSize,
          ),
          'criteria'=>$criteria,
          )
      );
      $this->render('userstat', array('users'=>$users));
   }
}
