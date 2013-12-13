<?php

/**
 * This is the model class for table "{{mobiletags}}".
 *
 * The followings are the available columns in table '{{mobiletags}}':
 * @property integer $id
 * @property integer $name
 */
class Mobiletags extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mobiletags the static model class
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
		return '{{mobiletags}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public $name;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
        'imagelinks'=>array(self::HAS_MANY, 'Mobilelinks', 'tagId'),
        );
    }


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
		);
	}

    /**
     * Make items for tag menu
     * @return array
     */
    public function getMenuList()
    {
        $items = array();

        $models = $this->findAll(array('order'=>'name ASC', 'limit'=>5));

        foreach ($models as $model)
        {
            $items[] = array(
                'label'=>$model->name,
                'url'=>Yii::app()->createUrl('site/photos', array('id'=>$model->id, 'name'=>$model->name_en)),
            );
        }

        $items2 = array() ;
        $count = $this->count();
        $tags= $this->findAll(array('order'=>'name ASC', 'limit'=>$count - 5, 'offset'=>5));

        foreach($tags as $tag) {
            $items2 [] = array('label'=>$tag->name, 'url'=>Yii::app()->createUrl('site/photos', array('id'=>$tag->id, 'name'=>$tag->name_en)));            
        }
        $items['items'] =  array('label'=>'Еще...', 'url'=>'#',
                                'items'=>$items2,                                
                            );

        return $items;
    }

    public static function getTagName($id)
    {
        $model = self::model()->findByPk($id);
        if ($model !== NULL) {
            return $model->name;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}