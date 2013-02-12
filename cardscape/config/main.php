<?php

return array(
    'basePath' => dirname(__FILE__) . '/..',
    'name' => 'Cardscape',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*'
    ),
    // application components
    'components' => array(
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.css' => false
            )
        ),
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
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=cardscape',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'toor',
            'charset' => 'utf8',
            'tablePrefix' => ''
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                ),
            )
        )
    ),
    'params' => include('params.php')
);
