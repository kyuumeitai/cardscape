<?php

class CardListFilterForm extends CFormModel {

    public $name;
    public $revision;
    public $revisionId;
    public $status;
    public $date;
    public $author;
    public $authorId;
    public $id;
    // Used for components that expect a model with primary key
    public $primaryKey;

    public function attributeLabels() {
        return array(
            'name' => Yii::t('cardscape', 'Name'),
            'revision' => Yii::t('cardscape', 'Revision'),
            'status' => Yii::t('cardscape', 'Status'),
            'author' => Yii::t('cardscape', 'Author'),
            'date' => Yii::t('cardscape', 'Date')
        );
    }

    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('user.username', $this->author, true);
        $criteria->compare('revisions.date', $this->date, true);
        $criteria->compare('status', $this->status);

        $cards = Card::model()->with(array(
                    'revisions',
                    'user'
                ))->findAll($criteria);

        $filtered = array();
        foreach ($cards as $card) {
            $filter = new CardListFilterForm();
            $filter->id = $card->id;
            $filter->primaryKey = $card->id;
            $filter->authorId = $card->userId;
            $filter->author = $card->user->username;
            $filter->status = $card->status;

            $revisions = $card->revisions;
            $revision = reset($revisions);
            $filter->date = strtotime($revision->date);
            $filter->revision = $revision->number;
            $filter->revisionId = $revision->id;

            $names = $card->cardAttributes(array('condition' => 'cardAttributes.identity = 1'));
            if (count($names)) {
                $language = Yii::app()->language;
                $nameAttribute = reset($names);
                $translations = $nameAttribute->translations(array('condition' => "translations.isoCode = '{$language}'"));
                $translation = reset($translations);
                $filter->name = $translation->string;
            }

            if (strlen(trim($this->name))) {
                if (mb_stripos($filter->name, $this->name, 0, 'UTF-8') !== FALSE) {
                    $filtered[] = $filter;
                }
            } else {
                $filtered[] = $filter;
            }
        }

        return new CArrayDataProvider($filtered, array(
            'sort' => array(
                'attributes' => array('name', 'revision', 'date', 'status', 'author')
            )
        ));
    }

}