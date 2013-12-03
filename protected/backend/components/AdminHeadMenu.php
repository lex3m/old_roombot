<?php

class AdminHeadMenu extends CWidget {
   public $time;
   public function init(){
     
   }
    
   public function run() { 
        $this->render('adminheadmenu',array(
             'time'=>$this->time,
        ));    
   }
} 