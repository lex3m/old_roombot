<?php

/**
 * This is the model class for table "{{ideasPhotos}}".
 *
 * The followings are the available columns in table '{{ideasPhotos}}':
 * @property integer $id
 * @property integer $photoID
 * @property integer $memberID
 */
class Ideaphotos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ideaphotos the static model class
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
		return '{{ideasPhotos}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('photoID, ideaBooksID', 'required','on'=>'add'),
			array('photoID, ideaBooksID', 'numerical', 'integerOnly'=>true,'on'=>'add'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, photoID, memberID', 'safe', 'on'=>'search'),
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
            'ideabooks' => array(self::BELONGS_TO, 'Ideasbook', 'ideaBooksID'),
            'ideaphotos' => array(self::BELONGS_TO, 'Mobilepictures', 'photoID'),
            'countComments' => array(self::STAT, 'Comments', 'photoID','select' => 'COUNT(photoID)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'photoID' => 'Photo',
			'memberID' => 'Member',
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
		$criteria->compare('photoID',$this->photoID);
		$criteria->compare('memberID',$this->memberID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}