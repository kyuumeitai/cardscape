<?php

class RegisterForm extends CFormModel {

    public $email;
    public $password;
    public $password_repeat;
    public $username;

    public function rules() {
        return array(
            array('email, password, password_repeat', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'User'),
            array('password', 'compare'),
            array('username', 'length', 'max' => 25),
            array('email', 'length', 'max' => 255)
        );
    }

    public function attributeLabels() {
        return array(
            'email' => 'E-mail',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
            'username' => 'Username'
        );
    }

    public function register() {
        $new = new User();

        $new->email = $this->email;
        $new->password = User::hash($this->password);
        $new->username = $this->username;

        return $new->save();
    }

}
