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
 *
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
    //public $id;
	
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
			array('login', 'length', 'max'=>25, 'on'=>'register'),
			array('login', 'length', 'min'=>6, 'on'=>'register'),
			array('login',  'unique', 'on'=>'register'),  
			array('email', 'length', 'max'=>50, 'on'=>'register'),   array('password, password_repeat', 'length', 'min' => 6,'max'=>25),  
			array('password','length','min'=>6,'message'=>'Minimum 6 characters', 'on'=>'register'),
			array('password', 'compare' , 'compareAttribute' => 'password_repeat','on'=>'register'),
			array('email','unique', 'on'=>'register'), 
			array('email','email', 'on'=>'register'),
			array('urlID','safe', 'on'=>'register'),
			
			array('aktivation_key', 'safe', 'on'=>'activation'),  
			 
			//когда посылаем email
            array('password, type, activate_type, password, role, email, urlID, salt, aktivation_key', 'safe', 'on'=>'changing_password'),
            
            //когда задаем новый пароль
            array('password, password_repeat', 'required', 'on'=>'changing_password2'),
            array('type, salt, role, email, urlID, aktivation_key', 'safe', 'on'=>'changing_password2'),
            array('password','length','min'=>6,'message'=>'Minimum 6 characters', 'on'=>'changing_password2'),
            array('password', 'compare' , 'compareAttribute' => 'password_repeat','on'=>'changing_password2'),  
		);  
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
	
	
	protected function beforeSave()
	{
	    if(parent::beforeSave())
	    {
		if($this->isNewRecord)
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
	
	public function generateUrlID() {
                do {
                        mt_srand();
                        $id = mt_rand(100000000, 999999999);
                        $results = Member::model()->findAll('urlID=:urlID', array(':urlID'=>$id));
                        $count = count ( $results );
                } while ($count > 0);
                return $id;
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