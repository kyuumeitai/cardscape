<?php

return array(
    'basePath' => dirname(__FILE__) . '/..',
    'name' => 'Cardscape Console App',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
    ),
    // application components
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=<YOUR DB HOST>;dbname=<YOUR DB NAME>',
            'emulatePrepare' => true,
            'username' => '<DB USER>',
            'password' => '<DB PASSWORD',
            'charset' => 'utf8',
            'tablePrefix' => ''
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
);
