<?php

/**
 * This is the model class for table "{{siteStatistic}}".
 *
 * The followings are the available columns in table '{{siteStatistic}}':
 * @property integer $id
 * @property string $date
 * @property string $hosts
 * @property integer $views
 */
class SiteStatistic extends CActiveRecord
{
    public $hosts;
    public $cnt;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SiteStatistic the static model class
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
		return '{{siteStatistic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('date, hosts, views', 'required',  'on'=>'add'),
            array('hosts, views', 'numerical', 'integerOnly'=>true, 'on'=>'add'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, views', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'views' => 'Views',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('views',$this->views);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->date=new CDbExpression('DATE(NOW())');
            $this->hosts = 1; //option by default
            $this->views = 1; //option by default
        }
        return parent::beforeSave();
    }

}