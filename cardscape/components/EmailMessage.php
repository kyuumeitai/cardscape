<?php

/* Copyright (C) 2012  Cardscape project
 * Web based collaborative platform for creating Collectible Card Games
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Utility wrapper class for the PHPMailer library. Provides easier e-mail sending 
 * features by implementing most of the standard code needed to configure and send 
 * an e-mail using PHPMailer.
 * 
 * Settings are read from the <em>Setting</em> table and the <em>main.php</em> 
 * config file when sending messages.
 */
class EmailMessage {

    private $message;
    private $to;
    private $from;
    private $sender;
    private $subject;

    public function __construct($to, $subject, $message, $form = null, $sender = null) {
        $this->to = $to;
        $this->message = $message;
        $this->subject = $subject;

        $this->form = $from;
        if (!$this->from) {
            //TODO: get address from config
        }

        $this->sender = $sender;
        if (!$this->sender) {
            $this->sender = Yii::app()->name;
        }
    }

    /**
     * Creates a PHPMailer instance and uses the application settings to prepare 
     * and send the e-mail message. Does not process the exception thrown by 
     * PHPMailer so any code that calls this method needs to catch and properly 
     * handle the exception.
     * 
     * @throws phpmailerException If something went wrong in the PHPMailer 
     * library (e.g.: wrong credentials for SMTP authentication) this exception 
     * will contain the error message.
     */
    public function send() {
        Yii::import('application.components.email.*');
        $mailer = new PHPMailer();

        $mailer->IsHTML(false);

        $mailer->AddAddress($this->to);
        $mailer->SetFrom($this->from, $this->sender);
        $mailer->Subject = $this->subject;
        $mailer->Body = $this->message;

        //TODO: get settings for SMTP
        if (false) {
            
            
            
            
            
            $mailer->IsSMTP();
            $mailer->Host = '';
            $mailer->SMTPAuth = true;
            $mailer->Username = '';
            $mailer->Password = '';
        }

        $mailer->Send();
    }

}
