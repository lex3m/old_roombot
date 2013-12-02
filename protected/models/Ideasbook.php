<?php

/**
 * This is the model class for table "{{ideasBook}}".
 *
 * The followings are the available columns in table '{{ideasBook}}':
 * @property integer $id
 * @property string $name
 * @property integer $memberID
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Members $member
 */
class Ideasbook extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ideasbook the static model class
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
		return '{{ideasBook}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, memberID, date', 'required'),
			array('memberID', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			
            array('name, memberID, date', 'required', 'on'=>'add'),
            array('memberID', 'numerical', 'integerOnly'=>true, 'on'=>'add'),
            array('name', 'length', 'max'=>100, 'on'=>'add'),  
            array('description', 'length', 'max'=>255, 'on'=>'add'),
            
            array('name, memberID, date', 'required', 'on'=>'edit'),
            array('memberID', 'numerical', 'integerOnly'=>true, 'on'=>'edit'),
            array('name', 'length', 'max'=>100, 'on'=>'edit'),  
            array('description', 'length', 'max'=>255, 'on'=>'edit'),  
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, memberID, date', 'safe', 'on'=>'search'),
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
            'memberinfo' => array(self::BELONGS_TO, 'Memberinfo', 'memberID'),
            'ideaphotos' => array(self::HAS_MANY, 'Ideaphotos', 'ideaBooksID'),
			'countIdeaPhotos' => array(self::STAT, 'Ideaphotos', 'ideaBooksID','select' => 'COUNT(ideaBooksID)'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Имя',
			'memberID' => 'Member',
			'date' => 'Date',
			'description'=>'Описание',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('memberID',$this->memberID);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}