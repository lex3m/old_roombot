<?php

/**
 * This is the model class for table "{{memberCity}}".
 *
 * The followings are the available columns in table '{{memberCity}}':
 * @property integer $memberID
 * @property integer $cityID
 *
 * The followings are the available model relations:
 * @property Cities $city
 * @property Members $member
 */
class Membercity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Membercity the static model class
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
		return '{{memberCity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberID, cityID', 'required'),
			array('memberID, cityID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberID, cityID', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'Cities', 'cityID'),
			'member' => array(self::BELONGS_TO, 'Members', 'memberID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'memberID' => 'Member',
			'cityID' => 'City',
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

		$criteria->compare('memberID',$this->memberID);
		$criteria->compare('cityID',$this->cityID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}