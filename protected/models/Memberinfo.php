<?php

/**
 * This is the model class for table "{{memberInfo}}".
 *
 * The followings are the available columns in table '{{memberInfo}}':
 * @property integer $userID
 * @property string $avatar
 * @property integer $cityID
 *
 * The followings are the available model relations:
 * @property Members $user
 * @property Cities $city
 */
class Memberinfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Memberinfo the static model class
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
		return '{{memberInfo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $image;
    public $showEmail;
    public $cityIsSet;
    public $website;
    public $phone;
    public $fio;
    public $avatar;

    public $vk;
    public $fb;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userID, avatar', 'required', 'on'=>'register'),
			array('userID', 'numerical', 'integerOnly'=>true, 'on'=>'register'),  
			array('avatar', 'length', 'max'=>20),
			
            array('userID, avatar, cityIsSet', 'required', 'on'=>'change'),
            array('website, phone, about, showEmail, fio', 'safe', 'on'=>'change'),
            array('userID', 'numerical', 'integerOnly'=>true, 'on'=>'change'),  
            array('avatar', 'length', 'max'=>20, 'on'=>'change'), 
            
			array('image', 'file', 'types'=>'jpg, jpeg','maxSize' => 1000000, 'on'=>'change_avatar'),

            array('avatar', 'length', 'max'=>20, 'on'=>'set_avatar'),
			//array('image, userID, avatar, cityID', 'safe', 'on'=>'change_avatar'),    

			
			array('userID, avatar, cityID', 'safe', 'on'=>'search'),

            array('userID, fio, avatar', 'required', 'on' => 'vkAuth'),
            array('userID', 'numerical', 'integerOnly'=>true, 'on'=>'vkAuth'),
            array('fio', 'length', 'max' => 255, 'on' => 'vkAuth'),

            array('userID, fio, avatar', 'required', 'on' => 'fbAuth'),
            array('userID', 'numerical', 'integerOnly'=>true, 'on'=>'fbAuth'),
            array('fio', 'length', 'max' => 255, 'on' => 'fbAuth'),

            array('vk, fb', 'url', 'on' => 'social'),
            array('vk, fb', 'unique', 'on' => 'social'),
            array('vk, fb', 'length', 'max' => 70, 'on' => 'social'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Member', 'userID'),
			'city' => array(self::BELONGS_TO, 'Cities', 'cityID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userID' => 'User',
			'avatar' => Yii::t('memberInfo', 'Avatar'),
			'cityIsSet' => 'Город',
			'website'=> Yii::t('memberInfo','Site'),
			'phone'=> Yii::t('memberInfo','Phone number'),
			'about'=> Yii::t('memberInfo','About'),
			'showEmail'=> Yii::t('memberInfo','Show email?'),
            'fio' => Yii::t('memberInfo', 'Full name'),
            'vk' => 'Vkontakte',
            'fb' => 'Facebook'
		);
	}
    
    
    public function generateUniqueAvatarName() {  
        do {
                mt_srand();
                $id = mt_rand(10000000000, 99999999999);
                $id.='.jpg';
                $results = $this->findAll('avatar=:avatar', array(':avatar'=>$id));
                $count = count ($results);
        } while ($count > 0);
        return $id;
    }

    /**
     * Use curl to save user vk avatar
     * @param $avatar
     * @return string saved avatar name
     */
    public function saveUserAvatar($avatar) {

        $img = file_get_contents($avatar);
        $ava  =  $this->generateUniqueAvatarName();
        $file = Yii::app()->baseUrl.'images/members/avatars/'.$ava;
        file_put_contents($file, $img);

        return $ava;
    }

    /**
     * Set default memberinfo
     */
    public function setInitMemberInfo($userID, $userEmail){
        $memberInfo = new Memberinfo('register');
        $memberInfo->userID = $userID;
        $memberInfo->avatar = "user_da.gif";
        $memberInfo->cityIsSet = 0;
        if ($memberInfo->save())
        {
            if (($userEmail!='vk')||($userEmail!='fb')){
                $email = Yii::app()->email;
                $email->to =  $userEmail;
                $email->from=Yii::app()->params['email'];
                $email->subject = Yii::t('member', 'Successful registration on ').' '.Yii::app()->name;
                $email->message = Yii::t('member', 'Thank you for your registering on site').' '."<a href=\"".Yii::app()->getBaseUrl(true)."\">".Yii::app()->getBaseUrl(true)."</a>." .Yii::t('member', 'Now you can see our actual news and add your photos!');
                $email->send();
            }
        }
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

		$criteria->compare('userID',$this->userID);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('cityID',$this->cityID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}