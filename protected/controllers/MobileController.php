<?php
class MobileController extends Controller
{



    public function actionCheckregister($id)
    {
        $checkDoubleMobileUser  = Member::model()->find('name=:name',array(':name'=>$id));
        if (count( $checkDoubleMobileUser)!=0)
            $issetUser  = true;
        else
            $issetUser  = false;
        if (!$issetUser)
        {
            $mobileUser = new Vsusers;
            $mobileUser->name = $id;
            if ($mobileUser->save())
            {
                $saved=true;
            }
        }
        else $saved=false;
        if (!$saved)
            $id = $checkDoubleMobileUser->id;
        else
            $id = $mobileUser->id;
        $json_data = array ('userid'=> $id);
        echo json_encode($json_data);
    }

    public function storeUser($name, $email, $password) {
        if (strlen($password)==0)
            return false;
        else
        {
            $uuid = uniqid('', true);
            $user = new Member('mobile_via_email');
            $user->unique_id=$uuid;
            $user->login = $name;
            $user->email = $email;
            $user->salt=12345;
            $user->password=$password;
            $user->date = date("Y-m-d");
            $user->role='user';
            $user->aktivation_key=1;
            $user->urlID=777777777777;
            $user->type=1;
            $user->activate_type=1;
            if ($user->save()) {
                $new_user=Member::model()->findbyPk($user->id);
                $this->setInitMemberInfo($new_user->id, $new_user->email);
                return $new_user;
            } else {
                return false;
            }
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
        $user = Member::model()->find('email=:email',array(':email'=>$email));


        $number_of_rows = count($user);
        if ($number_of_rows > 0) {
            // check for password equality
            if($user->validatePassword($password)){
                return $user;
            }
            else return false;
        } else {
            // user not found
            return false;
        }

    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $user = Member::model()->find('email=:email',array(':email'=>$email));
        $number_of_rows = count($user);
        if ($number_of_rows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }

    public function actionHandleUserEntry()
    {
        if (isset($_GET['tag']) && $_GET['tag'] != '') {
            // get tag
            $tag = $_GET['tag'];

            // response Array
            $response = array("tag" => $tag, "success" => 0, "error" => 0);

            // check for tag type
            if ($tag == 'login') {
                // Request type is check Login
                $email = $_GET['email'];
                $password = $_GET['password'];

                // check for user
                $user = $this->getUserByEmailAndPassword($email, $password);
                if ($user != false) {
                    // user found
                    // echo json with success = 1
                    $response["success"] = 1;
                    $response["uid"] = $user->unique_id;
                    $response["user"]["name"] = $user->login;
                    $response["user"]["email"] = $user->email;
                    $response["user"]["created_at"] = $user->date;
                    $response["user"]["updated_at"] = '';
                    echo json_encode($response);
                } else {
                    // user not found
                    // echo json with error = 1
                    $response["error"] = 1;
                    $response["error_msg"] = "Incorrect email or password!";
                    echo json_encode($response);
                }
            } else if ($tag == 'register') {
                // Request type is Register new user
                $name = $_GET['login'];
                $email = $_GET['email'];
                $password = $_GET['password'];

                // check if user is already existed
                if ($this->isUserExisted($email)) {
                    // user is already existed - error response
                    $response["error"] = 2;
                    $response["error_msg"] = "User already existed";
                    echo json_encode($response);
                } else {
                    // store user
                    $user = $this->storeUser($name, $email, $password);
                    if ($user!=false) {
                        // user stored successfully
                        $response["success"] = 1;
                        $response["uid"] = $user->unique_id;
                        $response["user"]["name"] = $user->login;
                        $response["user"]["email"] = $user->email;
                        $response["user"]["created_at"] = $user->date;
                        $response["user"]["updated_at"] = '';
                        echo json_encode($response);
                    } else {
                        // user failed to store
                        $response["error"] = 1;
                        $response["error_msg"] = "Error occured in Registartion";
                        echo json_encode($response);
                    }
                }
            } else {
                echo "Invalid Request";
            }
        } else {
            echo "Access Denied";
        }
    }

    public function actionFBHandleUserEntry($name, $uid)
    {
        $response = array("success" => 0);
        $user = Member::model()->find('unique_id=:unique_id',array(':unique_id'=>$uid));
        $number_of_rows = count($user);
        if ($number_of_rows > 0) {
            $response["success"] = 1;
            $response["uid"] = $user->unique_id;
            $response["user"]["name"] = $user->login;
            $response["user"]["email"] = $user->email;
            $response["user"]["created_at"] = $user->date;
            $response["user"]["updated_at"] = '';
            echo json_encode($response);
        } else {
            $uuid = $uid;
            $password = uniqid('',true);
            $salt = 12345;
            $newUser = new Member('facebook');
            $newUser->login = $name;
            $newUser->unique_id = $uuid;
            $newUser->salt=$salt;
            $newUser->password=$password;
            $newUser->date = date("Y-m-d");
            $newUser->email = $uuid.'@fb.com';
            $newUser->role='user';
            $newUser->aktivation_key=1;
            $newUser->urlID=777777777777;
            $newUser->type=1;
            $newUser->activate_type=1;
            if($newUser->save()){
                $userSaved = Member::model()->findbyPk($newUser->id);
                $response["success"] = 1;
                $response["uid"] = $userSaved->unique_id;
                $response["user"]["name"] = $userSaved->login;
                $response["user"]["email"] = $userSaved->email;
                $response["user"]["created_at"] = $userSaved->date;
                $response["user"]["updated_at"] = '';
                $this->setInitMemberInfo($newUser->id, 'fb');
                echo json_encode($response);

            }
            else json_encode($response);
        }
    }


    public function actionVkHandleUserEntry($uid, $login)
    {
        $response = array("success" => 0);
        $user = Member::model()->find('unique_id=:unique_id',array(':unique_id'=>$uid));
        $number_of_rows = count($user);
        if ($number_of_rows > 0) {
            $response["success"] = 1;
            $response["uid"] = $user->unique_id;
            $response["user"]["name"] = $user->login;
            $response["user"]["email"] = $user->email;
            $response["user"]["created_at"] = $user->date;
            $response["user"]["updated_at"] = '';
            echo json_encode($response);
        } else {
            $uuid = $uid;
            $password = uniqid('',true);
            $salt = 12345;
            $newUser = new Member;
            $newUser->scenario='vk';
            $newUser->login = $login;
            $newUser->unique_id = $uuid;
            $newUser->salt=$salt;
            $newUser->password=$password;
            $newUser->date = date("Y-m-d");
            $newUser->email = $uuid.'@vk.com';
            $newUser->role='user';
            $newUser->aktivation_key=1;
            $newUser->urlID=777777777777;
            $newUser->type=1;
            $newUser->activate_type=1;

            if($newUser->save()){
                $userSaved = Member::model()->findbyPk($newUser->id);
                $response["success"] = 1;
                $response["uid"] = $userSaved->unique_id;
                $response["user"]["name"] = $userSaved->login;
                $response["user"]["email"] = $userSaved->email;
                $response["user"]["created_at"] = $userSaved->date;
                $response["user"]["updated_at"] = '';
                $this->setInitMemberInfo($newUser->id, 'vk');
                echo json_encode($response);
            }
            else json_encode($response);
        }
    }

    public function setInitMemberInfo($userID, $userEmail){
        $memberInfo = new Memberinfo('register');
        $memberInfo->userID = $userID;
        $memberInfo->avatar = "user_da.gif";
        $memberInfo->cityIsSet = 0;
        if ($memberInfo->save())
        {
            if (($userEmail!='vk')||($userEmail!='fb')){
                $email = Yii::app()->email;
                $email->to =  $userEmail;
                $email->from=Yii::app()->params['email'];
                $email->subject = "Поздравляем вас с регистрацией! ".Yii::app()->name;
                $email->message = "Спасибо за регистрацию на сайте <a href=\"".Yii::app()->getBaseUrl(true)."\">".Yii::app()->getBaseUrl(true)."</a>. Теперь вы можете отслеживать наши самые актуальные новости. Добавлять обьявления и фотографии и многое другое!";
                $email->Send();
            }
        }
    }

    public function actionLike($pictureid, $typelogin,$key)
    {
        if ($typelogin=="email")
            $user = Member::model()->find('email=:email',array(':email'=>$key));
        else if ($typelogin=="social")
            $user = Member::model()->find('unique_id=:uid',array(':uid'=>$key));
        $picture = Mobilepictures::model()->find('image=:image',array(':image'=>$pictureid));
        $checkPhotoLikes = Photolike::model()->find('photoID=:photoID AND memberID=:memberID',array(':photoID'=>$picture->id,':memberID'=>$user->id));
        if (count($checkPhotoLikes)==0)
        {
            $photoLike = new Photolike;
            $photoLike->memberID=$user->id;
            $photoLike->photoID=$picture->id;
            $photoLike->save();
            $isVoted=true;
        }
        else
        {
            $checkPhotoLikes->delete();
            $isVoted=false;
        }
        $countLikes = Photolike::model()->count('photoID=:photoID',array(':photoID'=>$picture->id));
        $json_data = array ('countLikes'=>$countLikes,'isVoted'=>$isVoted);
        echo json_encode($json_data);

    }

    public function actionGetTagName($id, $lang)
    {
        $tag = Mobiletags::model()->findByPk($id);
        if ($lang=="ru")
            $tagName = $tag->name;
        else
            $tagName = $tag->name_en;
        $json_data = array ('tagName'=>$tagName);
        echo json_encode($json_data);
    }



    public function actionGetComments($logintype, $key, $image)
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
        $comments = Comments::model()->findAll('photoID=:photoID',array(':photoID'=>$img->id));
        $i=0;
        $commentNameArray=array();
        $commentAvatarArray=array();
        $commentTextArray=array();
        foreach($comments as $comment){
            $commentNameArray[$i] = Member::model()->findByPk($comment->memberID)->login;
            $avatar = Memberinfo::model()->find('userID=:userID',array(':userID'=>$comment->memberID));
            if (count($avatar)==0)
                $commentAvatarArray[$i] = "user_da.gif";
            else
                $commentAvatarArray[$i] = $avatar->avatar;
            $commentTextArray[$i]=$comment->content;
            $i++;
        }
        if ($img)
            $json_data = array ('name'=>$img->name,
                'info'=>$img->info,
                'date'=>$img->date,
                'countLikes'=>$img->countLikes,
                'isVoted'=>$isVoted,
                'countComments'=>$img->countComments,
                'commentNameArray'=>$commentNameArray,
                'commentTextArray'=>$commentTextArray,
                'commentAvatarArray'=>$commentAvatarArray);
        echo json_encode($json_data);
    }

    public function actionComment($logintype, $key, $photoId, $comment_text)
    {
        if (strpos($comment_text,'questionmark') !== false)
            $comment_text = str_replace('questionmark', "?", $comment_text);
        if (strpos($comment_text,'ampersandmark') !== false)
            $comment_text = str_replace('ampersandmark', "&", $comment_text);
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
        else
        {
            $json_data = array ('error'=>'true','error_type'=>'no user found');
            echo json_encode($json_data);
            return;
        }
        $photo = Mobilepictures::model()->find('image=:image', array(':image'=>$photoId));
        $memberinfo = Memberinfo::model()->find('userID=:userID',array(':userID'=>$user->id));
        if (count($memberinfo)==0)
            $avatar = "user_da.gif";
        else
            $avatar = $memberinfo->avatar;
        $comment = new Comments;
        $comment->content = $comment_text;
        $comment->memberID = $user->id;
        $comment->dateTime=date("Y-m-d H:i:s");
        $comment->photoID = $photo->id;
        $comment->save();
        $savedComment=Comments::model()->findbyPk($comment->id);

        $json_data = array ('error'=>'false',
            'error_type'=>'no user found',
            'comment_text'=>$savedComment->content,
            'comment_login'=>$user->login,
            'comment_avatar'=>$avatar);
        echo json_encode($json_data);
    }
}