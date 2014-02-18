<?php

/**
 * This is the model class for table "{{userStat}}".
 *
 * The followings are the available columns in table '{{userStat}}':
 * @property integer $id
 * @property string $ip
 * @property string $identity
 * @property string $date
 */
class UserStat extends CActiveRecord
{
    public $country;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserStat the static model class
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
		return '{{userStat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip, identity', 'required', 'on'=>'add'),
			array('ip', 'length', 'max'=>16 , 'on'=>'add'),
			array('identity', 'length', 'max'=>32 , 'on'=>'add'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ip, identity, date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ip' => 'Ip',
			'identity' => 'Identity',
			'date' => 'Date',
		);
	}
    /**Saves current date for new record before save Model
     * @return saved object
     */
    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $userInfo = json_decode(file_get_contents('http://ip-api.com/json/'.$this->ip));
                $this->date = new CDbExpression('DATE(NOW())');
                $this->country = $userInfo->country;
            }
            return true;
        } else
            return false;
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
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('identity',$this->identity,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}