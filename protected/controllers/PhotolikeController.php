<?php

class PhotolikeController extends Controller
{


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
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','add'),
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
	public function actionAdd()
	{
        $checkForLike = Photolike::model()->find('memberID=:memberID AND photoID=:photoID',array(':memberID'=>Yii::app()->user->id,':photoID'=>$_POST['id']));
        if (count($checkForLike)>0)
        {
            $like=0;
            $checkForLike->delete();
        }
        else
        {
            $like=1;
            $photoLike = new Photolike;
            $photoLike->memberID = Yii::app()->user->id;
            $photoLike->photoID = $_POST['id'];
            $photoLike->save();

        }
        $countLikes = Photolike::model()->count('photoID=:photoID',array(':photoID'=>$_POST['id']));
        $json_data = array ('like'=> $like,'countLikes'=>$countLikes);
		echo json_encode($json_data);
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}