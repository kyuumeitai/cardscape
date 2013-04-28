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

        $criteria->compare('names.string', $this->name, true);
        $criteria->compare('user.username', $this->author, true);
        $criteria->compare('revisions.date', $this->date, true);
        $criteria->compare('status', $this->status);

        $language = Yii::app()->language;
        $cards = Card::model()->with(array(
                    'revisions',
                    'user',
                    'names' => array(
                        'condition' => "isoCode = '{$language}'"
                    )
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

            $names = $card->names;
            $name = reset($names);
            $filter->name = $name->string;

            $filtered[] = $filter;
        }

        return new CArrayDataProvider($filtered, array(
            'sort' => array(
                'attributes' => array('name', 'revision', 'date', 'status', 'author')
            )
        ));
    }

}