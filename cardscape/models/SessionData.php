<?php

class SessionData extends CActiveRecord {

    /**
     * @return SessionData
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'SessionData';
    }

}