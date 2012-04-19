<?php

/**
 * @property int $commentId
 * @property int $userId
 * @property int $cardId
 * @property string $date
 * @property string $message
 */
class Comment extends CActiveRecord {

    /**
     * @return Comment
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Comment';
    }

    public function rules() {
        return array(
            array('message, date', 'sage'),
        );
    }

    public function relations() {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'userId'),
            'card' => array(self::BELONGS_TO, 'Card', 'cardId')
        );
    }

    public function attributeLabels() {
        return array(
            'commentId' => 'ID',
            'userId' => 'User',
            'cardId' => 'Card',
            'date' => 'Date',
            'message' => 'Message'
        );
    }

}