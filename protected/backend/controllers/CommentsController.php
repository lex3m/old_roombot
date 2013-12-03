<?php

class CommentsController extends Controller
{
    
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
                'actions'=>array('index'),    
                'roles'=>array('admin'),    
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
 
        );
    }
    
    
	public function actionIndex()
	{
	    $criteria = new CDbCriteria();
        /*$criteria->select = "id, moderation, name, image, m.email as memberEmail, date";
        $criteria->join = 'JOIN  kj28_members m ON  (m.id = t.companyID)';
        $criteria->condition = 't.companyID=:id';
        $criteria->params = array(':id'=>$id);*/
        $criteria->order = 't.id DESC';
	    $dataProvider = new CActiveDataProvider(Comments::model()->with('member','countlikes'),  
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

	/*public function actionAdd()
    {
        $comment=$_POST['comment'];
        $photoID=$_POST['photoID'];
        $newComment = new Comments;
        $newComment->content=$comment;
        $newComment->memberID=Yii::app()->user->id;
        $newComment->photoID=$photoID;
        $newComment->dateTime = date("Y-m-d H:i:s");
        $member=Member::model()->findbyPk(Yii::app()->user->id);  
        
        if ($newComment->save())  
        {
            $json_data = array ('commentID'=>$newComment->id,'comment'=>$newComment->content, 'login'=>$member->login, 'dateTime'=>$newComment->dateTime);
            echo json_encode($json_data);  
        }
    }
    
    public function actionDelete()
    {
        $id=$_POST['id'];
        $comment=Comments::model()->findByPk($id);
        if ($comment->delete())
            echo $id;   
    }
    
    public function actionEdit()
    {
        $id=$_POST['id'];
        $commentContent=$_POST['commentContent'];
        $comment=Comments::model()->findByPk($id);
        $comment->scenario='edit';  
        $comment->content=$commentContent;
        $json_data = array ('comment'=>$comment->content, 'id'=>$comment->id);
        if ($comment->update())
            echo json_encode($json_data);     
    }
    
    public function actionLike()
    {
        $id=$_POST['id'];
        
            echo $id;   
    }*/
	
}