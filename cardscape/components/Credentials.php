<?php

class Credentials extends CBaseUserIdentity {

    private $username;
    private $password;
    private $id;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate() {
        $this->errorCode = self::ERROR_NONE;
        $user = User::model()->findByAttributes(array('username' => $this->username));

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->password !== User::hash($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->id = $user->userId;
                $this->username = $user->username;


                $sd = null;
                if (($sd = SessionData::model()->findByPk($user->userId)) === null) {
                    $sd = new SessionData();
                    $sd->userId = $user->userId;
                }

                $time = time();
                $token = md5($time . $this->id . $user->username);

                $expires = $time + (3600 * 24 * 7);

                $this->setState('token', $token);
                $this->setState('role', $user->role);

                $sd->token = $token;
                $sd->tokenExpires = date('Y-m-d H:i', $expires);
                $sd->lastActivity = date('Y-m-d H:i', $time);
                $sd->save();
            }
        }

        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->username;
    }

}