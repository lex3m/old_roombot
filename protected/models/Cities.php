<?php

/**
 * This is the model class for table "{{cities}}".
 *
 * The followings are the available columns in table '{{cities}}':
 * @property integer $id
 * @property integer $countryID
 * @property string $cityName
 *
 * The followings are the available model relations:
 * @property Countries $country
 * @property MemberInfo[] $memberInfos
 */
class Cities extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cities the static model class
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
		return '{{cities}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('countryID, cityName', 'required'),
			array('countryID', 'numerical', 'integerOnly'=>true),
			array('cityName', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, countryID, cityName', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Countries', 'countryID'),
			'memberInfos' => array(self::HAS_MANY, 'MemberInfo', 'cityID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'countryID' => 'Country',
			'cityName' => 'City Name',
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
		$criteria->compare('countryID',$this->countryID);
		$criteria->compare('cityName',$this->cityName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}