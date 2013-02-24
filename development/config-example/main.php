<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Cardscape',
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
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
        // uncomment the following to use a MySQL database
        /*
          'db'=>array(
          'connectionString' => 'mysql:host=<DB HOST>;dbname=<DB NAME>',
          'emulatePrepare' => true,
          'username' => '<DB USER>',
          'password' => '<USER PASSWORD>',
          'charset' => 'utf8',
          'tablePrefix' => ''
          ),
         */
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
    ),
    'params' => include 'params.php'
);