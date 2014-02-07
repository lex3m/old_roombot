<?php

class PhototagController extends Controller
{


    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'ajaxOnly + add, getInfo, edit, delete', // we only allow deletion via POST request
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('add', 'getInfo', 'edit', 'delete'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actionAdd()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $photoTag = new Phototag;
            $photoTag->scenario = 'add';
            $photoTag->attributes = $_POST;
            if ($photoTag->save())
                echo json_encode(array('saved'=>true, 'tid'=> $photoTag->id, 'image'=>$photoTag->image));
            else
                echo json_encode($photoTag->getErrors());
        } else {
            throw new CHttpException(500);
        }
	}

    public function actionGetInfo()
    {
        if(Yii::app()->request->isAjaxRequest) {
            if (!empty($_POST)) {
                $photoTag = Phototag::model()->findByPk($_POST['id']);
                if ($photoTag) {
                    echo json_encode($photoTag->attributes);
                }  else {
                    echo json_encode(null);
                }
            }
        } else {
            throw new CHttpException(500);
        }
    }

    public function actionEdit()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $photoTag = Phototag::model()->findByPk($_POST['tid']);
            $photoTag->scenario = 'edit';
            $photoTag->attributes = $_POST;
            if ($photoTag->save())
                echo json_encode(array('saved'=>true, 'image'=>$photoTag->image));
            else
                echo json_encode($photoTag->getErrors());
        } else {
            throw new CHttpException(500);
        }
    }


    public function actionDelete()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $photoTag = Phototag::model()->findByPk($_POST['id']);
            if ($photoTag->delete())
                echo json_encode(true);
        } else {
            throw new CHttpException(500);
        }
    }
}