<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Roombot',

	// preloading 'log' component
	'preload'=>array('log'),
    'sourceLanguage' => 'en',
    'language' => 'ru',
   // 'homeUrl'=>array('site/index'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
    ),
	
	

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'potolok',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			// 'ipFilters'=>array('31.135.150.49','::1'),   
		),  
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'WebUser',
		),
		
		'clientScript' => array(
		  'scriptMap' => array(
                    'jquery.js' => false,
		  )
		),
		
		'errorHandler'=>array(
		  'errorAction'=>'site/error',  
		),
        
		'email'=>array(
            'class'=>'application.extensions.email.Email',
            'delivery'=>'php', //Will use the php mailing function.
        //May also be set to 'debug' to instead dump the contents of the email into the view
        ),
		// uncomment the following to enable URLs in path-format
		'Smtpmail'=>array(
		    'class'=>'application.extensions.smtpmail.PHPMailer',
		    'Host'=>"smtp.gmail.com",
		    'Username'=>'joomla.vertex@gmail.com',
		    'Password'=>'vesna123',
		    'Mailer'=>'smtp',
		    'Port'=>587,
		    'SMTPAuth'=>true, 
		    'SMTPSecure' => 'tls', 
		),
		'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'ImageMagick',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
        'request'=>array(
            'enableCookieValidation'=>true,
        ),
		'urlManager'=>array(
            'class'=>'application.components.UrlManager',
			'urlFormat'=>'path',
			'showScriptName'=>false,
            'caseSensitive'=>false,
			'rules'=>array(
                '<language:(ru|en)>/photos/<id:\d+>/<name:.*?>'=>'/site/photos',
                '<language:(ru|en)>/<action:(login|logout)>/*' => 'site/<action>',
                '<language:(ru|en)>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<language:(ru|en)>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<language:(ru|en)>/<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',

                '/photos/<id:\d+>/<name:.*?>'=>'site/photos',
                '<action:(login|logout)>/*' => 'site/<action>',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'authManager' => array(
		    // Будем использовать свой менеджер авторизации
		    'class' => 'PhpAuthManager',
		    // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
		    'defaultRoles' => array('guest'),
		),
		
		//'db'=>array(
		//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=roombot', 
			'emulatePrepare' => true,    
			'username' => 'root', //user_roombot
			'password' => 'root', //room123bot
			'charset' => 'utf8',
			'tablePrefix'=>'kj28_',     
		),  
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'email'=>'roombot.site@gmail.com',
        'pathToImg'=>'/../images/mobile/images/', //real path to files
        'languages'=>array('ru'=>'Русский', 'en'=>'English'),
	),
);
