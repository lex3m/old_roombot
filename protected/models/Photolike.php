<?php

/**
 * This is the model class for table "{{photoLike}}".
 *
 * The followings are the available columns in table '{{photoLike}}':
 * @property integer $id
 * @property integer $memberID
 * @property integer $photoID
 *
 * The followings are the available model relations:
 * @property MobilePictures $photo
 * @property Members $member
 */
class Photolike extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Photolike the static model class
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
		return '{{photoLike}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberID, photoID', 'required'),
			array('memberID, photoID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, memberID, photoID', 'safe', 'on'=>'search'),
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
			'photo' => array(self::BELONGS_TO, 'MobilePictures', 'photoID'),
			'member' => array(self::BELONGS_TO, 'Members', 'memberID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'memberID' => 'Member',
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
		$criteria->compare('memberID',$this->memberID);
		$criteria->compare('photoID',$this->photoID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}