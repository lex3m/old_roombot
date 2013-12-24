<?php

class CompaniesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
     * 
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
				'actions'=>array('pricelists','index','view','register','registersuccess','activation','dashboard','profile','news','tenders','consultants',
				'vacancies','offers','albums','products','add_product'),    
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'), 
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
	
	public function actionDashboard($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	        $company = Companies::model()->findbyPk($member->id);
		$this->render('dashboard',array(
			'model'=>$company,
			'member'=>$member,
		));
	}
	
	
	
	
	
	
	
	public function actionProfile($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id)); 
	        $company = Companies::model()->findbyPk($member->id);
            $phones = CompanyPhones::model()->findAll('companyID=:companyID', array(':companyID'=>$member->id));
            $companyInfo = CompanyInfo::model()->findbyPk($member->id);
		$this->render('profile',array(
			'model'=>$company,
			'member'=>$member,
			'phones'=>$phones,
			'companyInfo'=>$companyInfo,
		));
	}
	
	
	public function actionNews($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	        $company = Companies::model()->findbyPk($member->id);

            
            $criteria = new CDbCriteria();
            $criteria->condition = 'companyID=:id';
            $criteria->params = array(':id'=>$member->id);
            $criteria->order ='id DESC';
        
        
            $news = new CActiveDataProvider(News::model(), 
                    array(
                        'criteria'=>$criteria,
                        
                        'pagination'=>array(
                            'pageSize'=>12,
                        ),
                    )
            );
		$this->render('news',array(
			'company'=>$company,
			'member'=>$member,
			'news'=>$news,
		));
	}
	
	public function actionPricelists($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	        $company = Companies::model()->findbyPk($member->id);
            $phones = CompanyPhones::model()->findAll('companyID=:companyID', array(':companyID'=>$member->id));
            $criteria = new CDbCriteria();
            $criteria->condition = 'companyID=:id';
            $criteria->params = array(':id'=>$member->id);
            $criteria->order ='id DESC';
        
        
            $pricelists = new CActiveDataProvider(Pricelists::model(), 
                    array(
                        'criteria'=>$criteria,
                        
                        'pagination'=>array(
                            'pageSize'=>12,
                        ),
                    )
            );
		$this->render('pricelists',array(
			'model'=>$company,
			'member'=>$member,
			'phones'=>$phones,
			'pricelists'=>$pricelists,
		));
	}

    public function actionTenders($id)
    {
            $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
            $company = Companies::model()->findbyPk($member->id);
            $phones = CompanyPhones::model()->findAll('companyID=:companyID', array(':companyID'=>$member->id));
            $criteria = new CDbCriteria();
            $criteria->condition = 'companyID=:id';
            $criteria->params = array(':id'=>$member->id);
            $criteria->order ='id DESC';
        
        
            $tenders = new CActiveDataProvider(Tenders::model()->with('tenderskindceilings'), 
                    array(
                        'criteria'=>$criteria,
                        
                        'pagination'=>array(
                            'pageSize'=>12,
                        ),
                    )
            );
        $this->render('tenders',array(
            'company'=>$company,
            'member'=>$member,
            'phones'=>$phones,
            'tenders'=>$tenders,
        ));
    }
	
    
	
	public function actionConsultants($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
            $company = Companies::model()->findbyPk($member->id);

            
            $criteria = new CDbCriteria();
            $criteria->condition = 'companyID=:id';
            $criteria->params = array(':id'=>$member->id);
            $criteria->order ='id DESC';
            $criteria = new CDbCriteria;
            $criteria->alias = 'c'; 
            $criteria->select = 'fullName, block, m.urlID as urlID, companyID'; 
            $criteria->join = 'LEFT JOIN `'.Member::model()->tableSchema->name.'` AS `m` ON `c`.`id` = `m`.`id`';
            $criteria->order = 'c.id DESC';
            
            $consultants = new CActiveDataProvider(Consultants::model()->with('subbrancheslinks'), 
                    array(
                         'criteria'   => $criteria,
                         'pagination' => array(
                             'pageSize' => 12,
                         )
                    )
            );  
            
            
        $this->render('consultants',array(
            'company'=>$company,
            'member'=>$member,
            'consultants'=>$consultants,
        ));   
	}
	
	
	public function actionVacancies($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
            $company = Companies::model()->findbyPk($member->id);
            
            $criteria = new CDbCriteria();
            $criteria->condition = 'companyID=:id';
            $criteria->params = array(':id'=>$member->id);
            $criteria->order ='id DESC';
            $vacancies = new CActiveDataProvider(Vacancies::model(), 
                    array(
                        'criteria'=>$criteria,
                        
                        'pagination'=>array(
                            'pageSize'=>12,
                        ),
                    )
            );
            
		$this->render('vacancies',array(
		    'vacancies'=>$vacancies,
			'company'=>$company,
			'member'=>$member,
		));
	}
	
	
	public function actionOffers($id)
	{
	        $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
            $company = Companies::model()->findbyPk($member->id);
            
            $criteria = new CDbCriteria();
            $criteria->condition = 'companyID=:id';
            $criteria->params = array(':id'=>$member->id);
            $criteria->order ='id DESC';
            $offers = new CActiveDataProvider(Offers::model()->with('subceilinglinks'), 
                    array(
                        'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>12,
                        ),
                    )
            );
            
        $this->render('offers',array(
            'offers'=>$offers,
            'company'=>$company,
            'member'=>$member,
        ));
	}
	
	
	public function actionAlbums($id)
	{
	    $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	    $company = Companies::model()->findbyPk($member->id);

            
            
        $criteria = new CDbCriteria();
        $criteria->condition = 'companyID=:id';
        $criteria->params = array(':id'=>$member->id);
        $criteria->order ='id DESC';
    
    
        $dataProvider = new CActiveDataProvider(Albums::model()->with('companiesphotos'), 
                array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>12,
                    ),
                )
        );
		$this->render('albums',array(
			'company'=>$company,
			'member'=>$member,
			'albums'=>$dataProvider,  
		));
	} 
	
	public function actionProducts($id)
	{
	       $member = Member::model()->find('urlID=:urlID', array(':urlID'=>$id));
	        $company = Companies::model()->findbyPk($member->id);
            $products= Products::model()->findAll('companyID=:id', array(':id'=>$member->id));
            
    $criteria = new CDbCriteria();
    $criteria->condition = 'companyID=:id';
    $criteria->params = array(':id'=>$member->id);
    $criteria->order ='id DESC';


    $dataProvider = new CActiveDataProvider(Products::model()->with('productsphotos','productskindceilings'), 
            array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>12,
                ),
            )
    );
    
         //   $productsphotos=Productsphotos::model()->findAll('productsID=:id', array(':id'=>$products[0]->id));
		$this->render('products',array(
			'model'=>$company,
			'member'=>$member,
			'products'=>$products,
			'dataProvider'=>$dataProvider,
		));
	} 
    
    public function actionAdd_products()
    {
        $dataProvider=new CActiveDataProvider('CompanyProducts');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }
    
	
	 
	
	
	
	
	
	public function actionRegister()
	{
	    $this->setPageTitle(Yii::app()->name . ' - Регистрация');
		$model=new Member('register');
        $memberinfo = new Memberinfo('register');
		$activationKey = sha1(mt_rand(10000,99999).time().$model->email);
	        $model->aktivation_key=$activationKey;  
	        $model->role="user";   
            $model->type=1;  
		//$this->performAjaxValidation(array($user,$userInfo));  
		if(isset($_POST['Member']))
		{  
		    // populate input data to $a and $b
		    $model->attributes=$_POST['Member'];
            $model->date=date('Y-m-d');
            
    	    if($model->validate())
		    {       
			// use false parameter to disable validation
			if ($model->save()) 
			{

			   $memberinfo->userID = $model->id;  
               $memberinfo->avatar = "user_da.gif";
               $memberinfo->cityIsSet = 0;
               if ($memberinfo->validate())
	             if ($memberinfo->save()) 
                    {
					  $email = Yii::app()->email;
					  $email->to = $model->email;
					  $email->from=Yii::app()->params['email'];
					  $email->subject = "Поздравляем вас с регистрацией! ".Yii::app()->name;
					  $email->message = "Спасибо за регистрацию вашей компании. Теперь вы можете отслеживать наши самые актуальные новости. Добавлять обьявления и фотографии и многое другое!";
					  if(!$email->Send()) {
					       
					  }else {
					      
					  }
					   
					  
					  $activationLink = Yii::app()->createAbsoluteUrl('companies/activation', array('act_key'=>$activationKey));
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
		));
	} 

	
	public function actionActivation($act_key)
	{
	      $company=Member::model()->find('aktivation_key=:key', array(':key'=>$act_key));
	      $company->scenario = "activation"; 
	      if (!isset($company->email))   
	      {
		//throw new CHttpException(404,'The requested page does not exist.');
	      }
	      else
	      {
		$company->aktivation_key=1;  
        $company->activate_type=1;
		if ($company->update())
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
		$model=new Companies;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Companies']))
		{
			$model->attributes=$_POST['Companies'];
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

		if(isset($_POST['Companies']))
		{
			$model->attributes=$_POST['Companies'];
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
		$dataProvider=new CActiveDataProvider('Companies');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Companies('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Companies']))
			$model->attributes=$_GET['Companies'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Companies the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Companies::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Companies $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='companies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
