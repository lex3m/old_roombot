<?php

class CommentlikeController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	public function actionChange()
    {
        $commentID=$_POST['commentID'];
        $commentLike= Commentlike::model()->find('commentID=:commentID AND memberID=:memberID',
                        array(':commentID'=>$commentID,':memberID'=>Yii::app()->user->id));
        $countLikes= Commentlike::model()->count('commentID=:commentID', array(':commentID'=>$commentID));
        if (count($commentLike)>0)  
            {
                if($commentLike->delete())
                {
                    $json_data = array ('commentID'=>$commentLike->commentID,'countLikes'=>($countLikes-1)); 
                    echo json_encode($json_data);
                }
            }
        else {
            $newCommentLike=new Commentlike('add');
            $newCommentLike->memberID=Yii::app()->user->id;
            $newCommentLike->commentID=$commentID;
            if ($newCommentLike->save())
            {
                $json_data = array ('commentID'=>$newCommentLike->commentID,'countLikes'=>($countLikes+1)); 
                echo json_encode($json_data); 
            }
        }
    }
}