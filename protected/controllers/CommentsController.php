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
            $countComments = Comments::model()->count('photoID=:photoID',array(':photoID'=>$_POST['photoID']));
            $countComments =  Yii::t('sitePhotos', '{n} comment|{n} comments', $countComments);
            $json_data = array ('avatar'=>$member->memberinfo->avatar, 'commentID'=>$newComment->id,'comment'=>$newComment->content, 'login'=>$member->login, 'urlID'=>$member->urlID, 'dateTime'=>$newComment->dateTime, 'countComments'=>$countComments);
            echo json_encode($json_data);  
        }
    }
    
    public function actionDelete()
    {
        $id=intval($_POST['id']);
        $comment=Comments::model()->findByPk($id);
        if ($comment->delete()) {
            $countComments = Comments::model()->count('photoID=:photoID',array(':photoID'=>$comment->photoID));
            $showAddComments = false;
            if ($countComments > 5) {
                $showAddComments = true;
            }
            $countComments =  Yii::t('sitePhotos', '{n} comment|{n} comments', $countComments);

            $jsonData = array('id'=>$id, 'countComments'=>$countComments, 'showAddComments'=>$showAddComments, 'photoID'=>$comment->photoID);
            echo json_encode($jsonData);
        }

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