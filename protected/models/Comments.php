<?php

/**
 * This is the model class for table "{{comments}}".
 *
 * The followings are the available columns in table '{{comments}}':
 * @property integer $id
 * @property string $content
 * @property integer $memberID
 * @property string $dateTime
 * @property integer $photoID
 *
 * The followings are the available model relations:
 * @property Members $member
 * @property MobilePictures $photo
 */
class Comments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
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
		return '{{comments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, memberID, dateTime, photoID', 'required'),
			array('memberID, photoID', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content, memberID, dateTime, photoID', 'safe', 'on'=>'search'),
			  
            array('content, memberID, dateTime, photoID', 'required', 'on'=>'edit'),
            array('memberID, photoID', 'numerical', 'integerOnly'=>true, 'on'=>'edit'),
            array('content', 'length', 'max'=>255, 'on'=>'edit'),
            array('content', 'length', 'min'=>1, 'on'=>'edit'),  
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
			'member' => array(self::BELONGS_TO, 'Member', 'memberID'),
			'photo' => array(self::BELONGS_TO, 'MobilePictures', 'photoID'),
			'countlikes' => array(self::STAT, 'Commentlike', 'commentID','select' => 'COUNT(commentID)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Content',
			'memberID' => 'Member',
			'dateTime' => 'Date Time',
			'photoID' => 'Photo',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('memberID',$this->memberID);
		$criteria->compare('dateTime',$this->dateTime,true);
		$criteria->compare('photoID',$this->photoID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}