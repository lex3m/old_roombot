<?php

/**
 * This is the model class for table "{{mobilePictures}}".
 *
 * The followings are the available columns in table '{{mobilePictures}}':
 * @property integer $id
 * @property string $name
 * @property string $info
 * @property string $date
 * @property string $image
 */
class Mobilepictures extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mobilepictures the static model class
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
		return '{{mobilePictures}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $img, $memberEmail;  
    
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date, image, companyID', 'required','on'=>'add'),
			array('info', 'safe','on'=>'add'),
			array('name', 'length', 'max'=>50,'on'=>'add'),
			array('info, image', 'length', 'max'=>100,'on'=>'add'),
			array('img', 'file', 'types'=>'jpg, jpeg, png','allowEmpty'=>false,'on'=>'add'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, info, date, image', 'safe', 'on'=>'search'),
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
		'taglinks'=>array(self::HAS_MANY, 'Mobilelinks', 'imageId'),
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
			'info' => 'Информация',
			'date' => 'Дата',
			'image' => 'Файл',
			'img'=>'Фотография',
		);
	}
    
    
    public function generateUniqueName($extension) {  
                do {
                        mt_srand();
                        $id = mt_rand(10000000000, 99999999999);
                        $id.='.'.$extension;
                        $results = Mobilepictures::model()->findAll('image=:image', array(':image'=>$id));
                        $count = count ( $results );
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}