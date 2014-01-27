<?php

class AuthFB extends CWidget
{
    public $client_id = '1414095988833822'; // ID приложения

    public $client_secret = 'cc1323f6d565671af2083b98ff10a14f'; // Защищённый ключ

    public $redirect_uri = 'site/login/fb' ; // Адрес сайта для редиректа

    public $urlAuthorize = 'https://www.facebook.com/dialog/oauth'; //Сервис авторизации FB
    public $urlAccessToken = 'https://graph.facebook.com/oauth/access_token'; //Получение токена
    public $urlApiGetUsers = 'https://graph.facebook.com/me'; //API FB Users

    public $fields = 'id,first_name,last_name,picture,link'; //получаемые поля в токене

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
            ),
            'url' => $this->urlAuthorize,

        );

        parent::init();
    }

    public function run()
    {
        $this->render('authFB', $this->params);
    }

    public function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }
}