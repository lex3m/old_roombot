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
				'actions'=>array('create','update','avatar','change', 'following' , 'followed'),
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
        $memberinfo = Memberinfo::model()->findbyPk(Yii::app()->user->id);
        $memberinfo->scenario='change';
        if(isset($_POST['Memberinfo']))
        {
            $memberinfo->attributes=$_POST['Memberinfo'];
            if($memberinfo->validate())
                if($memberinfo->save()){
                    Yii::app()->user->setFlash('success', "Изменения успешно сохранены.");
                    $url=Yii::app()->createUrl('member/dashboard',array('id'=>$member->urlID));
                    $this->redirect($url);
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
		$this->setPageTitle('Roombot - Кабинет');    
          $member = Member::model()->with('memberinfo','countComments','countPhotos')->find('urlID=:id', array(':id'=>$id));
          $memberCity =  Membercity::model()->with('city')->findbyPk($member->id);  
          $pic_arr=array();
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


        $model = new Mobilepictures('add');
          if (isset($_POST['Mobilepictures'])) {
                $model->attributes = $_POST['Mobilepictures'];
                $img=CUploadedFile::getInstance($model,'img');
                $model->img=$img;
                $model->image = $img;
                $model->date=date('Y-m-d');
                $model->companyID=$member->id;
                if ($model->validate()) 
                {
                    $model->image = $img->name;
                    $userfile_extn = substr($model->image, strrpos($model->image, '.')+1); 
                    $model->image = Mobilepictures::generateUniqueName($userfile_extn);
                    if ($model->save())   
                    {
                         $model->img->saveAs(Yii::getPathOfAlias('webroot').'/images/mobile/images/'.$model->image);
                         
                         Yii::app()->user->setFlash('success', "Изображение было успешно добавлено.");
                       //  $url = Yii::app()->createUrl('news/view',array('id'=>$model->urlID));
                         $this->refresh();
                    }
                }
          }
                
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
                'member'=>$member,
                'following'=>$following,
                'followed'=>$followed,
                'pictures'=>$pictures,
                'model'=>$model,
                'dataProvider'=>$dataProvider,
                'memberCity'=>$memberCity ));
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
