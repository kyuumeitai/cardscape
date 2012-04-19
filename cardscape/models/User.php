<?php

/**
 * @property int $userId
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $role
 * @property int $active
 */
class User extends CActiveRecord {

    private $roles = array('User', 'Moderator', 'GameMaker', 'Administrator');

    /**
     * @return User
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'User';
    }

    public function rules() {
        return array(
            array('username, email', 'required'),
            array('username', 'length', 'max' => 25),
            array('email', 'length', 'max' => 255),
            //search
            array(
                'username, email, role', 'safe', 'on' => 'search'
            ),
        );
    }

    public function relations() {
        return array(
            'cards' => array(self::HAS_MANY, 'ChatMessage', 'gameId'),
            'creator' => array(self::BELONGS_TO, 'User', 'player1'),
            'opponent' => array(self::BELONGS_TO, 'User', 'player2'),
            'decks' => array(self::MANY_MANY, 'Deck', 'GameDeck(gameId, deckId)'),
            'dice' => array(self::MANY_MANY, 'Dice', 'GameDice(gameId, diceId)'),
            'winner' => array(self::BELONGS_TO, 'User', 'winnerId'),
            'accept' => array(self::BELONGS_TO, 'User', 'acceptUser'),
            'counters' => array(self::MANY_MANY, 'PlayerCounter', 'GamePlayerCounter(gameId, playerCounterId)'),
            'stats' => array(self::HAS_MANY, 'DeckGameStats', 'gameId')
        );
    }

    public function attributeLabels() {
        return array(
            'userId' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'E-mail',
            'role' => 'Role'
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('active', 1);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    public function getRoleName($role) {
        return isset($this->roles[$role]) ? $this->roles[$role] : 'Unknown role';
    }

    public function getRoles() {
        return $this->roles;
    }

    public final static function hash($password) {
        return sha1($password . Yii::app()->params['hash']);
    }

}