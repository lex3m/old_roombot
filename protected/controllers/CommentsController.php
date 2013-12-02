<?php

class CommentsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionAdd()
    {
        $comment=$_POST['comment'];
        $photoID=$_POST['photoID'];  
        $newComment = new Comments;
        $newComment->content=$comment;
        $newComment->memberID=Yii::app()->user->id;
        $newComment->photoID=$photoID;
        $newComment->dateTime = date("Y-m-d H:i:s");
        $member=Member::model()->with('memberinfo')->findbyPk(Yii::app()->user->id);  
        
        if ($newComment->save())  
        {
            $json_data = array ('avatar'=>$member->memberinfo->avatar, 'commentID'=>$newComment->id,'comment'=>$newComment->content, 'login'=>$member->login, 'urlID'=>$member->urlID, 'dateTime'=>$newComment->dateTime);
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
    }
	
}