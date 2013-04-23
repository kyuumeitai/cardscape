<?php

/**
 * Please note:
 * 
 * Tipical usage should not require this file, it is important for developers 
 * working with translations (updating strings, creating files automatically, etc.)
 * but not for every-day usage of cardscape.
 */
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Cardscape Console',
    'preload' => array('log'),
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=<DB HOST>;dbname=<DB NAME>',
            'emulatePrepare' => true,
            'username' => '<DB USER>',
            'password' => '<DB PASSWORD>',
            'charset' => 'utf8',
            //Only change if you know what a prefix is and really need it
            'tablePrefix' => ''
        ),
    //Development settings
    //'log' => array(
    //    'class' => 'CLogRouter',
    //    'routes' => array(
    //        array(
    //            'class' => 'CFileLogRoute',
    //            'levels' => 'error, warning',
    //        )
    //    )
    //)
    )
);