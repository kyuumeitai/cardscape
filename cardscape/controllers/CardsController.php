<?php

/* CardsController.php
 * 
 * This file is part of Cardscape.
 * Web based collaborative platform for creating Collectible Card Games.
 *
 * Copyright (c) 2011 - 2013, the Cardscape team.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class CardsController extends CSController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'search', 'details'),
                'users' => array('*')
            ),
            array(
                'allow',
                'actions' => array('suggest', 'comment', 'revisions', 'update', 'newbased'),
                'users' => array('@')
            ),
            array(
                'allow',
                'actions' => array('delete', 'deleterevision'),
                'expression' => '(!Yii::app()->user->isGuest && $user->role == "administrator")'
            ),
            array(
                'deny'
            )
        );
    }

    /**
     * 
     * @param integer $id
     * @return Card
     * 
     * @throws CHttpException
     */
    private function loadCardModel($id) {
        if (($card = Card::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, Yii::t('cardscape', 'Invalid card. You\'re trying to load a card that does not exist.'));
        }

        return $card;
    }

    /**
     * 
     * @param integer $id
     * @return Revision
     * 
     * @throws CHttpException
     */
    private function loadRevisionModel($id) {
        if (($revision = Revision::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, Yii::t('cardscape', 'Invalid revision. You\'re trying to load a revision that does not exist.'));
        }

        return $revision;
    }

    public function actionIndex() {
        $filter = new CardListFilterForm();
        if (isset($_GET['CardListFilterForm'])) {
            $filter->name = $_GET['CardListFilterForm']['name'];
            $filter->author = $_GET['CardListFilterForm']['author'];
            $filter->date = $_GET['CardListFilterForm']['date'];
            $filter->status = $_GET['CardListFilterForm']['status'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionSuggest() {
        if (isset($_POST['Suggestion'])) {
            $allOK = true;

            $card = new Card();
            $transaction = $card->dbConnection->beginTransaction();
            $card->userId = Yii::app()->user->id;

            if (isset($_FILES['image'])) {
                $image = (object) $_FILES['image'];
                if ($image->error == 0) {
                    $base = (Yii::getPathOfAlias('webroot') . '/' . Yii::app()->params['cardscapeDataDir']);
                    if (is_dir($base)) {
                        $name = (md5($image->name) . strrchr($image->name, '.'));
                        $file = ($base . '/' . $name);
                        if (move_uploaded_file($image->tmp_name, $file)) {
                            $card->image = $name;
                        } else {
                            $this->flash('warning', Yii::t('cardscape', 'Unable to save uploaded image.'));
                        }
                    } else {
                        $this->flash('success', Yii::t('cardscape', 'Upload path is incorrect, images will not be saved.'));
                    }
                } else {
                    $this->flash('success', Yii::t('cardscape', 'Unable to upload the selected image file.'));
                }
            }

            if ($card->save()) {
                $revision = new Revision();
                $revision->cardId = $card->id;
                $revision->userId = $card->userId;
                $revision->date = date('Y-m-d H:i:s');
                if ($revision->save()) {
                    foreach ($_POST['AttributeValue'] as $key => $value) {
                        $cardAttribute = new CardAttribute();
                        $cardAttribute->cardId = $card->id;
                        $cardAttribute->attributeId = (int) $key;

                        $revisionAttribute = new RevisionAttribute();
                        $revisionAttribute->revisionId = $revision->id;
                        $revisionAttribute->attributeId = (int) $key;
                        $revisionAttribute->value = $value;

                        if (!$cardAttribute->save() || !$revisionAttribute->save()) {
                            $transaction->rollback();

                            $this->flash('error', Yii::t('cardscape', 'Unable to save card\'s attributes.'));
                            $allOK = false;
                            break;
                        }
                    }
                } else {
                    $transaction->rollback();

                    $this->flash('error', Yii::t('cardscape', 'Could not save the card\'s revision.'));
                    $allOK = false;
                }
            } else {
                $transaction->rollback();

                $this->flash('error', Yii::t('cardscape', 'Unable to save the new card suggestion.'));
                $allOK = false;
            }

            if ($allOK) {
                $transaction->commit();

                $this->flash('success', Yii::t('cardscape', 'New suggestion registered.'));
                $this->redirect(array('details', 'id' => $card->id));
            }
        }

        $language = Yii::app()->language;
        $attributes = Attribute::model()->with(array(
                    'translations' => array(
                        'condition' => "translations.isoCode = '{$language}'",
                        'order' => '`t`.`order` ASC'
                    )
                ))->findAll('active = 1');

        $cardAttributes = array();
        foreach ($attributes as $attribute) {
            $translations = $attribute->translations;
            $translation = reset($translations);
            $current = array(
                'id' => $attribute->id,
                'name' => $translation->string,
                'multivalue' => $attribute->multivalue,
                'large' => $attribute->large
            );

            if ($attribute->multivalue) {
                $optionTranslations = AttributeOptionI18N::model()->with(array(
                            'attributeOption' => array('condition' => 'attributeId = ' . $attribute->id)
                        ))->findAll('isoCode = :lang', array(':lang' => $language));

                $current['options'] = array();
                foreach ($optionTranslations as $optionTranslation) {
                    $current['options'][$optionTranslation->attributeOption->key] =
                            $optionTranslation->string;
                }
            }

            $cardAttributes[] = (object) $current;
        }

        $this->render('suggest', array('attributes' => $cardAttributes));
    }

    public function actionDetails($id) {
        $card = $this->loadCardModel($id);
        $language = Yii::app()->language;

        $criteria = new CDbCriteria();
        $criteria->order = '`t`.`order` ASC';
        $criteria->compare('active', 1);

        $attributes = Attribute::model()->with(array(
                    'translations' => array(
                        'condition' => "translations.isoCode = '{$language}'"
                    )
                ))->findAll($criteria);

        $revisions = $card->revisions;
        $revision = reset($revisions);

        $cardAttributes = array();
        foreach ($attributes as $attribute) {
            $translations = $attribute->translations;
            $translation = reset($translations);

            $current = array(
                'id' => $attribute->id,
                'name' => $translation->string,
            );

            foreach ($revision->values as $value) {
                if ($value->attributeId == $attribute->id) {
                    $current['value'] = $value->value;
                    break;
                }
            }

            if ($attribute->multivalue) {
                $option = AttributeOption::model()->with(array(
                            'translations' => array('condition' => "translations.isoCode = '{$language}'")
                        ))->find('attributeId = :attribute', array(':attribute' => $attribute->id));

                $translations = $option->translations;
                $translation = reset($translations);
                $current['value'] = $translation->string;
            }

            $cardAttributes[] = (object) $current;
        }
        $this->render('details', array(
            'card' => $card,
            'attributes' => $cardAttributes
        ));
    }

    public function actionComment($id) {
        $card = $this->loadCardModel($id);

        if (isset($_POST['commentbox']) && ($message = trim($_POST['commentbox'])) != '') {
            $comment = new Comment();
            $comment->cardId = $card->id;
            $comment->message = $message;
            $comment->date = date('Y-m-d H:i:s');
            $comment->userId = Yii::app()->user->id;
            if ($comment->save()) {
                $this->flash('success', Yii::t('cardscape', 'Comment registered.'));
            } else {
                $this->flash('success', Yii::t('cardscape', 'Unable to save comment.'));
            }
        }
        $this->redirect(array('details', 'id' => $id));
    }

    public function actionUpdate($id) {
        $card = $this->loadCardModel($id);

        if (isset($_POST['Update'])) {
            $allOK = true;
            $transaction = $card->dbConnection->beginTransaction();

            if (isset($_FILES['image'])) {
                $image = (object) $_FILES['image'];
                if ($image->error == 0) {
                    $base = (Yii::getPathOfAlias('webroot') . '/' . Yii::app()->params['cardscapeDataDir']);
                    if (is_dir($base)) {
                        $name = (md5($image->name) . strrchr($image->name, '.'));
                        $file = ($base . '/' . $name);
                        if (move_uploaded_file($image->tmp_name, $file)) {
                            $card->image = $name;
                        } else {
                            $this->flash('warning', Yii::t('cardscape', 'Unable to save uploaded image.'));
                        }
                    } else {
                        $this->flash('success', Yii::t('cardscape', 'Upload path is incorrect, images will not be saved.'));
                    }
                } else {
                    $this->flash('success', Yii::t('cardscape', 'Unable to upload the selected image file.'));
                }
            }

            if ($card->save()) {
                $revision = new Revision();
                $revision->cardId = $card->id;
                $revision->userId = $card->userId;
                $revision->date = date('Y-m-d H:i:s');
                if ($revision->save()) {
                    foreach ($_POST['AttributeValue'] as $key => $value) {
                        $cardAttribute = new CardAttribute();
                        $cardAttribute->cardId = $card->id;
                        $cardAttribute->attributeId = (int) $key;

                        $revisionAttribute = new RevisionAttribute();
                        $revisionAttribute->revisionId = $revision->id;
                        $revisionAttribute->attributeId = (int) $key;
                        $revisionAttribute->value = $value;

                        if (!$cardAttribute->save() || !$revisionAttribute->save()) {
                            $transaction->rollback();

                            $this->flash('error', Yii::t('cardscape', 'Unable to save card\'s attributes.'));
                            $allOK = false;
                            break;
                        }
                    }
                } else {
                    $transaction->rollback();

                    $this->flash('error', Yii::t('cardscape', 'Could not save the card\'s revision.'));
                    $allOK = false;
                }
            } else {
                $transaction->rollback();

                $this->flash('error', Yii::t('cardscape', 'Unable to update card.'));
                $allOK = false;
            }

            if ($allOK) {
                $transaction->commit();

                $this->flash('success', Yii::t('cardscape', 'Card updated.'));
                $this->redirect(array('details', 'id' => $card->id));
            }
        }

        $language = Yii::app()->language;

        $criteria = new CDbCriteria();
        $criteria->order = '`t`.`order` ASC';
        $criteria->compare('active', 1);

        $attributes = Attribute::model()->with(array(
                    'translations' => array(
                        'condition' => "translations.isoCode = '{$language}'"
                    )
                ))->findAll($criteria);

        $revisions = $card->revisions;
        $revision = reset($revisions);

        $cardAttributes = array();
        foreach ($attributes as $attribute) {
            $translations = $attribute->translations;
            $translation = reset($translations);

            RevisionAttribute::model()->find('revisionId = :rev AND attributeId = :attr', array(
                ':rev' => $revision->id,
                ':attr' => $attribute->id
            ));

            $current = array(
                'id' => $attribute->id,
                'name' => $translation->string,
                'multivalue' => $attribute->multivalue,
                'large' => $attribute->large
            );

            foreach ($revision->values as $value) {
                if ($value->attributeId == $attribute->id) {
                    $current['value'] = $value->value;
                    break;
                }
            }

            if ($attribute->multivalue) {
                $optionTranslations = AttributeOptionI18N::model()->with(array(
                            'attributeOption' => array('condition' => 'attributeId = ' . $attribute->id)
                        ))->findAll('isoCode = :lang', array(':lang' => $language));

                $current['options'] = array();
                foreach ($optionTranslations as $optionTranslation) {
                    $current['options'][$optionTranslation->attributeOption->key] =
                            $optionTranslation->string;
                }

                $option = AttributeOption::model()->with(array(
                            'translations' => array('condition' => "translations.isoCode = '{$language}'")
                        ))->find('attributeId = :attribute', array(':attribute' => $attribute->id));

                $translations = $option->translations;
                $translation = reset($translations);
                $current['value'] = $translation->string;
            }

            $cardAttributes[] = (object) $current;
        }

        $this->render('update', array(
            'card' => $card,
            'attributes' => $cardAttributes
        ));
    }

    public function actionRevisions($id) {
        $card = $this->loadCardModel($id);
        $language = Yii::app()->language;
        $revisions = array();
        $firstRevisionId = null;

        foreach ($card->revisions as $revision) {
            if (!$firstRevisionId) {
                $firstRevisionId = $revision->id;
            }
            $attributes = array();
            foreach ($revision->attributes as $attribute) {
                $relation = RevisionAttribute::model()->find('revisionId = :rev AND attributeId = :attr', array(
                    ':rev' => $revision->id,
                    ':attr' => $attribute->id
                ));

                if ($relation != null) {
                    $translations = $attribute->translations(array('condition' => "translations.isoCode = '{$language}'"));
                    $translation = reset($translations);

                    $attributes[] = (object) array(
                                'name' => $translation->string,
                                'value' => $relation->value
                    );
                }
            }

            $revisions[] = (object) array(
                        'id' => $revision->id,
                        'number' => $revision->number,
                        'date' => $revision->date,
                        'author' => $revision->user->username,
                        'authorId' => $revision->userId,
                        'attributes' => $attributes
            );
        }

        // get the current card's name
        $names = $card->cardAttributes(array('condition' => 'cardAttributes.identity = 1'));
        if (count($names)) {
            $nameAttribute = reset($names);
            $nameValue = RevisionAttribute::model()->find('revisionId = :rev AND attributeId = :attr', array(
                ':rev' => $firstRevisionId,
                ':attr' => $nameAttribute->id));

            if ($nameValue) {
                $name = $nameValue->value;
            }
        }

        $this->render('revisions', array(
            'card' => $card,
            'cardName' => $name,
            'revisions' => $revisions
        ));
    }

    public function actionNewBased($id) {
        $card = $this->loadCardModel($id);

        if (isset($_POST['NewBased'])) {
            $allOK = true;
            $based = new Card();
            $based->ancestorId = $card->id;
            $based->userId = Yii::app()->user->id;
            $transaction = $based->dbConnection->beginTransaction();

            if (isset($_FILES['image'])) {
                $image = (object) $_FILES['image'];
                if ($image->error == 0) {
                    $base = (Yii::getPathOfAlias('webroot') . '/' . Yii::app()->params['cardscapeDataDir']);
                    if (is_dir($base)) {
                        $name = (md5($image->name) . strrchr($image->name, '.'));
                        $file = ($base . '/' . $name);
                        if (move_uploaded_file($image->tmp_name, $file)) {
                            $based->image = $name;
                        } else {
                            $this->flash('warning', Yii::t('cardscape', 'Unable to save uploaded image.'));
                        }
                    } else {
                        $this->flash('success', Yii::t('cardscape', 'Upload path is incorrect, images will not be saved.'));
                    }
                } else {
                    $this->flash('success', Yii::t('cardscape', 'Unable to upload the selected image file.'));
                }
            }

            if ($based->save()) {
                $revision = new Revision();
                $revision->cardId = $based->id;
                $revision->userId = $based->userId;
                $revision->date = date('Y-m-d H:i:s');
                if ($revision->save()) {
                    foreach ($_POST['AttributeValue'] as $key => $value) {
                        $cardAttribute = new CardAttribute();
                        $cardAttribute->cardId = $based->id;
                        $cardAttribute->attributeId = (int) $key;

                        $revisionAttribute = new RevisionAttribute();
                        $revisionAttribute->revisionId = $revision->id;
                        $revisionAttribute->attributeId = (int) $key;
                        $revisionAttribute->value = $value;

                        if (!$cardAttribute->save() || !$revisionAttribute->save()) {
                            $transaction->rollback();

                            $this->flash('error', Yii::t('cardscape', 'Unable to save card\'s attributes.'));
                            $allOK = false;
                            break;
                        }
                    }
                } else {
                    $transaction->rollback();

                    $this->flash('error', Yii::t('cardscape', 'Could not save the card\'s revision.'));
                    $allOK = false;
                }
            } else {
                $transaction->rollback();

                $this->flash('error', Yii::t('cardscape', 'Unable to save new card.'));
                $allOK = false;
            }

            if ($allOK) {
                $transaction->commit();

                $this->flash('success', Yii::t('cardscape', 'Card created.'));
                $this->redirect(array('details', 'id' => $based->id));
            }
        }

        $language = Yii::app()->language;

        $criteria = new CDbCriteria();
        $criteria->order = '`t`.`order` ASC';
        $criteria->compare('active', 1);

        $attributes = Attribute::model()->with(array(
                    'translations' => array(
                        'condition' => "translations.isoCode = '{$language}'"
                    )
                ))->findAll($criteria);

        $revisions = $card->revisions;
        $revision = reset($revisions);

        $cardAttributes = array();
        foreach ($attributes as $attribute) {
            $translations = $attribute->translations;
            $translation = reset($translations);

            RevisionAttribute::model()->find('revisionId = :rev AND attributeId = :attr', array(
                ':rev' => $revision->id,
                ':attr' => $attribute->id
            ));

            $current = array(
                'id' => $attribute->id,
                'name' => $translation->string,
                'multivalue' => $attribute->multivalue,
                'large' => $attribute->large
            );

            foreach ($revision->values as $value) {
                if ($value->attributeId == $attribute->id) {
                    $current['value'] = $value->value;
                    break;
                }
            }

            if ($attribute->multivalue) {
                $optionTranslations = AttributeOptionI18N::model()->with(array(
                            'attributeOption' => array('condition' => 'attributeId = ' . $attribute->id)
                        ))->findAll('isoCode = :lang', array(':lang' => $language));

                $current['options'] = array();
                foreach ($optionTranslations as $optionTranslation) {
                    $current['options'][$optionTranslation->attributeOption->key] =
                            $optionTranslation->string;
                }

                $option = AttributeOption::model()->with(array(
                            'translations' => array('condition' => "translations.isoCode = '{$language}'")
                        ))->find('attributeId = :attribute', array(':attribute' => $attribute->id));

                $translations = $option->translations;
                $translation = reset($translations);
                $current['value'] = $translation->string;
            }

            $cardAttributes[] = (object) $current;
        }

        $this->render('newbased', array(
            'card' => $card,
            'attributes' => $cardAttributes
        ));
    }

    public function actionDeleteRevision($id) {
        $revision = $this->loadRevisionModel($id);
        $card = $revision->card;

        if (count($card->revisions) == 1) {
            throw new CHttpException(400, 'This is the only revision in for the owner card, you cannot delete this revision.');
        }

        $revision->active = 0;
        if (!$revision->save()) {
            //TODO: show error flash message
        }

        $this->redirect(array('revisions', 'id' => $card->id));
    }

    public function actionDelete($id) {
        $comment = $this->loadCardModel($id);

        throw new CHttpException(501, 'Not implemented yet.');
    }

}
