<?php

class IdeasbookController extends Controller
{

    
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
                'actions'=>array(),  
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('add','index','edit','delete','view'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
	public function actionIndex($id)
	{
	    $member=Member::model()->find('urlID=:urlID',array(':urlID'=>$id));
        $criteria = new CDbCriteria;
        $criteria->condition = 'memberID=:memberID';
        $criteria->params = array(':memberID'=>$member->id);
        $criteria->order = 't.id DESC';
	    $ideabooks= Ideasbook::model()->with('countIdeaPhotos','member')->findAll($criteria);
		$this->render('index',array(
            'ideasbooks'=>$ideabooks,
            'member'=>$member,
        ));
	}
    
    public function actionView($id)
    {
        $ideasBook= Ideasbook::model()->with('countIdeaPhotos','member','memberinfo')->findbyPk($id);
        $ideasPhotos = Ideasphotos::model()->with('photozz')->findAll('ideaBooksID=:ideaBooksID',array(':ideaBooksID'=>$ideasBook->id));
        $this->render('view',array(
            'ideasBook'=>$ideasBook,
            'ideasPhotos'=>$ideasPhotos,
        ));
    }
    
    public function actionDelete()
    {
        $ideasBook= Ideasbook::model()->findByPk($_POST['id']);
        if ($ideasBook->delete()){
                    $json_data = array ('id'=>$ideasBook->id);
                    echo json_encode($json_data);
        }
    }
    
    public function actionEdit()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $ideasBook = Ideasbook::model()->findbyPk($id);
        $ideasBook->scenario = 'edit';
        $ideasBook->name = $name;
        $ideasBook->description = $description;
        if($ideasBook->validate())
                if($ideasBook->save()){
                    $json_data = array ('id'=>$ideasBook->id,'name'=>$ideasBook->name,'description'=>$ideasBook->description);
                    echo json_encode($json_data);
                }  
    }

    public function actionAdd()
    {
        $ideasBook=new Ideasbook('add');
        if(isset($_POST['Ideasbook']))
        {
            $ideasBook->attributes=$_POST['Ideasbook'];
            $ideasBook->memberID = Yii::app()->user->id;
            $ideasBook->date = date('Y-m-d');  
            if($ideasBook->validate())
                if($ideasBook->save()){
                    Yii::app()->user->setFlash('success', "Изменения успешно сохранены.");
                    $url=Yii::app()->createUrl('ideasbook/index',array('id'=>Yii::app()->user->urlID));
                    $this->redirect($url);
                }
        }
        $this->render('add',array(
            'model'=>$ideasBook
            ));
    }
}