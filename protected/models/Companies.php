<?php

/**
 * This is the model class for table "{{companies}}".
 *
 * The followings are the available columns in table '{{companies}}':
 * @property integer $id
 * @property string $name
 * @property string $logo
 *
 * The followings are the available model relations:
 * @property CompanyInfo $companyInfo
 */
class Companies extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Companies the static model class
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
		return '{{companies}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $legal_name;
    public $rules;
    
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rules', 'required','on'=>'register'),
			array('name', 'safe','on'=>'register'),
			array('rules', 'agreeRules','on'=>'register'),
			array('logo', 'safe','on'=>'register'),
			array('name', 'length', 'max'=>255,'on'=>'register'),
			array('logo', 'length', 'max'=>100,'on'=>'register'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, logo', 'safe', 'on'=>'search'),
		);
	}
    
    public function agreeRules($attribute,$params){
    if($this->$attribute!= 1 ){
         $this->addError($attribute, 'Подвердите ваше согласие с Правилами пользования');
    }
   }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'companyInfo' => array(self::HAS_ONE, 'CompanyInfo', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Логин',
			'logo' => 'Logo',
			'rules'=>'Я согласен с Правилами пользования',
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
		$criteria->compare('logo',$this->logo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}