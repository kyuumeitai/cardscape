<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Cardscape',
    //Change the following option if you want to provide a different language for your users
    //'language' => 'pt',
    //Development setting
    //'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'components' => array(
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
        //Update database settings and uncomment
        'db' => array(
            'connectionString' => 'mysql:host=<DB HOST>;dbname=<DB NAME>',
            'emulatePrepare' => true,
            'username' => '<DB USER>',
            'password' => '<DB PASSWORD>',
            'charset' => 'utf8',
            //Only change if you know what a prefix is and really need it
            'tablePrefix' => ''
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    //Development settings
    //'log' => array(
    //    'class' => 'CLogRouter',
    //    'routes' => array(
    //        array(
    //            'class' => 'CFileLogRoute',
    //            'levels' => 'error, warning'
    //        ),
    //    ),
    //)
    ),
    'params' => include 'custom.settings.php'
);