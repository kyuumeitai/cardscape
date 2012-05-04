<?php

return array(
    //changing this value AFTER you have registered users will render ALL passwords INVALID!
    'hash' => 'THIS IS A DEVELOPMENT STRING, PLEASE CHANGE THIS IN A REAL SYSTEM',
    //Available languages, will affect interface and card/attribute texts
    'languages' => array(
        'en_US' => 'English (US)',
        'pt_PT' => 'Portuguese (Portugal)'
    ),
    'copyright' => '&copy; ' . date('Y') . 'Cardscape Development Team',
    'pageSize' => 25,
    'cardsDir' => '//cards'
);