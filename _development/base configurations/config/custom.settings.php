<?php

/**
 * All these settings will allow you to customize Cardscape. Some may only change 
 * strings in the layout others may change the way Cardscape behaves. Please read 
 * the comments about what each setting does and ask for help in the forums if 
 * you don't understand any of the settings.
 * 
 * http://wtactics.org/forum/viewforum.php?f=9
 */
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