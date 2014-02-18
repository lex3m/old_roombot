<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

    public function filters()
    {
        return array(
            'ajaxOnly + ajaxGetPhoto'
        );
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $this->setPageTitle(Yii::app()->name . ' - '. Yii::t('siteIndex', 'FREE add a photo of the interior in the mobile app'));
		$this->render('index', 'password');  
	}
	
	
    public function actionRules()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('rules');
    }
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    $this->setPageTitle(Yii::app()->name .' - Ошибка');
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        if (Yii::app()->user->isGuest) {

            $this->setPageTitle(Yii::app()->name . ' - Вход');
            $model=new LoginForm;

           //if Auth with VK
           if (isset($_GET['code']) && isset($_GET['vk'])) {
                $vkLogin = new AuthVKModel();
                $vkLogin->getAuthData($_GET['code']);
                if ($vkLogin->validate() && $vkLogin->login()) {
                    $url = Yii::app()->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID));
                    $this->redirect($url);
                }
                else {
                    Yii::app()->user->setFlash('error', Yii::t('sitePhotos', 'Error authorization on vkontakte, try again or use another service'));
                }
           }

            //if Auth with VK
            if (isset($_GET['code']) && isset($_GET['fb'])) {
                $fbLogin = new AuthFBModel();
                $fbLogin->getAuthData($_GET['code']);
                if ($fbLogin->validate() && $fbLogin->login()) {
                    $url = Yii::app()->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID));
                    $this->redirect($url);
                }
                else {
                    Yii::app()->user->setFlash('error', Yii::t('sitePhotos', 'Error authorization on facebook, try again or use another service'));
                }
            }

            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

           // collect user input data
           if(isset($_POST['LoginForm']))
           {
                $model->attributes=$_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid
                if($model->validate() && $model->login())
                    {

                    $user = Member::model()->find('id=:userID', array(':userID'=>Yii::app()->user->getId()));
                    if (isset($user->email))
                    switch ($user->type)  {
                      case '1':
                            if ($user->activate_type==1)
                            {
                              $url = Yii::app()->createUrl('member/dashboard',array('id'=>$user->urlID));
                              $this->redirect($url);
                            }
                            else
                            {
                              Yii::app()->user->logout();
                              $url = Yii::app()->createUrl('companies/notactivepage',array());
                              $this->redirect($url);
                            }
                            break;
                      default:
                          if ($user->activate_type==1)
                            {
                              $url = Yii::app()->createUrl('member/dashboard',array('id'=>$user->urlID));
                              $this->redirect($url);
                            }
                            else
                            {
                              Yii::app()->user->logout();
                              $url = Yii::app()->createUrl('companies/notactivepage',array());
                              $this->redirect($url);
                            }
                            break;

                      }
                    }
           }
            // display the login form
            $this->render('login',array('model'=>$model));
        } else {
            $url = Yii::app()->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID));
            $this->redirect($url);
        }
	}
	
	public function actionRegistration()
	{
		$this->render('registration',array()); 
	}

    public function actionPhotos()
    {
        $this->setPageTitle(Yii::app()->name.' - '. Yii::t('sitePhotos', 'recent photos of users interior design. Upload your own!'));
        if (isset($_GET['q']))
            $query = $_GET['q']; else $query='';
        if (isset($_GET['id']) && !empty($_GET['id']))
            $tagID = intval($_GET['id']); else $tagID='';
        $criteria = new CDbCriteria();
        $criteria->order ='id DESC';
        $criteria->alias = 'p';
        $criteria->select = 'p.id, p.image, p.name, m.login as memberLogin, m.urlID as memberUrlID';

        $criteria->distinct = 'p.id';

        $criteria->join = 'LEFT JOIN `'.Mobilelinks::model()->tableSchema->name.'` AS `l` ON `p`.`id` = `l`.`imageId`';
        $criteria->join .= 'LEFT JOIN `'.Mobiletags::model()->tableSchema->name.'` AS `tags` ON `l`.`tagId` = `tags`.`id`';
        $criteria->join .= 'LEFT JOIN `'.Member::model()->tableSchema->name.'` AS `m` ON `p`.`companyID` = `m`.`id`';
        if($query!='')
        {
            $queryUpCase = ucfirst($_GET['q']);
            $criteria->condition = 'tags.name LIKE :nameUpCase OR tags.name LIKE :nameLowerCase OR tags.name_en LIKE :nameUpCase OR tags.name LIKE :nameLowerCase';
            $criteria->params = array(':nameLowerCase'=>"%$query%", ':nameUpCase'=>"%$queryUpCase%");
        }
        if($tagID!='')
        {
            $criteria->condition = 'tags.id =  :tagID';
            $criteria->params = array(':tagID'=>$tagID);
        }

        $criteria->order = 'p.date DESC';
        $photos = new CActiveDataProvider('Mobilepictures',
            array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>24,
                ),
            )
        );
        $this->render('photos',array(
            'photos'=>$photos,
            'query'=>$query,
            'tagID'=>$tagID,
        ));
    }

    public function actionPassword()
    {
        $model = new Passwordform;
        $model->scenario='send_letter_for_password';
        if(isset($_POST['Passwordform']))
        {
            $model->attributes=$_POST['Passwordform'];
            // validate user input and redirect to the previous page if valid
            if($model->validate()) 
            {
                     
                    $activationKey = sha1(mt_rand(10000,99999).time().$model->email);  
                    $activationLink = Yii::app()->createAbsoluteUrl('site/change_password', array('act_key'=>$activationKey));
                    $email = Yii::app()->email;
                    $email->to = $model->email;
                    $email->from=Yii::app()->params['email'];
                    $email->subject = "Изменение вашего пароля! ".Yii::app()->name;
                    $email->message = "Чтобы сменить пароль вам необходимо пройти по следующей ссылке: <a href=\"".$activationLink."\">".$activationLink."</a>";
                    if(!$email->Send()) {
                          Yii::app()->user->setFlash('send_letter_for_password',"Произошел сбой отправки email на вашу почту. Пожалуйста повторите процедуру.");
                      }else {
                          $member = Member::model()->find('email=:email', array(':email'=>$model->email));
                    
                          $member->scenario = 'changing_password';
                          $member->aktivation_key = $activationKey;  
                          $member->save(false);
                          Yii::app()->user->setFlash('send_letter_for_password',"Указаное письмо отправлено вам на почту.");
                      }
                      $this->redirect('send_letter_success'); 
            }
        }
        $this->render('password',array(
            'model'=>$model, 
        )); 
    }
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
        CHttpSession::destroy();
		$this->redirect(Yii::app()->homeUrl);
	}
    
    public function actionSend_letter_success()
    {
       $this->render('send_letter_success',array());
    }

    public function actionInstruction()
    {
        $this->setPageTitle(Yii::app()->name . ' - ' . Yii::t('siteIndex', 'User manual'));
        $this->render('instruction',array());
    }
    
    public function actionChange_password($act_key)
    {
        $member = Member::model()->find('aktivation_key=:aktivation_key', array(':aktivation_key'=>$act_key));
        if (count($member)>0) 
        {
        $member->scenario = 'changing_password2';   
        if(isset($_POST['Member']))
        {
            $member->attributes=$_POST['Member'];
            
            // validate user input and redirect to the previous page if valid
            if($member->validate()) 
                {
                      $salt=$member->generateSalt();
                      $member->salt = $salt;
                      $member->password = $member->hashPassword($member->password, $salt);
                     
                      $member->aktivation_key = 1;     
                      $member->save(false);
                      Yii::app()->user->setFlash('register-success', Yii::t('siteIndex', 'Your password successfully changed'));
                      $this->redirect('login'); 
                }
        }
       $this->render('change_password',array(
            'model'=>$member
            ));
        }
        {
            throw new CHttpException(404);
        }
    }

    public function actionAjaxGetPhoto()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $photoID = intval($_POST['photoID']);
            $nextPhotoID = isset($_POST['nextPhotoID']) ? intval($_POST['nextPhotoID']) : "";
            $prevPhotoID = isset ($_POST['prevPhotoID']) ? intval($_POST['prevPhotoID']) : "";

            $model = Mobilepictures::model()->with('taglinks','member')->findbyPk($photoID);

            $criteria = new CDbCriteria();
            $criteria->condition = 'photoID=:photoID';
            $criteria->params = array(':photoID'=>$model->id);
            $criteria->limit = 5;
            $comments = Comments::model()->with('member','countlikes')->findAll($criteria);

            $member= Member::model()->findbyPK($model->companyID);
            $z=0;
            $tags_arr = array();
            $tagNameArray= array();
            foreach ($model->taglinks as $link)
            {
                $tags_arr[$z] = Mobiletags::model()->findbyPk($link->tagId);
                $z++;
            }
            $k=0;
            foreach($tags_arr as $tag)
            {
                $tagNameArray[$k] = (Yii::app()->language == 'en') ? $tag->name_en : $tag->name;
                $k++;
            }
            $this->setPageTitle(Yii::app()->name . ' - ' .Yii::t('sitePhotos', 'Photo').$model->name.'.' . Yii::t('sitePhotos', 'Tags') . ':' .implode(", ",$tagNameArray));
            $photoTags = Phototag::model()->findAllByAttributes(array('photoID'=>$photoID));

            $this->renderPartial('photospoiler',array(
                'model'=>$model,
                'tags'=>$tags_arr,
                'member'=>$member,
                'comments'=>$comments,
                'tagNameArray'=>$tagNameArray,
                'nextPhoto'=>$nextPhotoID,
                'prevPhoto'=>$prevPhotoID,
                'photoTags'=>$photoTags,
            ), false, true);
            Yii::app()->end();

        } else {
            throw new CHttpException(400,'Bad request');
        }
    }

    public function actionAllcomments()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $photoID = $_POST['id'];
            $criteria = new CDbCriteria();
            $criteria->condition = 'photoID=:photoID';
            $criteria->params = array(':photoID'=>$photoID);
            if (isset($_POST['limit'])) {
                $criteria->limit = intval($_POST['limit']);
            }

            $comments = Comments::model()->with('member','countlikes')->findAll($criteria);
            $commentsCount = Comments::model()->count('photoID=:photoID', array(':photoID'=>$photoID));

            $this->renderPartial('_allcomments',array(
                'comments'=>$comments,
                'countComments'=>$commentsCount
            ), false, true);
            Yii::app()->end();

        } else {
            throw new CHttpException(400,'Bad request');
        }
    }
}