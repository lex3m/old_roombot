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
                'actions'=>array('index','shuffle','check','getcount','pricelists','index','view','register','registersuccess','activation',
                'viewinfo','dashboard','profile','news','tenders','consultants','addtag','tagsdelete','editpicturename',
                'vacancies','offers','photos','products','add_product','getnamesarray','getinfo','create','update','add','delete','search'),    
                'roles'=>array('admin'),    
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
    
    public function actionSearch($id)
    {
         $criteria = new CDbCriteria();
         $criteria->select = "id, moderation, name, image, m.email as memberEmail, date";
         $criteria->join = 'JOIN  kj28_members m ON  (m.id = t.companyID)';
         $criteria->condition = 't.companyID=:id';
         $criteria->params = array(':id'=>$id);
         $criteria->order = 't.id DESC';
         $dataProvider = new CActiveDataProvider(Mobilepictures::model()->with('taglinks'),  
                    array(
                        'criteria'=>$criteria,
                        
                        'pagination'=>array(
                            'pageSize'=>12,
                        ),
                    )
          );
          $member=Member::model()->findByPk($id);
        $this->render('search',array(
            'dataProvider'=>$dataProvider ,
            'member'=>$member,
        ));
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
    $model = Mobilepictures::model()->with('taglinks')->findbyPk($id);
    $z=0;
    $tags_arr = array();
    foreach ($model->taglinks as $link)
    {
        $tags_arr[$z] = Mobiletags::model()->findbyPk($link->tagId);
    }
    $this->render('viewinfo',array(
            'model'=>$model,
            'tags'=>$tags_arr,
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
        $tags = Mobiletags::model()->findAll();
        $i=0;
        $z=0;
        $image_arr = array();
        $names_arr = array();
        $tags_arr = array();
        $tagsid_arr = array();
        if ($tag=="all") 
        {  
            $images = Mobilepictures::model()->findAll();
            foreach ($images as $image)
            {
                $image_arr[$i]=$image->image;
                $names_arr[$i]=$image->name; 
                $i++;
            }
        }
        else {
            $tag = Mobiletags::model()->findbyPk($tag);
            $imagelinks = Mobilelinks::model()->findAll('tagId=:tagId', array(':tagId'=>$tag->id));
            foreach($imagelinks as $imagelink)
            {
                $image = Mobilepictures::model()->find('id=:id', array(':id'=>$imagelink->imageId));
                $image_arr[$i]=$image->image;
                $names_arr[$i]=$image->name;
                $i++;  
            }
        }
        
       $reserve_image_array = array_reverse($image_arr);
       $reserve_name_array = array_reverse($names_arr);
         
        foreach ($tags as $tag)
        {
            $tags_arr[$z]=$tag->name;
            $tagsid_arr[$z]=$tag->id;
            $z++;
        }
                $json_data = array ('image_arr'=>$reserve_image_array,'names_arr'=>$reserve_name_array,'tags_arr'=>$tags_arr,'tagsid_arr'=>$tagsid_arr); 
        echo json_encode($json_data); 

    }
    
    public function actionAdd($id)
    {  
          $member = Member::model()->find('urlID=:id', array(':id'=>$id));
          if ($member->id==Yii::app()->user->getId())
          {
          $company = Companies::model()->findbyPk($member->id);
          $pic_arr=array();
          $pictures=Mobilepictures::model()->findAll('companyID=:id', array(':id'=>$company->id));
          
  
           $model = new Mobilepictures('add');
          if (isset($_POST['Mobilepictures'])) {
                $model->attributes = $_POST['Mobilepictures'];
                $img=CUploadedFile::getInstance($model,'img');
                $model->img=$img;
                $model->image = $img;
                $model->info='';
                $model->date=date('Y-m-d');
                $model->companyID=$company->id;
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
              //  Yii::app()->user->setFlash('success', "Изображения были успешно загружены.");
               // $this->refresh();
                
            $criteria = new CDbCriteria();
            $criteria->condition = 'companyID=:id';
            $criteria->params = array(':id'=>$company->id); 
            $criteria->order ='id DESC';
            $dataProvider = new CActiveDataProvider(Mobilepictures::model()->with('taglinks'), 
                    array(
                        'criteria'=>$criteria,
                        
                        'pagination'=>array(
                            'pageSize'=>12,
                        ),
                    )
            );
              $this->render('add',array(   
                'company'=>$company,
                'member'=>$member,
                'pictures'=>$pictures,
                'model'=>$model,
                'dataProvider'=>$dataProvider, ));
          }
        else
            {
               throw new CHttpException(404,'Старница не найдена'); 
            }
    }
    
    public function actionDelete()
    {

        if (isset($_POST['id']))
          {
           $image = Mobilepictures::model()->findbyPk($_POST['id']);
           if ($image->delete())
              unlink(Yii::getPathOfAlias('webroot').'/images/mobile/images/'.$image->image);
              echo $image->id;
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
   

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
         $criteria = new CDbCriteria();
         $criteria->select = "id, moderation, name, image, m.email as memberEmail, date";
         $criteria->join = 'JOIN  kj28_members m ON  (m.id = t.companyID)';
         $criteria->order = 't.id DESC';
         $dataProvider = new CActiveDataProvider(Mobilepictures::model()->with('taglinks'),  
                    array(
                        'criteria'=>$criteria,
                        
                        'pagination'=>array(
                            'pageSize'=>12,
                        ),
                    )
          );
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
    
    public function actionCheck()
    {
        $picture = Mobilepictures::model()->findByPk($_POST['id']);
        if ($picture->moderation==0)
           $picture->moderation=1;
        else
            $picture->moderation=0;
        if ($picture->update()) 
            $json_data = array ('id'=>$picture->id,'check'=>$picture->moderation);
        echo json_encode($json_data); 
    }
    
    public function actionShuffle()
    {
         $criteria = new CDbCriteria();
         $criteria->order ='order_id DESC';
         $criteria->condition = 'moderation=:moder';
         $criteria->params = array(':moder'=>1);
         $dataProvider = new CActiveDataProvider(Mobilepictures::model()->with('taglinks'), 
                    array(
                        'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>100,
                        ),
                    )
          );
        $this->render('shuffle',array(
            'dataProvider'=>$dataProvider,
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
     * @param Compaфnies $model the model to be validated
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
