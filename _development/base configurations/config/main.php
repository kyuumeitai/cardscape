<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Cardscape',
    //Change the following option if you want to provide a different language 
    //for your users
    'language' => 'en_US',
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'components' => array(
        'mailer' => include 'mail.settings.php',
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
            'showScriptName' => false,
            'caseSensitive' => false,
        ),
        'db' => include 'database.settings.php',
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    ),
    'params' => include 'custom.settings.php'
);