<?php

return array(
    //changing this value AFTER you have registered users will render ALL passwords INVALID!
    'hash' => 'THIS IS A DEVELOPMENT STRING, PLEASE CHANGE THIS IN A REAL SYSTEM',
    //shows on footer if using the default template
    'copyrightHolder' => 'Cardscape Dev. Team',
    //Available languages, will affect interface and card/attribute texts
    'languages' => include 'languages.php',
    //folder, inside the webroot, where card images will be stored
    'cardscapeDataDir' => 'cardscapedata'
);