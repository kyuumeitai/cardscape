<?php

//DEMO DEVELOPMENT FILE: Place them in /cardscape/config while developing.
//
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Cardscape',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'password',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
            'class' => 'WebUser',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=<DB SERVER>;dbname=<REPLACE WITH DB NAME>',
            'emulatePrepare' => true,
            'username' => '<DB USER>',
            'password' => '<DB PASSWORD>',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => include 'params.dev.php'
);