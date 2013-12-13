<?php

class UsersController extends Controller
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
				'actions'=>array('index','view','register','registersuccess','activation','dashboard'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','profile','ads','photos','cv'),  
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
	
	
	public function actionRegister()
	{
		/*$model=new Member('register');
		$user = new Users('register'); 
		$activationKey = sha1(mt_rand(10000,99999).time().$model->email);
	        $model->aktivation_key=$activationKey;  
	        $model->role=1;    
		//$this->performAjaxValidation(array($user,$userInfo));  
		if(isset($_POST['Member'],$_POST['Users']))
		{   
		    // populate input data to $a and $b
		    $model->attributes=$_POST['Member'];
		    $user->attributes=$_POST['Users'];
	           
		    $valid=$model->validate();
		    if ($valid)  
		    $valid=$user->validate() && $valid;
		    if($valid)
		    {     
			// use false parameter to disable validation
			if ($model->save()) 
			{ 
			    $user->id=$model->id;
			    $user->avatar='avatar_default.jpg';
			    if ($user->save()) 
			    { 
					  $email = Yii::app()->email;
					  $email->to = $model->email;
					  $email->from=Yii::app()->params['email'];
					  $email->subject = "Поздравляем вас с регистрацией! ".Yii::app()->name;
					  $email->message = "Спасибо за регистрацию. Теперь вы можете отслеживать наши самые актуальные новости. Добавлять обьявления и фотографии и многое другое!";
					  if(!$email->Send()) {
					      
					  }else {
					      
					  } 
					  $activationLink = Yii::app()->createAbsoluteUrl('users/activation', array('act_key'=>$activationKey));   			   
					  $email = Yii::app()->email;
					  $email->to = $model->email;
					  $email->subject = "Активация аккаунта на Потолок-портал";
					  $email->from=Yii::app()->params['email'];
					  $email->message = "Спасибо за регистрацию. Пройдите по следующему адресу, чтобы активировать ваш аккаунт <a href=\"".$activationLink."\">".$activationLink."</a>";  
					  if(!$email->Send()) { 
					      Yii::app()->user->setFlash('register-success',"Произошел сбой отправки email на вашу почту. Пожалуйста повторите процедуру регистрации.");
					  }else {
					      Yii::app()->user->setFlash('register-success',"Спасибо за регистрацию. На указанный email было отправленно письмо для подтверждения регистрации!");
					  }
			    $this->redirect('Registersuccess'); 	
			    }  
			}
		    }
		}
		$this->render('register',array(
			'model'=>$model,
			'user'=>$user,
		));*/
		throw new CHttpException(404,'Страница находиться на стадии разработки'); 
	} 

	
	public function actionActivation($act_key)
	{
	      $user=Member::model()->find('aktivation_key=:key', array(':key'=>$act_key));
	      $user->scenario = "activation"; 
	      if (!isset($user->email))   
	      {
		throw new CHttpException(404,'The requested page does not exist.');
	      }
	      else
	      {
		$user->aktivation_key=1;  
		if ($user->update())
		  {     
		  }
	      } 
	      $this->render('activate-account',array());
	}
	  
	public function actionRegistersuccess()
	{
	
	      $this->render('registration-success-page',array()); 
	} 

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionDashboard($id)
	{
	        $member = Member::model()->findbyPk(Yii::app()->user->getId());
	        $user = Users::model()->findbyPk($member->id);
		$this->render('dashboard',array(
			'model'=>$user,
			'member'=>$member, 
		));
	}
	  
	
	public function actionProfile($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	        $user = Users::model()->findbyPk($member->id);
	        $userInfo = UserInfo::model()->findbyPk($member->id);
	        if (!isset($userInfo->userID)) 
	        { 
		    $userInfo = new UserInfo('register');
		    $userInfo->userID = $member->id; 
		    $userInfo->save();
	        }
	        $userInfo->scenario='edit';
	        if(isset($_POST['UserInfo']))
		{   
		    $userInfo->attributes=$_POST['UserInfo'];
		    $userInfo->userID = $member->id;
		    if($userInfo->validate())
		    {     
			// use false parameter to disable validation
			if ($userInfo->update()) 
			{
			
			}
		    }
		} 
		$this->render('profile',array(
			'model'=>$user,
			'member'=>$member, 
			'userInfo'=>$userInfo,
		));
	}
	
	
	public function actionAds($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	        $user = Users::model()->findbyPk($member->id);
		$this->render('ads',array(
			'model'=>$user,
			'member'=>$member, 
		));
	}
	
	
	public function actionPhotos($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	        $user = Users::model()->findbyPk($member->id);
		$this->render('photos',array(
			'model'=>$user,
			'member'=>$member, 
		));
	}
	
	public function actionCv($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	        $user = Users::model()->findbyPk($member->id);
		$this->render('cv',array(
			'model'=>$user,
			'member'=>$member, 
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

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
