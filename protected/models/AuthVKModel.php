<?php

class AuthVKModel extends CModel {

    public $uid;
    public $first_name;
    public $last_name;
    public $photo_big;

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

        $this->token = json_decode(file_get_contents($vkUser->urlAccessToken . '?' . urldecode(http_build_query($this->params))), true);

        if (isset($this->token['access_token'])) {
            $this->params = array(
                'uids'         => $this->token['user_id'],
                'fields'       => $vkUser->fields,
                'access_token' => $this->token['access_token']
            );

            $userInfo = json_decode(file_get_contents($vkUser->urlApiGetUsers . '?' . urldecode(http_build_query($this->params))), true);

            if ($userInfo['response'][0]['uid'] > 0) {
                $authData = $userInfo['response'][0];
            }

        }

        $this->uid = $authData['uid'];
        $this->first_name = $authData['first_name'];
        $this->last_name = $authData['last_name'];
        $this->photo_big = $authData['photo_big'];
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