<?php

/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 * 
 * This file is intended for developers working with translations, most useds don't 
 * need to use, change or even think about this file :)
 */
return array(
    'sourcePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'messagePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
    // list of ISO codes Yii should generate translation files for
    'languages' => array('pt'),
    'fileTypes' => array('php'),
    'overwrite' => true,
    //list of folders that Yii should ignore when looking for translation strings
    'exclude' => array(
        '.svn',
        '.git',
        '.gitignore',
        'yiilite.php',
        'yiit.php',
        '/i18n/data',
        '/messages',
        '/vendors',
        '/web/js',
        '/web/assets',
        '/web/css',
        '/web/images'
    )
);
