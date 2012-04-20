<?php

class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $credentials;

    public function rules() {
        return array(
            array('username, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember my login',
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->credentials = new Credentials($this->username, $this->password);
            if (!$this->credentials->authenticate())
                $this->addError('password', 'Incorrect email or password.');
        }
    }

    public function login() {
        if ($this->credentials === null) {
            $this->credentials = new Credentials($this->username, $this->password);
            $this->credentials->authenticate();
        }

        if ($this->credentials->errorCode === Credentials::ERROR_NONE) {
            //remember for 7 days
            $duration = $this->rememberMe ? 3600 * 24 * 7 : 0;
            Yii::app()->user->login($this->credentials, $duration);

            return true;
        }

        return false;
    }

}
