<?php

/**
 * @property int $cardId
 * @property $revision
 * @property $updated
 * @property $name
 * @property $subtype
 * @property $cost
 * @property $threshold
 * @property $attack
 * @property $defense
 * @property $rules
 * @property $flavor
 * @property $imagefile
 * @property $status
 * @property $userId
 * @property $factionId
 * @property $typeId
 * @property $active
 */
class Card extends CActiveRecord {

    private $statuses = array('Concept', 'Discuss', 'Playtest', 'Approved', 'Official', 'Halt', 'Restricted', 'Rejected');

    /**
     * @return Card
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Card';
    }

    public function rules() {
        return array(
            array('cost, threshold, attack, defense, status, factionId, typeId', 'numerical', 'integerOnly' => true),
            array('name, subtype', 'length', 'max' => 50),
            array('imagefile', 'length', 'max' => 255),
            array('revision, rules, flavor', 'safe'),
            //search
            array('name, subtype, userId, factionId, typeId, status', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'userId'),
            'faction' => array(self::BELONGS_TO, 'Faction', 'factionId'),
            'type' => array(self::BELONGS_TO, 'Type', 'typeId)'),
            'comments' => array(self::HAS_MANY, 'Comment', 'cardId')
        );
    }

    public function attributeLabels() {
        return array(
            'cardId' => 'ID',
            'revision' => 'Revision',
            'updated' => 'Last Update',
            'name' => 'Name',
            'subtype' => 'Subtype',
            'cost' => 'Cost',
            'threshold' => 'Threshold',
            'attack' => 'Attack',
            'defense' => 'Defense',
            'rules' => 'Rules',
            'flavor' => 'Flavor',
            'imagefile' => 'Image',
            'status' => 'Status',
            'userId' => 'Author',
            'factionId' => 'Faction',
            'typeId' => 'Type'
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('subtype', $this->subtype, true);
        $criteria->compare('userId', $this->userId);
        $criteria->compare('factionId', $this->factionId);
        $criteria->compare('typeId', $this->typeId);
        $criteria->compare('active', 1);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    public function getStatusName($status) {
        return isset($this->statuses[$status]) ? $this->statuses[$status] : 'Unknown status';
    }

    public function getStatuses() {
        return $this->statuses;
    }

}