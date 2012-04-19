<?php

/**
 * @property int $factionId
 * @property string $name
 * @property int $active
 */
class Faction extends CActiveRecord {

    /**
     * @return Faction
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Faction';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 50),
            //search
            array('name', 'safe', 'on' => 'search')
        );
    }

    public function relations() {
        return array(
            'cards' => array(self::HAS_MANY, 'Card', 'factionId')
        );
    }

    public function attributeLabels() {
        return array(
            'factionId' => 'ID',
            'name' => 'Name'
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('active', 1);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

}

