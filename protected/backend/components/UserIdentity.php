<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    public $email;
    const ERROR_USERNAME_NOT_ACTIVE = 3; 
    
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
    
    public function authenticate()
      {          
		$user=Member::model()->find('LOWER(email)=?',array(strtolower($this->email)));
		if($user===null)
			{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			
			} 
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
	        else if($user->aktivation_key!=1) 
	               $this->errorCode=self::ERROR_USERNAME_NOT_ACTIVE;
		else
		{
			$this->_id=$user->id;
			$this->email=$user->email;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode;
	}
 
    public function getId()
    {
        return $this->_id;
    }
}