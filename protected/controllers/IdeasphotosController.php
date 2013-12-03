<?php

class IdeasphotosController extends Controller
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
                'actions'=>array('add','delete'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array(),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex()
    {
        $this->render('index');
    }
    
    public function actionAdd()
    {
        $lookingForOldPhotosInIdeaBook =  Ideaphotos::model()
            ->findAll('photoID=:photoID AND ideaBooksID=:ideaBooksID',
                array(':photoID'=>$_POST['id'],':ideaBooksID'=>$_POST['selectedIdeasBook']));
        if (count($lookingForOldPhotosInIdeaBook)==0){
            $ideaPhoto = new Ideaphotos('add');
            $ideaPhoto->photoID = $_POST['id'];

            $ideaPhoto->ideaBooksID = $_POST['selectedIdeasBook'];
            if ($ideaPhoto->save()){
                $json_data = array ('id'=>$ideaPhoto->id);
                echo json_encode($json_data);
            }
        }
    }

    public function actionDelete()
    {
        $ideasPhoto=Ideasphotos::model()->findbyPk($_POST['id']);
        if ($ideasPhoto->delete()){
            $json_data = array ('id'=>$ideasPhoto->id);
            echo json_encode($json_data);
        }
    }
}