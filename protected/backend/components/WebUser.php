<?php
 
// this file must be stored in:
// protected/components/WebUser.php
 
class WebUser extends CWebUser {
 
  // Store model to not repeat query.
  private $_model;
 
  // Return first name.
  // access it by Yii::app()->user->first_name
  function getFirst_Name(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->first_name;
  }
 
  function getRole() {
        $user = $this->loadUser(Yii::app()->user->id); 
        return $user->role;
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = Member::model()->findByPk($this->id, array('select' => 'role'));
        }
        return $this->_model;
    }
  // This is a function that checks the field 'role'
  // in the User model to be equal to 1, that means it's admin
  // access it by Yii::app()->user->isAdmin()
  function isAdmin(){
    $user = $this->loadUser(Yii::app()->user->id);
    return intval($user->role) == 1;
  }
 
  // Load user model.
  protected function loadUser($id=null)
    {
        if($this->_model===null)
        {
            if($id!==null)
                $this->_model=Member::model()->findByPk($id);
        }
        return $this->_model;
    }
    
    function getUserRole(){
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user == NULL) {
            return FALSE;
        }
        return $user->role;
    }
}
