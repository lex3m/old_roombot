<?php

/**
 * This is the model class for table "{{memberFollowers}}".
 *
 * The followings are the available columns in table '{{memberFollowers}}':
 * @property integer $id
 * @property integer $memberID
 * @property integer $followerID
 */
class MemberFollowers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberFollowers the static model class
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
		return '{{memberFollowers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberID, followerID', 'required'),
			array('memberID, followerID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, memberID, followerID', 'safe', 'on'=>'search'),
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
            'following' => array(self::BELONGS_TO, 'Member', 'followerID'),
            'followed' => array(self::BELONGS_TO, 'Member', 'memberID'),
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
			'followerID' => 'Follower',
		);
	}

    public static function checkFollower($id) {
        $criteria = new CDbCriteria();
        $criteria->condition = 'memberID=:mid AND followerID=:fid';
        $criteria->params = array(':mid'=>Yii::app()->user->id, ':fid'=>$id);
        if (self::model()->exists($criteria)) {
            return true;
        } else {
            return false;
        }
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('memberID',$this->memberID);
		$criteria->compare('followerID',$this->followerID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}