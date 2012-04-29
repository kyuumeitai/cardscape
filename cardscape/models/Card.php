<?php

/**
 * This is the model class for table "Card".
 *
 * The followings are the available columns in table 'Card':
 * @property string $cardId
 * @property integer $status
 * @property integer $active
 * @property string $userId
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Attribute[] $attributes
 * @property User[] $users
 * @property Comment[] $comments
 * @property ProjectCard $projectCard
 * @property Revision[] $revisions
 */
class Card extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Card the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId', 'required'),
			array('status, active', 'numerical', 'integerOnly'=>true),
			array('userId', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cardId, status, active, userId', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'attributes' => array(self::MANY_MANY, 'Attribute', 'CardAttribute(cardId, attributeId)'),
			'users' => array(self::MANY_MANY, 'User', 'CardUser(cardId, userId)'),
			'comments' => array(self::HAS_MANY, 'Comment', 'cardId'),
			'projectCard' => array(self::HAS_ONE, 'ProjectCard', 'cardId'),
			'revisions' => array(self::HAS_MANY, 'Revision', 'cardId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cardId' => 'Card',
			'status' => 'Status',
			'active' => 'Active',
			'userId' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('cardId',$this->cardId,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('active',$this->active);
		$criteria->compare('userId',$this->userId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}