<?php

class AuthFBModel extends CModel {

    public $id;
    public $first_name;
    public $last_name;
    public $picture;
    public $link;

    private $token = null;
    private $params = array();

    public function rules() {
        return array(
            array('id,first_name,last_name', 'required'),
            array('id,first_name,last_name', 'length', 'max'=>255),
            array('picture', 'url'),
        );
    }

    public function attributeLabels() {
        return array(
            'id'=>'Уникальный идентификатор',
            'first_name'=>'Имя',
            'last_name'=>'Фамилия',
            'picture'=>'Аватар',
            'link' => 'Страница пользователя'
        );
    }

    public function getAuthData($code) {
        $fbUser = new AuthFB();
        $fbUser->redirect_uri = 'http://'.Yii::app()->request->getServerName() . Yii::app()->createUrl($fbUser->redirect_uri);
        $this->params = array(
            'client_id' => $fbUser->client_id,
            'client_secret' => $fbUser->client_secret,
            'code' => $code,
            'redirect_uri' => $fbUser->redirect_uri
        );

        $file = @file_get_contents($fbUser->urlAccessToken . '?' . urldecode(http_build_query($this->params)));
        if ($file)
            parse_str($file, $this->token);
        else
            throw new CHttpException(401,'Неавторизированный запрос');


        if (count($this->token) > 0 && isset( $this->token['access_token'])) {
            $this->params = array(
                'access_token' =>  $this->token['access_token'],
                'fields'       => $fbUser->fields,
            );
            $userInfo = json_decode(file_get_contents($fbUser->urlApiGetUsers . '?' . urldecode(http_build_query($this->params))), true);
            if (isset($userInfo['id'])) {
                $authData = $userInfo;
            }
        } else
            throw new CHttpException(400,'Неправильный запрос');

        $this->id = $authData['id'];
        $this->first_name = $authData['first_name'];
        $this->last_name = $authData['last_name'];
        $this->picture = 'https://graph.facebook.com/'.$authData['id'].'/picture?type=large';
        $this->link = $authData['link'];
    }

    public function login() {
        $identity = new FBUserIdentity();
        if ($identity->authenticate($this)) {
            $duration = 3600*24*30;
            Yii::app()->user->login($identity,$duration);
            return true;
        }
        return false;
    }

    public function attributeNames() {
        return array(
        'id'
        ,'first_name'
        ,'last_name'
        ,'picture'
        );
    }
}