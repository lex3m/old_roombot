<?php

class AuthVK extends CWidget
{
    public $client_id = '4111118'; // ID приложения

    public $client_secret = 'ITcj5PaMbd7NA1q2vjJo'; // Защищённый ключ

    public $redirect_uri = 'site/login/vk' ; // Адрес сайта для редиректа

    public $urlAuthorize = 'http://oauth.vk.com/authorize'; //Сервис авторизации VK
    public $urlAccessToken = 'https://oauth.vk.com/access_token'; //Получение токена
    public $urlApiGetUsers = 'https://api.vk.com/method/users.get'; //API VK Users
    public $urlApiGetAppUsers = 'https://api.vk.com/method/friends.getAppUsers'; // API user friends in app
    public $urlApiGetUserPhotos = 'https://api.vk.com/method/photos.getAll';

    public $fields = 'uid,first_name,last_name,photo_big,screen_name'; //получаемые поля в токене

    public $response_type = 'code';

    private $params = array();

    public function init()
    {
        $this->redirect_uri = 'http://'.Yii::app()->request->getServerName() . Yii::app()->createUrl($this->redirect_uri);
        //параметры по-умолчанию
        $this->params = array(
            'buttonParams' => array(
                'client_id'     => $this->client_id,
                'redirect_uri'  => $this->redirect_uri,
                'response_type' => $this->response_type,
                'scope'=>'friends,photos,offline'
            ),
            'url' => $this->urlAuthorize,
        );

        parent::init();
    }

    public function run()
    {
        $this->render('authVK', $this->params);
    }

    public function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }
}