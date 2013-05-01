<?php

return array(
    'class' => 'ext.Yii-SwiftMailer.SwiftMailer',
    // 'smtp' or 'sendmail' depending on your settings, if using SMTP uncomment the
    // smtp specific settings below
    'mailer' => 'sendmail',
    /*
     * SMTP settings, please ask you SMTP provider for these settings.
      // optional security settings, depends on your SMTP server
      // 'ssl' for "SSL/TLS" or 'tls' for 'STARTTLS'
      'security' => 'ssl',
      'host' => 'localhost',
      'from' => 'admin@localhost',
      'username' => 'smptusername',
      'password' => '123456',
     */
    // Development logging flags
    'logMailerActivity' => true,
    'logMailerDebug' => true,
);
