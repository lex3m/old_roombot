<?php

/**
 * This is the model class for table "{{members}}".
 *
 * The followings are the available columns in table '{{members}}':
 * @property integer $id
 * @property string $password
 * @property integer $role
 * @property string $aktivation_key
 * @property string $salt
 * @property string $email
 * @property string $unique_id
 * The followings are the available model relations:
 * @property UserInfo $userInfo
 */
class Member extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Member the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{members}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	 
	public $password_repeat; 
	public $email;
	public $aktivation_key;  
	public $urlID;
	public $countphotos;
    public $rulles;
    public $unique_id;

    public $role;
    public $type;
    public $activate_type;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, password, role, aktivation_key, salt, email', 'safe', 'on'=>'search'),

            array('rulles', 'required','requiredValue' => 1, 'message' => 'Вы должны принять правила сайта', 'on'=>'register'),
			
			array('password, type, password_repeat, role, aktivation_key, email, date, login, rulles', 'required', 'on'=>'register'),
			array('type', 'numerical', 'integerOnly'=>true, 'on'=>'register'),
			array('password, aktivation_key', 'length', 'max'=>255, 'on'=>'register'),
			array('login', 'length', 'max'=>50, 'on'=>'register'),
			array('login', 'length', 'min'=>6, 'on'=>'register'),
			array('login',  'unique', 'on'=>'register'),  
			array('email', 'length', 'max'=>50, 'on'=>'register'),
            array('password, password_repeat', 'length', 'min' => 6,'max'=>25, 'on'=>'register'),
			array('password','length','min'=>6,'message'=>'Minimum 6 characters', 'on'=>'register'),
			array('password', 'compare' , 'compareAttribute' => 'password_repeat','on'=>'register'),
			array('email','unique', 'on'=>'register'), 
			array('email','email', 'on'=>'register'),
			array('urlID','safe', 'on'=>'register'),

            array('login, email', 'required', 'on'=>'change'),
            array('login, email', 'length', 'max'=>50, 'on'=>'change'),
            array('login, email',  'unique', 'on'=>'change'),
            array('login', 'length', 'min'=>6, 'on'=>'change'),
            array('email', 'email', 'on'=>'change'),
            array('password, role, aktivation_key, salt, urlID, type, activate_type, date, unique_id', 'safe', 'on'=>'change'),

            array('aktivation_key', 'safe', 'on'=>'activation'),
			 
			//когда посылаем email
            array('password, type, activate_type, password, role, email, urlID, salt, aktivation_key', 'safe', 'on'=>'changing_password'),
            
            //когда задаем новый пароль
            array('password, password_repeat', 'required', 'on'=>'changing_password2'),
            array('type, salt, role, email, urlID, aktivation_key', 'safe', 'on'=>'changing_password2'),
            array('password','length','min'=>6,'message'=>'Minimum 6 characters', 'on'=>'changing_password2'),
            array('password', 'compare' , 'compareAttribute' => 'password_repeat','on'=>'changing_password2'),

            //авторизация через соцсети в мобильном приложении
            array('urlID, activate_type, role, email, aktivation_key,  type, unique_id, login, password, date, salt', 'required', 'on'=>'vk'),
            array('unique_id','unique', 'on'=>'vk'),
            array('password', 'length', 'max'=>50, 'on'=>'vk'),
            array('unique_id, login', 'length', 'max'=>50, 'on'=>'vk'),
            array('password', 'length', 'max'=>80, 'on'=>'vk'),

            array('urlID, activate_type, role, email, aktivation_key,  type, unique_id, login, password, date, salt', 'required', 'on'=>'facebook'),
            array('unique_id','unique', 'on'=>'facebook'),
            array('email','email', 'on'=>'facebook'),
            array('password', 'length', 'max'=>50, 'on'=>'facebook'),
            array('unique_id, login', 'length', 'max'=>50, 'on'=>'facebook'),
            array('password', 'length', 'max'=>80, 'on'=>'facebook'),

            array('urlID, activate_type, role, email, aktivation_key,  type, unique_id, login, password, date, salt', 'required', 'on'=>'mobile_via_email'),
            array('unique_id','unique', 'on'=>'mobile_via_email'),
            array('email','email', 'on'=>'mobile_via_email'),
            array('password', 'length', 'max'=>50, 'on'=>'mobile_via_email'),
            array('unique_id, login', 'length', 'max'=>50, 'on'=>'mobile_via_email'),
            array('password', 'length', 'max'=>80, 'on'=>'mobile_via_email'),

            //правила для авторизации через ВК
            array('unique_id','required', 'on'=>'vkAuth'),
            array('unique_id','unique', 'on'=>'vkAuth'),
            array('unique_id', 'length', 'max'=>50, 'on'=>'vkAuth'),

            //правила для авторизации через FB
            array('unique_id','required', 'on'=>'fbAuth'),
            array('unique_id','unique', 'on'=>'fbAuth'),
            array('unique_id', 'length', 'max'=>50, 'on'=>'fbAuth'),
		);  
	}

    public function onAfterConstruct() {

    }
	
	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}

	// Создание хэша пароля
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}

	/**
	 * Generates a salt that can be used to generate a password hash.
	 * @return string the salt
	 */
	public function generateSalt()
	{
		return uniqid('',true);
	}

    /**
     * Generate a random password for users from social networks
     * @param int $length password length
     * @return string random password
     */
    public function generateRandomPassword($length = 7)
    {
        $chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
        shuffle($chars);
        $password = implode(array_slice($chars, 0, $length));
        return $password;
    }

    /**
     * Make full name for user
     * @param $firstName
     * @param $lastName
     * @return string
     */
    public function getFullName($firstName, $lastName)
    {
        return $firstName . ' ' . $lastName;
    }

    /**
     * @return string current date
     */
    public function getCurrentDate()
    {
        return date("Y-m-d");
    }

    /**
     * Make a translit for user login
     * @param $str
     * @return string
     */
    public function translit($str) {
        $translit = array(
            'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ё' => 'yo', 'Ж' => 'zh', 'З' => 'z',
            'И' => 'i', 'Й' => 'i', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r',
            'С' => 's', 'Т' => 't', 'У' => 'u', 'Ф' => 'f', 'Х' => 'h', 'Ц' => 'ts', 'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'sch',
            'Ъ' => '', 'Ы' => 'y', 'Ь' => '', 'Э' => 'e', 'Ю' => 'yu', 'Я' => 'ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            ' ' => '-', '!' => '', '?' => '', '('=> '', ')' => '', '#' => '', ',' => '', '№' => '',' - '=>'-','/'=>'-', '  '=>'-',
            'A' => 'a', 'B' => 'b', 'C' => 'c', 'D' => 'd', 'E' => 'e', 'F' => 'f', 'G' => 'g', 'H' => 'h', 'I' => 'i', 'J' => 'j', 'K' => 'k', 'L' => 'l', 'M' => 'm', 'N' => 'n',
            'O' => 'o', 'P' => 'p', 'Q' => 'q', 'R' => 'r', 'S' => 's', 'T' => 't', 'U' => 'u', 'V' => 'v', 'W' => 'w', 'X' => 'x', 'Y' => 'y', 'Z' => 'z'
        );
        return strtr($str, $translit);
    }

	protected function beforeSave()
	{
	    if(parent::beforeSave())
	    {
            if($this->isNewRecord || $this->scenario == 'initMember')
            {
                $salt = self::generateSalt();
                $this->password = self::hashPassword($this->password, $salt);
                $this->salt = $salt;
                $this->urlID = $this->generateUrlID();
            }
                return true;
	    }
	    else
		    return false;
	}

    /**
     * @return int url id
     */
    public function generateUrlID() {
        do {
            mt_srand();
            $id = mt_rand(100000000, 999999999);
            $results = $this->findAll('urlID=:urlID', array(':urlID'=>$id));
            $count = count ( $results );
        } while ($count > 0);
        return $id;
    }


    /**
     * Set default values for register member from social networks
     * @param $id
     * @param $params array of user params
     * @return bool
     */
    public function setInitMember($id, $params)
    {
        $user = $this->findByPk($id);
        $user->scenario = 'initMember';

        if (!empty($params)) {
            $user->login          = $this->translit($params['last_name']) . $user->unique_id;
            $user->password       = $this->generateRandomPassword();
            $user->date           = $this->getCurrentDate();
        }

        $user->role = 'user';
        $user->aktivation_key = 1;
        $user->type = 1;
        $user->activate_type = 1;
        $user->save();
        return true;
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'memberinfo' => array(self::HAS_ONE, 'Memberinfo', 'userID'),
            'comments'=>array(self::HAS_MANY, 'Comments', 'memberID',  'limit'=>5, 'order'=>'comments.dateTime DESC'),
            'photos'=>array(self::HAS_MANY, 'Mobilepictures', 'companyID', 'limit'=>5, 'order'=>'photos.id DESC'),
			'countComments' => array(self::STAT, 'Comments', 'memberID','select' => 'COUNT(memberID)'), 
			'countPhotos' => array(self::STAT, 'Mobilepictures', 'companyID','select' => 'COUNT(companyID)'),
            'countFollowing' => array(self::STAT, 'MemberFollowers', 'memberID', 'select' => 'COUNT(memberID)'),
            'countFollowed' => array(self::STAT, 'MemberFollowers', 'followerID', 'select' => 'COUNT(followerID)'),
		);   
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(  
			'id' => 'ID',
			'password' => 'Пароль',
			'password_repeat' => 'Повторите пароль',
			'role' => 'Role',
			'aktivation_key' => 'Aktivation Key',
			'salt' => 'Salt',
			'email' => 'Email',
			'date' => 'Дата регистрации',
			'login' => 'Логин',
            'rules'=>'Правила пользования'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('aktivation_key',$this->aktivation_key,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}