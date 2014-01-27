<?php

class MemberController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'ajaxOnly + addfollower',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('dashboard','view','addfollower', 'rmfollower'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','avatar','change', 'following' , 'followed', 'uploadUserPhotos', 'social'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionUploadUserPhotos()
    {
        Yii::import( "ext.xupload.models.XUploadForm" );
        //Here we define the paths where the files will be stored temporarily
        $path = realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg'] )."/";
        if (!is_dir($path.'/thumbs')) {
            mkdir($path.'/thumbs');
            chmod($path.'/thumbs', 0777);
        }
        $thumbsPath = realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg']."/thumbs/" )."/";

        $publicPath = Yii::app( )->getBaseUrl( )."/images/mobile/images/";
        $publicThumbsPath = Yii::app( )->getBaseUrl( )."/images/mobile/images/thumbs/";

        //This is for IE which doens't handle 'Content-type: application/json' correctly
        header( 'Vary: Accept' );
        if( isset( $_SERVER['HTTP_ACCEPT'] )
            && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
            header( 'Content-type: application/json' );
        } else {
            header( 'Content-type: text/plain' );
        }

        //Here we check if we are deleting and uploaded file
        if( isset( $_GET["_method"] ) ) {
            if( $_GET["_method"] == "delete" ) {
                if( $_GET["file"][0] !== '.' ) {
                    $file = $path.$_GET["file"];
                    if( is_file( $file ) ) {
                        unlink( $file );
                    }
                }
                echo json_encode( true );
            }
        } else {
            $model = new XUploadForm;
            $model->file = CUploadedFile::getInstance( $model, 'file' );
            //We check that the file was successfully uploaded
            if( $model->file !== null ) {
                //Grab some data
                $model->mime_type = $model->file->getType( );
                $model->size = $model->file->getSize( );
                $model->name = $model->file->getName( );
                //(optional) Generate a random name for our file
                $filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
                $filename .= ".".strtolower($model->file->getExtensionName( ));
                if( $model->validate( ) ) {
                    // For .gif do not need to resize image
                    if ($model->mime_type == 'image/gif') {
                        copy($model->file->getTempName(), $path.$filename);
                        chmod( $path.$filename, 0777 );
                        $resizedImage = true;
                        $resizedImageThumb = true;
                    } else {
                        //Move our file to our temporary dir
                        $model->file->saveAs( $path.$filename );
                        chmod( $path.$filename, 0777 );
                        //here you can also generate the image versions you need
                        //using something like PHPThumb
                        Yii::import('ext.image.Image');
                        $image = new Image($path.$filename);
                        //Rotate image if need
                        /*if($image->width < $image->height)
                            $image->rotate(270);*/
                        //Resize large pictures
                        if($image->width>1000)
                            $image->resize(1000, NULL);
                        $resizedImage = $image->save($path.$filename);

                        $image->resize(200,150);
                        $resizedImageThumb = $image->save($thumbsPath.$filename);
                        chmod( $thumbsPath.$filename, 0777 );
                    }

                    if ($resizedImage && $resizedImageThumb) {
                        $member = Member::model()->findByPk(Yii::app()->user->id);
                        $mobilePicture = new Mobilepictures('upload');
                        $mobilePicture->image = $filename;
                        $mobilePicture->name = ''; //'Фото пользователя '.$member->login;
                        $mobilePicture->date = date('Y-m-d');
                        $mobilePicture->companyID = $member->id;
                        if ($mobilePicture->save()) {
                            echo json_encode( array( array(
                                "name" => $model->name,
                                "type" => $model->mime_type,
                                "size" => $model->size,
                                "url" => $publicPath.$filename,
                                "thumbnail_url" => is_file($publicThumbsPath.$filename) ? $publicThumbsPath.$filename : $publicPath.$filename ,
                                "delete_url" => $this->createUrl( $this->action->id, array(
                                    "_method" => "delete",
                                    "file" => $filename
                                ) ),
                                "delete_type" => "POST"
                            ) ) );
                        } else {
                            echo json_encode( array(
                                array( "error" => $model->getErrors( 'upload' ),
                                ) ) );
                        }
                    }

                } else {
                    //If the upload failed for some reason we log some data and let the widget know
                    echo json_encode( array(
                        array( "error" => $model->getErrors( 'file' ),
                        ) ) );
                    Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
                        CLogger::LEVEL_ERROR, "ext.xupload.actions.XUploadAction"
                    );
                }
            } else {
                throw new CHttpException( 500, Yii::t('member', 'Upload failed') );
            }
        }
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
    
    public function actionChange()
    {

        $member = Member::model()->findbyPk(Yii::app()->user->id);
        $member->scenario='change';

        $memberinfo = Memberinfo::model()->findbyPk(Yii::app()->user->id);
        $memberinfo->scenario='change';

        if (isset($_POST['Member'])) {


            $member->attributes = $_POST['Member'];

            if ($member->validate()) {

                if($member->save()) {
                    if(isset($_POST['Memberinfo']))
                    {
                        $memberinfo->attributes=$_POST['Memberinfo'];
                        if ($memberinfo->validate()){
                            if ($memberinfo->save()){
                                Yii::app()->user->setFlash('success', Yii::t('member', Yii::t('member', 'Changes successfully saved.')));
                                $url=Yii::app()->createUrl('member/dashboard',array('id'=>$member->urlID));
                                $this->redirect($url);
                            }
                        }
                    }
                }
            }
        }

        $this->render('change',array(
            'memberinfo'=>$memberinfo,
            'member'=>$member,
        ));
    }
    
   
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Member;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Member']))
		{
			$model->attributes=$_POST['Member'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Member']))
		{
			$model->attributes=$_POST['Member'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionDashboard($id)
	{
        $this->setPageTitle(Yii::app()->name . ' - ' .Yii::t('member', 'Dashboard'));
        $member = Member::model()->with('memberinfo','countComments','countPhotos')->find('urlID=:id', array(':id'=>$id));

        //Get VK User friends and photos
        if (Yii::app()->user->hasState('vk_access_token')) {
//            $userFriends = AuthVKModel::getVkUserFriends(Yii::app()->user->getState('vk_access_token'));
            $userPhotos = AuthVKModel::getVkUserPhotos(Yii::app()->user->getState('vk_access_token'));
        }

        $memberCity =  Membercity::model()->with('city')->findbyPk($member->id);

        $pictures=Mobilepictures::model()->findAll('companyID=:id', array(':id'=>$member->id));

        $criteria = new CDbCriteria();
        $criteria->condition = 'memberID=:id';
        $criteria->params = array(':id'=>$member->id);
        $criteria->order = 't.id DESC';

        $following = MemberFollowers::model()->with('following')->findAll($criteria);

        $criteria = new CDbCriteria();
        $criteria->condition = 'followerID=:id';
        $criteria->params = array(':id'=>$member->id);
        $criteria->order = 't.id DESC';

        $followed = MemberFollowers::model()->with('followed')->findAll($criteria);

        Yii::import( "ext.xupload.models.XUploadForm" );
        $photos = new XUploadForm;
        $model = new Mobilepictures('add');

        $criteria = new CDbCriteria();
        $criteria->condition = 'companyID=:id';
        $criteria->params = array(':id'=>$member->id);
        $criteria->order ='id DESC';
        $dataProvider = new CActiveDataProvider(Mobilepictures::model()->with('taglinks','countComments'),
                array(
                    'criteria'=>$criteria,

                    'pagination'=>array(
                        'pageSize'=>12,
                    ),
                )
        );
        $this->render('dashboard',array(
                'photos'=>$photos,
                'member'=>$member,
                'following'=>$following,
                'followed'=>$followed,
                'pictures'=>$pictures,
                'model'=>$model,
                'dataProvider'=>$dataProvider,
                'memberCity'=>$memberCity,
                'userFriends' => isset($userFriends) ? $userFriends : '',
                'userPhotos' => isset($userPhotos) ? $userPhotos : '',
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Member('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Member']))
			$model->attributes=$_GET['Member'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    
    public function actionAvatar()
    {
        
        $member=Member::model()->with('memberinfo')->findbyPk(Yii::app()->user->id);
        $memberinfo = Memberinfo::model()->findbyPk(Yii::app()->user->id);
            $memberinfo->scenario = 'change_avatar';
        $oldImage = $memberinfo->avatar;
        if(isset($_POST['Memberinfo'])){  
            $memberinfo->attributes=$_POST['Memberinfo'];
            $memberinfo->image=CUploadedFile::getInstance($memberinfo,'image');
            $newImage = Memberinfo::model()->generateUniqueAvatarName(); 
            $memberinfo->avatar=$newImage;  
            if($memberinfo->validate())
                if($memberinfo->update()){     
                if ($oldImage!='user_da.gif')
                    unlink(Yii::app()->baseUrl.'images/members/avatars/'.$oldImage);
         
                $memberinfo->image->saveAs(Yii::app()->baseUrl.'images/members/avatars/'.$newImage);
                
                $this->refresh();
            }
        }  
       
        $this->render('avatar',array(
             'member'=>$member,  
             'memberinfo'=>$memberinfo,
        ));
    }

    public function actionAddfollower()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $follower = new MemberFollowers;
            if (isset($_POST['urlID']) && !empty($_POST['urlID'])) {
                $member = Member::model()->find('urlID=:id', array(':id'=>intval($_POST['urlID'])));
                $follower->memberID = Yii::app()->user->id;
                $follower->followerID = $member->id;
                if ($follower->save()) {
                    echo 1;
                }
            }
        }
    }

    public function actionRmfollower()
    {
        if(Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['urlID']) && !empty($_POST['urlID'])) {
                $member = Member::model()->find('urlID=:id', array(':id'=>intval($_POST['urlID'])));
                $follower = MemberFollowers::model()->find('memberID=:mid AND followerID=:fid', array(':mid'=>Yii::app()->user->id, ':fid'=>$member->id));
                if ($follower->delete()) {
                    echo 1;
                }
            }
        }
    }

    public function actionFollowing()
    {

//        $followers = MemberFollowers::model()->with('members')->findAll('memberID=:id', array(':id'=>Yii::app()->user->id));

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $member = Member::model()->find('urlID=:id', array(':id'=>intval($_GET['id'])));

        } else {
            $member = Member::model()->find('id=:id', array(':id'=>Yii::app()->user->id));
        }
        $id =  $member->id;
        $criteria = new CDbCriteria();
        $criteria->condition = 'memberID=:id';
        $criteria->params = array(':id'=>$id);
        $criteria->order = 't.id DESC';

        $following = MemberFollowers::model()->with('following')->findAll($criteria);


        $dataProvider = new CActiveDataProvider(MemberFollowers::model()->with('following'),
            array(
                'criteria'=>$criteria,

                'pagination'=>array(
                    'pageSize'=>12,
                ),
            )
        );

        $criteria = new CDbCriteria();
        $criteria->condition = 'followerID=:id';
        $criteria->params = array(':id'=>$id);
        $criteria->order = 't.id DESC';
        $followed = MemberFollowers::model()->with('followed')->findAll($criteria);

        $this->render('followers',array(
            'dataProvider'=>$dataProvider,
            'member'=>$member,
            'following'=>$following,
            'followed'=>$followed,
        ));

    }

    public function actionFollowed()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $member = Member::model()->find('urlID=:id', array(':id'=>intval($_GET['id'])));

        } else {
            $member = Member::model()->find('id=:id', array(':id'=>Yii::app()->user->id));
        }
        $id =  $member->id;
        $criteria = new CDbCriteria();
        $criteria->condition = 'followerID=:id';
        $criteria->params = array(':id'=>$id);
        $criteria->order = 't.id DESC';

        $followed = MemberFollowers::model()->with('followed')->findAll($criteria);

        $dataProvider = new CActiveDataProvider(MemberFollowers::model()->with('followed'),
            array(
                'criteria'=>$criteria,

                'pagination'=>array(
                    'pageSize'=>12,
                ),
            )
        );

        $id =  $member->id;
        $criteria = new CDbCriteria();
        $criteria->condition = 'memberID=:id';
        $criteria->params = array(':id'=>$id);
        $criteria->order = 't.id DESC';

        $following = MemberFollowers::model()->with('following')->findAll($criteria);

        $this->render('followers',array(
            'dataProvider'=>$dataProvider,
            'member'=>$member,
            'following'=>$following,
            'followed'=>$followed,
        ));

    }

    /**
     * linking with social accounts
     */
    public function actionSocial()
    {
        $memberinfo = Memberinfo::model()->findbyPk(Yii::app()->user->id);
        $memberinfo->scenario = 'social';
        if (isset($_POST['Memberinfo'])) {
            $memberinfo->attributes = $_POST['Memberinfo'];
            if ($memberinfo->validate()) {
                if ($memberinfo->save()){
                    Yii::app()->user->setFlash('success', Yii::t('member', Yii::t('member', 'Changes successfully saved.')));
                    $url=Yii::app()->createUrl('member/dashboard',array('id'=>$memberinfo->user->urlID));
                    $this->redirect($url);
                }
            }
        }

        $this->render('social', array(
            'memberinfo'=>$memberinfo,
        ));
    }
    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Member the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Member::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Member $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='member-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
