<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class FBUserIdentity extends CUserIdentity
{
    private $_id;
    private $_urlID;
    private $_isAuth = false;
    private $_states = array();

    public function __construct()
    {

    }
    
    public function authenticate($fbModel = null)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'unique_id=:uid';
        $criteria->params = array(':uid'=>$fbModel->id);
		$user = Member::model()->find($criteria);

		if( $user !== null ) {
			$this->_id = $user->id;
            $this->_urlID = $user->urlID;
        } else {
            /* Work with our Member and MemberInfo models */
            $newMember = new Member;
            $newMember->scenario = 'fbAuth';
            $newMember->unique_id = $fbModel->id;
            $newMember->save();

            $userParams = array(
                'first_name' => $fbModel->first_name,
                'last_name' => $fbModel->last_name,
                'picture' => $fbModel->picture,
            );

            $newMember->setInitMember($newMember->id, $userParams); //Set User data

            $memberInfo = new Memberinfo;
            $memberInfo->scenario = 'fbAuth';
            $memberInfo->userID = $newMember->id;
            $memberInfo->fio = $newMember->getFullName($fbModel->first_name, $fbModel->last_name);
            $memberInfo->avatar = $memberInfo->saveUserAvatar($fbModel->picture);
//            $memberInfo->avatar = 'user_da.gif';
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