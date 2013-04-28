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

class CardsController extends CardscapeController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'search', 'revision', 'details'),
                'users' => array('*')
            ),
            array(
                'allow',
                'actions' => array('suggest'),
                'users' => array('@')
            ),
            array(
                'deny'
            )
        );
    }

    public function actionIndex() {

        $filter = new CardListFilterForm();
        if (isset($_GET['CardListFilterForm'])) {
            $filter->author = $_GET['CardListFilterForm']['author'];
            $filter->date = $_GET['CardListFilterForm']['date'];
            $filter->status = $_GET['CardListFilterForm']['status'];
            $filter->name = $_GET['CardListFilterForm']['name'];
        }
        $this->render('index', array('filter' => $filter));
    }

    public function actionSuggest() {
        //TODO: Add proper flash messages
        $language = Yii::app()->language;

        $attributes = Attribute::model()->with(array(
                    'translations' => array('condition' => "isoCode = '{$language}'")
                ))->findAll('active = 1');

        $cardAttributes = array();
        foreach ($attributes as $attribute) {
            $translations = $attribute->translations;
            $translation = reset($translations);
            $current = array(
                'id' => $attribute->id,
                'name' => $translation->string,
                'multivalue' => $attribute->multivalue
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
                            //TODO: Add warning flash message, not error, just warning
                        }
                    } else {
                        //TODO: Add warning flash message, not error, just warning for wrong path setting
                    }
                } else {
                    //TODO: Add warning flash message, not error, just warning with file upload error
                }
            }

            if ($card->save()) {
                $cardName = new CardNameI18N();
                $cardName->isoCode = $language;
                $cardName->string = $_POST['cardname'];
                $cardName->cardId = $card->id;
                if ($cardName->save()) {
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
                                $allOK = false;
                                break;
                            }
                        }
                    } else {
                        $transaction->rollback();
                        $allOK = false;
                    }
                } else {
                    $transaction->rollback();
                    $allOK = false;
                }
            } else {
                $transaction->rollback();
                $allOK = false;
            }

            if ($allOK) {
                $transaction->commit();
                $this->redirect(array('index'));
            }
        }

        $this->render('suggest', array(
            'attributes' => $cardAttributes
        ));
    }

    public function actionSearch() {
        throw new CHttpException(501, 'Not implemented yet.');
    }

    public function actionRevision($id) {
        throw new CHttpException(501, 'Not implemented yet.');
    }

    public function actionDetails($id) {
        throw new CHttpException(501, 'Not implemented yet.');
    }

}
