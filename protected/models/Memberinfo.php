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
     
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userID, avatar', 'required', 'on'=>'register'),
			array('userID', 'numerical', 'integerOnly'=>true, 'on'=>'register'),  
			array('avatar', 'length', 'max'=>20),
			
            array('userID, avatar, cityIsSet', 'required', 'on'=>'change'),
            array('website, phone, about, showEmail', 'safe', 'on'=>'change'),
            array('userID', 'numerical', 'integerOnly'=>true, 'on'=>'change'),  
            array('avatar', 'length', 'max'=>20, 'on'=>'change'), 
            
			array('image', 'file', 'types'=>'jpg, jpeg','maxSize' => 1000000, 'on'=>'change_avatar'),
			//array('image, userID, avatar, cityID', 'safe', 'on'=>'change_avatar'),    

			
			array('userID, avatar, cityID', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Members', 'userID'),
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
			'avatar' => 'Avatar',
			'cityID' => 'City',
			'image' => '',
			'website'=>'Сайт',
			'phone'=>'Телефон',
			'about'=>'Краткая информация',
			'showEmail'=>'Показывать Email',
		);
	}
    
    
    public function generateUniqueAvatarName() {  
                do {
                        mt_srand();
                        $id = mt_rand(10000000000, 99999999999);
                        $id.='.jpg';  
                        $results = Memberinfo::model()->findAll('avatar=:avatar', array(':avatar'=>$id));
                        $count = count ($results);
                } while ($count > 0);
                return $id;
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