<?php

class AuthVKModel extends CModel {

    public $uid;
    public $first_name;
    public $last_name;
    public $photo_big;
    public $screen_name;

    private $token;
    private $params = array();

    public function rules() {
        return array(
            array('uid,first_name,last_name', 'required'),
            array('uid,first_name,last_name', 'length', 'max'=>255),
            array('photo_big', 'url')
        );
    }

    public function attributeLabels() {
        return array(
            'uid'=>'Уникальный идентификатор',
            'first_name'=>'Имя',
            'last_name'=>'Фамилия',
            'photo_big'=>'Аватар',
            'screen_name'=>'Страница пользователя'
        );
    }

    public function getAuthData($code) {
        $vkUser = new AuthVK();
        $vkUser->redirect_uri = 'http://'.Yii::app()->request->getServerName() . Yii::app()->createUrl($vkUser->redirect_uri);
        $this->params = array(
            'client_id' => $vkUser->client_id,
            'client_secret' => $vkUser->client_secret,
            'code' => $code,
            'redirect_uri' => $vkUser->redirect_uri
        );

        $file = @file_get_contents($vkUser->urlAccessToken . '?' . urldecode(http_build_query($this->params)));
        if ($file)
            $this->token = json_decode($file, true);
        else
            throw new CHttpException(401,'Неавторизированный запрос');

        if (isset($this->token['access_token'])) {
            Yii::app()->user->setState('vk_access_token', $this->token['access_token']);

            $this->params = array(
                'uids'         => $this->token['user_id'],
                'fields'       => $vkUser->fields,
                'access_token' => $this->token['access_token']
            );

            $userInfo = json_decode(file_get_contents($vkUser->urlApiGetUsers . '?' . urldecode(http_build_query($this->params))), true);

            if ($userInfo['response'][0]['uid'] > 0) {
                $authData = $userInfo['response'][0];
            }

        }  else
            throw new CHttpException(400,'Неправильный запрос');

        $this->uid = $authData['uid'];
        $this->first_name = $authData['first_name'];
        $this->last_name = $authData['last_name'];
        $this->photo_big = $authData['photo_big'];
        $this->screen_name = $authData['screen_name'];
    }

    public static function getVkUserFriends($token)
    {
        //Get API User Friends
        $vkUser = new AuthVK();
        $getFriendsUrl = $vkUser->urlApiGetAppUsers . "?access_token=".$token;
        $vkUserFriends = json_decode(file_get_contents($getFriendsUrl), true);
        if (isset($vkUserFriends['response'])) {
            $uids = implode(',', $vkUserFriends['response']);
        }
        $params = array(
            'uids'         => $uids,
            'fields'       => "first_name,last_name,photo",
            'access_token' => $token
        );
        $getFriendsInfoUrl = $vkUser->urlApiGetUsers."?". urldecode(http_build_query($params));
        $vkUserFriendsInfo = json_decode(file_get_contents($getFriendsInfoUrl), true);
        if (isset($vkUserFriends['response'])) {
            $vkUserFriendsInfo = $vkUserFriendsInfo['response'];

            $userFriends = array();
            $i = 0;
            foreach ($vkUserFriendsInfo as $friend) {
                foreach ($friend as $key => $value) {
                    $userFriends[$i]['name'] = $friend['first_name'] .' '. $friend['last_name'];
                    $userFriends[$i]['photo'] = $friend['photo'];
                    $userFriends[$i]['urlID'] = Member::getUserIDByUnique($friend['uid']);
                }
                $i++;
            }
        }
        return $userFriends;
    }

    public static function getVkUserPhotos($token)
    {
        $vkUser = new AuthVK();
        //Get API User Photos
        $params = array(
            'no_service_albums' => 0,
            'extended'          => 0,
            'photo_sizes'       => 0,
            'count'             => 60,
            'access_token' => $token
        );
        $vkUserPhotosUrl = $vkUser->urlApiGetUserPhotos . "?" . urldecode(http_build_query($params));
        $vkUserPhotos = json_decode(file_get_contents($vkUserPhotosUrl), true);
        if (isset($vkUserPhotos['response'])) {
            $vkUserPhotos = $vkUserPhotos['response'];
            array_shift($vkUserPhotos); //remove first element, it contents service info
            $userPhotos = array();
            $i = 0;
            foreach($vkUserPhotos as $photo) {
                $userPhotos[$i]['photo_id'] = $photo['pid'];
                $userPhotos[$i]['src'] = $photo['src'];
                $userPhotos[$i]['src_big'] = $photo['src_big'];
                $i++;
            }
        }
        return $userPhotos;
    }

    public function login() {
        $identity = new VKUserIdentity();
        if ($identity->authenticate($this)) {
            $duration = 3600*24*30;
            Yii::app()->user->login($identity,$duration);
            return true;
        }
        return false;
    }

    public function attributeNames() {
        return array(
        'uid'
        ,'first_name'
        ,'last_name'
        ,'photo_big'
        );
    }
}