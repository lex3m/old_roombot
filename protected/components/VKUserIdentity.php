<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class VKUserIdentity extends CUserIdentity
{
    private $_id;
    private $_urlID;
    private $_isAuth = false;
    private $_states = array();

    public function __construct()
    {

    }
    
    public function authenticate($vkModel = null)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'unique_id=:uid';
        $criteria->params = array(':uid'=>$vkModel->uid);
		$user = Member::model()->find($criteria);

		if( $user !== null ) {
			$this->_id = $user->id;
            $this->_urlID = $user->urlID;
        } else {
            /* Work with our Member and MemberInfo models */
            $newMember = new Member;
            $newMember->scenario = 'vkAuth';
            $newMember->unique_id = $vkModel->uid;
            $newMember->save();

            $userParams = array(
                'first_name' => $vkModel->first_name,
                'last_name' => $vkModel->last_name,
                'photo_big' => $vkModel->photo_big,
            );

            $newMember->setInitMember($newMember->id, $userParams); //Set User data

            $memberInfo = new Memberinfo;
            $memberInfo->scenario = 'vkAuth';
            $memberInfo->userID = $newMember->id;
            $memberInfo->fio = $newMember->getFullName($vkModel->first_name, $vkModel->last_name);
            $memberInfo->avatar = $memberInfo->saveUserAvatar($vkModel->photo_big);
            $memberInfo->save();
            /* End work with models */

            $this->_id = $newMember->id;
            $this->_urlID = $newMember->urlID;
		}
        $this->_isAuth = true;

		return true;
	}
 
    public function getId()
    {
        return $this->_id;
    }
      
    public function getUrlID()
    {
        return $this->_urlID;
    }

    public function getPersistentStates()
    {
        return $this->_states;
    }
}