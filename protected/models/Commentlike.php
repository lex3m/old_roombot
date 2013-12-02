<?php

/**
 * This is the model class for table "{{commentLike}}".
 *
 * The followings are the available columns in table '{{commentLike}}':
 * @property integer $id
 * @property integer $memberID
 * @property integer $commentID
 *
 * The followings are the available model relations:
 * @property Comments $comment
 * @property Members $member
 */
class CommentLike extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommentLike the static model class
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
		return '{{commentLike}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberID, commentID', 'required'),
			array('memberID, commentID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, memberID, commentID', 'safe', 'on'=>'search'),
			
            array('memberID, commentID', 'required', 'on'=>'add'),
            array('memberID, commentID', 'numerical', 'integerOnly'=>true, 'on'=>'add'),  
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
			'comment' => array(self::BELONGS_TO, 'Comments', 'commentID'),
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
			'commentID' => 'Comment',
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
		$criteria->compare('commentID',$this->commentID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}