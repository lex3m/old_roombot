<?php

/**
 * This is the model class for table "{{photoTags}}".
 *
 * The followings are the available columns in table '{{photoTags}}':
 * @property integer $id
 * @property integer $photoID
 * @property integer $coordX
 * @property integer $coordY
 * @property varchar $image_link
 * @property varchar $name
 * @property varchar $description
 * @property varchar $image
 * @property integer $price
 *
 * The followings are the available model relations:
 * @property MobilePictures $photo
 */
class Phototag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Phototag the static model class
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
		return '{{photoTags}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('photoID, coordX, coordY, name, description', 'required', 'on'=>'add'),
			array('photoID, coordX, coordY', 'numerical', 'integerOnly'=>true, 'on'=>'add'),

            array('name, description', 'required', 'on'=>'edit'),

            array('name', 'length', 'max'=>100, ),
            array('description', 'length', 'max'=>255),
            array('image_link', 'length', 'max'=>2048),

            array('image', 'file', 'types'=>'jpg, jpeg, png, gif','allowEmpty'=>true,'maxSize' => 1*1024*1024, 'tooLarge'=>'Файл не может превышать 1MB'),
            array('image_link', 'url'),
            array('price', 'numerical', 'integerOnly'=>true),
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
			'photo' => array(self::BELONGS_TO, 'MobilePictures', 'photoID'),
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
            'coordX'  => 'X coordinate',
            'coordY'  => 'Y coordinate',
            'image_link'  => Yii::t('sitePhotos', 'Link to product'),
            'image'  => Yii::t('sitePhotos', 'Image'),
            'name'  => Yii::t('sitePhotos', 'Tag name'),
            'description' => Yii::t('sitePhotos', 'Description'),
            'price'  => Yii::t('sitePhotos', 'Estimated price'),
		);
	}

    protected function beforeSave()
    {
        if (!parent::beforeSave())
            return false;

        if(($this->scenario=='add' || $this->scenario=='edit') &&
            ($image = CUploadedFile::getInstance($this, 'image'))){
                $this->deleteImage();
                $imageName = md5( Yii::app( )->user->id.microtime( ).$image->getName( ));
                $imageName .= ".".strtolower($image->getExtensionName( ));

                $this->image = $imageName;
                $image->saveAs($this->getFolder().$imageName);
        }

        return true;
    }

    protected function beforeDelete()
    {
        if (!parent::beforeDelete())
            return false;

        $this->deleteImage();
        return true;

    }


    protected function getFolder()
    {
        $folder = Yii::getPathOfAlias('webroot') . '/images/products/';
        if (is_dir($folder) == false)
            mkdir($folder, 0755, true);
        return $folder;
    }

    protected function deleteImage()
    {
        $documentPath=Yii::getPathOfAlias('webroot.').'/images/products' .DIRECTORY_SEPARATOR.
            $this->image;
        if(is_file($documentPath))
            unlink($documentPath);
    }

}