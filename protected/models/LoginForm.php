<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $email;
	public $password;
	public $rememberMe;
        public $isCompany;
        
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Запомнить меня',
			'password' => 'Пароль',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
	      if(!$this->hasErrors())
		      {
			  $this->_identity=new UserIdentity($this->email,$this->password);
			  if($this->_identity->authenticate() == UserIdentity::ERROR_USERNAME_INVALID)
			      $this->addError('email','Непраильный Email.');
			  else if($this->_identity->authenticate() == UserIdentity::ERROR_PASSWORD_INVALID)
			      $this->addError('password','Неправильный пароль.');  
			  // Your Custom Error :)
				  else if($this->_identity->authenticate() == UserIdentity::ERROR_USERNAME_NOT_ACTIVE)
			      $this->addError('email', 'Ваш аккаунт еще не активен, пожалуйста, активируйте URL из вашего email и попробуйте снова войти.');
		      }
	}
 
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */

	public function login()
	{
		
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

    /**
     * Auth with vk login
     */
    public function loginVK($uid, $email, $login, $avatar = null)
    {
        $user = Member::model()->find('unique_id=:uid AND email=:email',array(':uid'=>$uid, 'email'=>$email));
        $number_of_rows = count($user);
        if ($number_of_rows > 0) {
            $this->email = $user->email;
            $this->password = $user->login;
            $logged = $this->login();
            if ($logged) {
                $response["success"] = true;
                $response["uid"] = $user->unique_id;
                $response["user"]["name"] = $user->login;
                $response["user"]["email"] = $user->email;
                $response["user"]["created_at"] = $user->date;
                $response["user"]["urlid"] =  $user->urlID;
            } else {
                $response["success"] = false;
            }
        } else {
            $uuid = $uid;
            $salt = 12345;
            $newUser = new Member;
            $newUser->scenario='vk';
            $newUser->login = $login;
            $newUser->unique_id = $uuid;
            $newUser->salt=$salt;
            $newUser->password = $login;
            $newUser->date = date("Y-m-d");
            $newUser->email = $uuid.'@vk.com';
            $newUser->role='user';
            $newUser->aktivation_key=1;
            $newUser->urlID=777777777777;
            $newUser->type=1;
            $newUser->activate_type=1;

            if($newUser->save()){
                $memberInfo = new Memberinfo();
                $memberInfo->setInitMemberInfo($newUser->id, 'vk');

                $newImage = null;
                if (!empty($avatar)) {
                    $ch = curl_init($avatar);
                    $newImage = Memberinfo::model()->generateUniqueAvatarName();

                    $fp = fopen(Yii::app()->baseUrl.'images/members/avatars/'.$newImage, 'wb');

                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_exec($ch);
                    curl_close($ch);

                    fclose($fp);

                    $setAva = Memberinfo::model()->findByPk($newUser->id);
                    $setAva->avatar = $newImage;
                    $setAva->save();
                }


                $this->email = $newUser->email;
                $this->password =  $newUser->login;
                $logged = $this->login();

                if ($logged) {
                    $userSaved = Member::model()->findbyPk($newUser->id);

                    $response["success"] = true;
                    $response["uid"] = $userSaved->unique_id;
                    $response["user"]["name"] = $userSaved->login;
                    $response["user"]["email"] = $userSaved->email;
                    $response["user"]["created_at"] = $userSaved->date;
                    $response["user"]["urlid"] =  $userSaved->urlID;
                } else {
                    $response["success"] = false;
                }
            }
        }
        return $response;
    }
}
