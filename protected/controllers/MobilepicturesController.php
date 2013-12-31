<?php

class MobilepicturesController extends Controller
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
                'actions'=>array('getpreviousphotos','getcount','pricelists','index','view','register','registersuccess','activation',
                'viewinfo','dashboard','profile','news','tenders','consultants',
                'vacancies','offers','photos','products','add_product','getnamesarray','getinfo','getinitinfo','search'),      
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','delete', 'rotate', 'addtag','tagsdelete','editpicturename', 'editpictureinfo'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin'),
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
    public function actionView($name,$extension)
    {
        $img = Mobilepictures::model()->find('image=:image', array(':image'=>$name.'.'.$extension));
        if ($img)
            $json_data = array ('name'=>$img->name,'info'=>$img->info,'date'=>$img->date);
                echo json_encode($json_data);

    }


     
    public function actionEditpicturename()
    {
        if (isset($_POST['id'])&&isset($_POST['name']))
          {
              $img = Mobilepictures::model()->findbyPk($_POST['id']); 
              $img->name = $_POST['name'];
              if ($img->save()) 
               {
                $json_data = array ('id'=>$img->id,'name'=>$img->name);
                echo json_encode($json_data);
               }
          }
    }

    public function actionEditpictureinfo()
    {
        if (isset($_POST['id'])&&isset($_POST['info']))
        {
            $img = Mobilepictures::model()->findbyPk($_POST['id']);
            $img->info = $_POST['info'];
            if ($img->save())
            {
                $json_data = array ('id'=>$img->id,'info'=>$img->info);
                echo json_encode($json_data);
            }
        }
    }

    public function actionAddtag()
    {
       if (isset($_POST['id'])&&isset($_POST['select']))
          {
              $searchtaglink = Mobilelinks::model()->find(array(
                'condition'=>'tagId=:tagId AND imageId = :imageId',
                'params'=>array(':tagId'=>$_POST['select'], ':imageId'=>$_POST['id'])));
                if (isset($searchtaglink->id))
                echo 'isset'; 
            else
                {
              $taglink = new Mobilelinks();
              $taglink->tagId = $_POST['select'];
              $taglink->imageId = $_POST['id'];
              if ($taglink->save())
              {
                  $tag=Mobiletags::model()->findbyPk($taglink->tagId);
                  $json_data = array ('tagname'=>$tag->name,'taglinkid'=>$taglink->id,'pictureid'=>$taglink->imageId);
                  echo json_encode($json_data); 
                }    
          }      
          }
    }
    
    public function actionTagsdelete()
    {
        if (isset($_POST['id']))
            {
                 $mobilelink = Mobilelinks::model()->findbyPk($_POST['id']);
                 if (isset($mobilelink->id))
                 $id =  $mobilelink->id;
                 if ($mobilelink->delete()) echo $id;
            }
    }

    public function actionGetcount()
    {
        $count = Mobilepictures::model()->count();
        $json_data = array ('count'=>$count);
        echo json_encode($json_data); 

    }

    public function actionViewinfo($id)
    {

        $model = Mobilepictures::model()->with('taglinks','member')->findbyPk($id);
        $comments = Comments::model()->with('member','countlikes')->findAll('photoID=:photoID',array(':photoID'=>$model->id));
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
            $tagNameArray[$k] = $tag->name;
            $k++;
        }
        $this->setPageTitle(Yii::app()->name . ' - Фото '.$model->name.'. Теги: '.implode(", ",$tagNameArray));
        $this->render('viewinfo',array(
            'model'=>$model,
            'tags'=>$tags_arr,
            'member'=>$member,
            'comments'=>$comments,
            'tagNameArray'=>$tagNameArray,
        ));
    }

    public function actionGetinfo($name,$extension)
    {
        $img = Mobilepictures::model()->with('tags')->find('image=:image', array(':image'=>$name.'.'.$extension));
       echo $img->name;
       echo $img->info;
       echo $img->date;
      

    }

    public function actionGetnamesarray($tag)
    {
        
        $i=0;
        $z=0;
        $image_arr = array();
        $names_arr = array();
        $tags_arr = array();
        $tagsid_arr = array();
        $lang=Yii::app()->request->getParam('lang'); 
        $tagName="";
        if ($tag=="all")  
        {
            $criteria = new CDbCriteria();    
            $criteria->condition = 'moderation=:moderation';
            $criteria->params = array(':moderation'=>1);
            $images = Mobilepictures::model()->findAll($criteria);
            foreach ($images as $image)
            {
                $image_arr[$i]=$image->image;
                $names_arr[$i]=$image->name; 
                $i++;
            }
        }
        else {
            $tag = Mobiletags::model()->findbyPk($tag);
            if ($lang=="en")
                $tagName=$tag->name_en;
            else {
                $tagName=$tag->name;
            }
            $imagelinks = Mobilelinks::model()->findAll('tagId=:tagId', array(':tagId'=>$tag->id));
            foreach($imagelinks as $imagelink)
            {
                $criteria = new CDbCriteria();
                $criteria->condition = 'moderation=:moderation AND id=:id';  
                $criteria->params = array(':moderation'=>1, ':id'=>$imagelink->imageId);
                $image = Mobilepictures::model()->find($criteria);    
                if ($image)
                {
                    $image_arr[$i]=$image->image;
                    $names_arr[$i]=$image->name;
                    $i++;  
                }
            }
        }
        
       $reserve_image_array = array_reverse($image_arr);
       $reserve_name_array = array_reverse($names_arr);
       
      if ($lang=="en")
	  $tags = Mobiletags::model()->findAll(array('order'=>'name_en'));
       else
	  $tags = Mobiletags::model()->findAll(array('order'=>'name'));
         
        foreach ($tags as $tag)
        {
            if ($lang=="en")
		  $tags_arr[$z]=$tag->name_en;
		else
		 $tags_arr[$z]=$tag->name;
            $tagsid_arr[$z]=$tag->id;
            $z++;
        }
                $json_data = array ('tag_name'=> $tagName,'image_arr'=>$reserve_image_array,'names_arr'=>$reserve_name_array,'tags_arr'=>$tags_arr,'tagsid_arr'=>$tagsid_arr); 
        echo json_encode($json_data); 

    }


    public function actionGetinitinfo($tag)
    {
        
        $i=0;
        $z=0;
        $tags_arr = array();
        $tagsid_arr = array();
        
        if ($tag=="all")  
        {
            $criteria = new CDbCriteria();
            $criteria->order ='id DESC';  
            $lastImage = Mobilepictures::model()->find($criteria);
            $photoCount = Mobilepictures::model()->count($criteria);
        }
        else {
            $tag = Mobiletags::model()->findbyPk($tag);
            $criteria = new CDbCriteria();
            $criteria->condition = 'tagId=:tagId';
            $criteria->params = array(':tagId'=>$tag->id);
            $criteria->order ='id DESC';
            $lastlink = Mobilelinks::model()->find($criteria);
            $lastlinkAll = Mobilelinks::model()->findAll($criteria);
            for ($i=0;$i<count($lastlinkAll);$i++){
                $imageArray[$i] =  $lastlinkAll[$i]->imageId;
            }
            $lastImage = Mobilepictures::model()->findbyPK($lastlink->imageId);
            $criteriaCountAll = new CDbCriteria();
            $criteriaCountAll->addInCondition('id', $imageArray);
            $photoCount = Mobilepictures::model()->count($criteriaCountAll);
        }
        
        
        
       $lastImageID = $lastImage->id;
       $lang=Yii::app()->request->getParam('lang'); 
       if ($lang=="en")
      $tags = Mobiletags::model()->findAll(array('order'=>'name_en'));
       else
      $tags = Mobiletags::model()->findAll(array('order'=>'name'));
         
        foreach ($tags as $tag)
        {
            if ($lang=="en")
          $tags_arr[$z]=$tag->name_en;
        else
          $tags_arr[$z]=$tag->name;
            $tagsid_arr[$z]=$tag->id;
            $z++;
        }
                $json_data = array ('lastImageID'=>$lastImageID,'photoCount'=>$photoCount,'tags_arr'=>$tags_arr,'tagsid_arr'=>$tagsid_arr); 
        echo json_encode($json_data); 

    }

    public function actionGetpreviousphotos($tag)
    {
         $id=Yii::app()->request->getParam('id'); 
        
        if ($tag=="all")  
        {
            $criteria = new CDbCriteria();
            $criteria->condition = 'id<:id';
            $criteria->params = array(':id'=>$id);
            $criteria->order ='id DESC';  
            $lastImage = Mobilepictures::model()->find($criteria);
        }
        else {
            $tag = Mobiletags::model()->findbyPk($tag);
            $criteria = new CDbCriteria();
            $criteria->condition = 'tagId=:tagId';
            $criteria->params = array(':tagId'=>$tag->id);
            $criteria->order ='id DESC';
            $lastlink = Mobilelinks::model()->find($criteria);
            $lastlinkAll = Mobilelinks::model()->findAll($criteria);
            for ($i=0;$i<count($lastlinkAll);$i++){
                $imageArray[$i] =  $lastlinkAll[$i]->imageId;
            }
            $criteriaCountAll = new CDbCriteria();
            $criteria->condition = 'id<:id';
            $criteria->params = array(':id'=>$id);
            $criteriaCountAll->addInCondition('id', $imageArray);
            $lastImage = Mobilepictures::model()->find($criteriaCountAll);
        }
        
        $lastImageID=$lastImage->id;
        $json_data = array ('lastImageID'=>$lastImageID); 
        echo json_encode($json_data); 
    } 
    
   

    public function actionDelete()
    {
       
        if (isset($_POST['id']))
          {
           $image = Mobilepictures::model()->findbyPk($_POST['id']);
               if ($image->companyID == Yii::app()->user->id)
               {
                   if ($image->delete())
                   {
                      if (is_file(realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg']."/thumbs/" )."/".$image->image))
                        unlink(Yii::getPathOfAlias('webroot').'/images/mobile/images/thumbs/'.$image->image);
                      unlink(Yii::getPathOfAlias('webroot').'/images/mobile/images/'.$image->image);

                      echo $image->id;
                   }
               }
          } 
    }

    public function actionRotate()
    {

        if (isset($_POST['id']))
        {
            $img = Mobilepictures::model()->findbyPk($_POST['id']);
            $path = realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg'] )."/";
            $thumbpath = realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg']."/thumbs/" )."/";
            if ($img->companyID == Yii::app()->user->id)
            {
                Yii::import('ext.image.Image');
                $image = new Image($path.$img->image);
                $image->rotate(90);

                $thumb = new Image($thumbpath.$img->image);
                $thumb->rotate(90);
                if ($image->save() && $thumb->save()) {
                    $im = '<img width="150px" height="100px" src="/images/mobile/images/'.$img->image.'" class="photo-img">';
                    $json_data = array ('image'=> $im, 'id'=>$img->id);
                    echo json_encode($json_data); ;
                }
                else
                    echo 'error with rotating image';
            }
        }
    }
   /*
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

    public function actionSearch($query)
    {
       
          $member = Member::model()->find('urlID=:id', array(':id'=>Yii::app()->user->urlID));
          if ($member->id==Yii::app()->user->getId())
          {
          $company = Companies::model()->findbyPk($member->id);
          $pic_arr=array();
          $pictures=Mobilepictures::model()->findAll('companyID=:id', array(':id'=>$member->id));
          
  
          $tag = Mobiletags::model()->with('imagelinks')->find('name LIKE :name', array(':name'=>'%'.$query.'%'));
          if (count($tag)>0)
             {
              $i=0;
              $photosIds=array();
              foreach ($tag->imagelinks as $imagelink){
                  $photosIds[$i] = $imagelink->imageId;
                  $i++;
              }
                   
                $criteria = new CDbCriteria();
                $criteria->condition = 'companyID=:id';
                $criteria->params = array(':id'=>$member->id);
                $criteria->addInCondition('t.id',$photosIds);
                $criteria->order ='id DESC';
                $dataProvider = new CActiveDataProvider(Mobilepictures::model()->with('taglinks'), 
                        array(
                            'criteria'=>$criteria,
                            
                            'pagination'=>array(
                                'pageSize'=>12,
                            ),
                        )
                );
                  $this->render('search',array(   
                    'company'=>$company,
                    'member'=>$member,
                    'pictures'=>$pictures,
                    'dataProvider'=>$dataProvider, ));
              }
            else {
                 Yii::app()->user->setFlash('flash-error', "По вашему запросу изображений не найдено.");  
                 $this->redirect(Yii::app()->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID)));
            }
          }  
        else
            {
               throw new CHttpException(404,'Старница не найдена'); 
            }
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
        $model=Mobilepictures::model()->findByPk($id);
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
