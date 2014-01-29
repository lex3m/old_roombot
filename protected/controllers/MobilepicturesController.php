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
                'actions'=>array('create','update','delete', 'rotate', 'addtag', 'getTags', 'tagsdelete','editpicturename', 'editpictureinfo', 'addpicture'),
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
    public function actionView($logintype, $key, $image)
    {
        if ($logintype=="email")
        {
            $user = Member::model()->find('email=:email',array(':email'=>$key));
            $userExist=true;
        }
        else if ($logintype=="social")
        {
            $user = Member::model()->find('unique_id=:uid',array(':uid'=>$key));
            $userExist=true;
        }
        else if ($logintype=="none")
            $userExist=false;
        $img = Mobilepictures::model()->with('countLikes', 'countComments')->find('image=:image', array(':image'=>$image));
        if ($userExist)
        {
            $checkPhotoLikes = Photolike::model()->find('photoID=:photoID AND memberID=:memberID',array(':photoID'=>$img->id,':memberID'=>$user->id));
            if (count($checkPhotoLikes)==0)
                $isVoted=false;
            else
                $isVoted=true;
        }
        else
            $isVoted="undefined";

        if ($img)
            $json_data = array ('name'=>$img->name,
                'info'=>$img->info,
                'date'=>$img->date,
                'countLikes'=>$img->countLikes,
                'isVoted'=>$isVoted,
                'countComments'=>$img->countComments);
        echo json_encode($json_data);

    }


    public function actionAddpicture()
    {
        if(Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['id']) && isset($_POST['src'])) {
                $img = file_get_contents($_POST['src']);
                $model = new Memberinfo();
                $ava  =  $model->generateUniqueAvatarName();
                $mobilePicture = new Mobilepictures('upload');
                $mobilePicture->image = $ava;
                $mobilePicture->name = ''; //'Фото пользователя '.$member->login;
                $mobilePicture->date = date('Y-m-d');
                $mobilePicture->companyID = Yii::app()->user->id;
                if ($mobilePicture->save()) {
                    $file = Yii::app()->baseUrl.'images/mobile/images/'.$ava;
                    if (file_put_contents($file, $img))
                        echo 1;
                }


            }
         } else {
            throw new CHttpException(400);
        }

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

    public function actionGetTags()
    {

        if (isset($_POST['id'])) {
            echo CHtml::checkBoxList('tags[]',
                array_keys(CHtml::listData(Mobilelinks::model()->findAll('imageId=:imd', array('imd'=>$_POST['id'])), 'tagId' , 'tagId')),
                CHtml::listData(Mobiletags::model()->findAll(), 'id', (Yii::app()->language == 'en') ? 'name_en' : 'name'),
                array('separator'=>'', 'template'=>'<span class="checkbox-columns">{input} {label}</span>')
            );
        }

    }


    public function actionAddtag()
    {
       if (isset($_POST['id'])&&is_array($_POST['select']))
       {
           $json_data = array();

           $tags = array();
           $criteria = new CDbCriteria();
           $criteria->select = 'tagId';
           $criteria->condition = 'imageId = :imgId';
           $criteria->params = array('imgId' => $_POST['id']);

           $allTags = Mobilelinks::model()->findAll($criteria);
           foreach ($allTags as $tag) {
               array_push($tags, $tag->tagId);
           }

           $newTags = array_diff($_POST['select'], $tags); //compare to find new tags
           $oldTags = array_diff($tags, $_POST['select']); //compare to find old tags

           foreach ($newTags as $value) {
              $taglink = new Mobilelinks();
              $taglink->tagId = $value;
              $taglink->imageId = $_POST['id'];
              $taglink->save();
           }

           foreach ($oldTags as $value) {
               $taglink = new Mobilelinks();
               $taglink->deleteAllByAttributes(array('tagId' => $value));
           }

           $criteria = new CDbCriteria();
           $criteria->condition = 'imageId = :imgId';
           $criteria->params = array('imgId' => $_POST['id']);

           $taglink = new Mobilelinks();
           $allNewTags = $taglink->with('tag')->findAll($criteria);

           foreach ($allNewTags as $tag)
                $json_data[] = array ('tagname'=>(Yii::app()->language == 'en') ? $tag->tag->name_en : $tag->tag->name,'taglinkid'=>$tag->id,'pictureid'=>$tag->imageId);

           echo json_encode($json_data);
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
        if ($model !== null) {
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
                $tagNameArray[$k] = (Yii::app()->language == 'en') ? $tag->name_en : $tag->name;
                $k++;
            }
            $this->setPageTitle(Yii::app()->name . ' - ' .Yii::t('sitePhotos', 'Photo').$model->name.'.' . Yii::t('sitePhotos', 'Tags') . ':' .implode(", ",$tagNameArray));
            $this->render('viewinfo',array(
                'model'=>$model,
                'tags'=>$tags_arr,
                'member'=>$member,
                'comments'=>$comments,
                'tagNameArray'=>$tagNameArray,
            ));
        } else {
            throw new CHttpException(404, 'Page not found');
        }
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
            if (!is_dir($path.'/thumbs')) {
                mkdir($path.'/thumbs');
                chmod($path.'/thumbs', 0777);
            }
            $thumbpath = realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg']."/thumbs/" )."/";

            if ($img->companyID == Yii::app()->user->id)
            {
                Yii::import('ext.image.Image');
                $image = new Image($path.$img->image);

                $image->rotate(90)->quality(99);
                if (is_file(realpath( Yii::app() -> getBasePath() . Yii::app()->params['pathToImg']."/thumbs/" )."/".$img->image))
                    $thumb = new Image($thumbpath.$img->image);
                /*Fix for older images*/
                else {
                    if($image->width>1000)
                        $image->resize(150,150);
                    $image->save($thumbpath.$img->image);
                    $thumb = new Image($thumbpath.$img->image);
                }
                $thumb->rotate(90)->quality(99);

                /*$imageExploded = explode('.', $img->image);
                $imgName = $imageExploded[0];
                $imgExt = $imageExploded[1];
                $extArr = array('jpg', 'jpeg');*/

                /*Workaround jpg extension, rotate original image but save with another name*/
                /*if (in_array($imgExt, $extArr)) {
                    $newImg = 'rotated_' . $imgName;
                    $newImgName = $newImg . '.' .$imgExt;
                    $imag = $image->save($path.$newImgName);
                    $thmb =  $thumb->save($thumbpath.$newImgName);
                } else {
                    $newImgName = $img->image;
                    $imag = $image->save();
                    $thmb =  $thumb->save();
                }*/


                if ( $image->save() && $thumb->save()) {
                    $im = '<img height="100px" src="'. Yii::app()->baseUrl.'/images/mobile/images/thumbs/' .$img->image. '?iid='.$img->id.'" class="photo-img">';
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

          $criteria = new CDbCriteria();
          if (Yii::app()->language == 'en')
              $criteria->condition = 'name_en LIKE :name';
          else
              $criteria->condition = 'name LIKE :name';
          $criteria->params = array(':name'=>'%'.$query.'%');

          $tag = Mobiletags::model()->with('imagelinks')->find($criteria);

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
                 Yii::app()->user->setFlash('flash-error', Yii::t('sitePhotos', 'There are no photos by your request. We are sorry'));
                 $this->redirect(Yii::app()->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID)));
            }
          }  
        else
            {
               throw new CHttpException(404);
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
