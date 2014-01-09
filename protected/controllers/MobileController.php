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

    public function actionFBHandleUserEntry($name, $email)
    {
        $response = array("success" => 0);
        $user = Member::model()->find('email=:email',array(':email'=>$email));
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
            $uuid = uniqid('', true);
            $password = uniqid('',true);
            $salt = 12345;
            $newUser = new Member('facebook');
            $newUser->login = $name;
            $newUser->unique_id = $uuid;
            $newUser->salt=$salt;
            $newUser->password=$password;
            $newUser->date = date("Y-m-d");
            $newUser->email = $email;
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
}