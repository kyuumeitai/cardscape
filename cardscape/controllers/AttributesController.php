<?php

/* AttributesController.php
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

/**
 * A card's attributes will require the use of a minimum of 2 entities but can also
 * require as much as 4. The first entity will be the <em>Attribute</em> that 
 * keeps track on only the control data, the next entity that is visible to users 
 * is the <em>AttributeI18N</em> that will store the name of the attribute for 
 * a given language.
 * 
 * If attributes allow for multiple values (usually drawn as a drop-down box) the 
 * <em>AttributeOption</em> and the <em>AttributeOptionI18N</em> will also be 
 * required. Thus this controller handles mostly the creation of attributes by 
 * using the 4 entities (and tables) mentioned.
 * 
 * Also important to notice, this attribute management is, so far, only for the 
 * platform language and does not provide translation support.
 * 
 * This controller provides features for administrators only.
 */
class AttributesController extends CSController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {

        return array(
            array(
                'allow',
                'actions' => array('index', 'create', 'update', 'delete'),
                'expression' => '(!Yii::app()->user->isGuest && $user->role == "administrator")'
            ),
            array(
                'deny'
            )
        );
    }

    /**
     * Loads an existing <em>Attribute</em> record that is identified by the provided 
     * ID.
     * 
     * @param integer $id The database ID for the record we want to load.
     * @return Attribute The Attribute we loaded.
     * 
     * @throws CHttpException If the ID does not identify a valid (existing) record.
     */
    private function loadAttributeModel($id) {
        if (($attribute = Attribute::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, Yii::t('cardscape', 'Invalid attribute. You\'re trying to load an attribute that does not exist.'));
        }

        return $attribute;
    }

    /**
     * Lists all existing attributes and filters them by the current platform 
     * language.
     */
    public function actionIndex() {
        $filter = new AttributeI18N('search');
        if (isset($_GET['AttributeI18N'])) {
            $filter->attributes = $_GET['AttributeI18N'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Handles creation of new <em>Attribute</em> records and their related data.
     */
    public function actionCreate() {
        $attribute = new Attribute();
        $attributeI18N = new AttributeI18N();
        $options = array(0 => '');
        $optionsI18N = array(0 => '');

        if (isset($_POST['Attribute'])) {
            $allOK = true;
            $language = Yii::app()->language;

            $attribute->attributes = $_POST['Attribute'];
            $attributeI18N->attributes = $_POST['AttributeI18N'];

            $transaction = $attribute->dbConnection->beginTransaction();
            if ($attribute->save()) {
                $attributeI18N->attributeId = $attribute->id;
                $attributeI18N->isoCode = $language;
                if ($attributeI18N->save()) {
                    if ($attribute->multivalue) {
                        foreach ($_POST['AttributeOption']['key'] as $index => $value) {
                            $attributeOption = new AttributeOption();
                            $attributeOption->attributeId = $attribute->id;
                            $attributeOption->key = trim($value);
                            if (!$attributeOption->save()) {
                                $transaction->rollback();

                                $this->flash('error', Yii::t('cardscape', 'Unable to save attribute options.'));
                                $allOK = false;
                                break;
                            }

                            $attributeOptionI18N = new AttributeOptionI18N();
                            $attributeOptionI18N->attributeOptionId = $attributeOption->id;
                            $attributeOptionI18N->string = trim($_POST['AttributeOptionI18N']['string'][$index]);
                            $attributeOptionI18N->isoCode = $language;
                            if (!$attributeOptionI18N->save()) {
                                $transaction->rollback();

                                $this->flash('error', Yii::t('cardscape', 'Unable to save one of the options\' translation.'));
                                $allOK = false;
                                break;
                            }
                        }
                    }
                } else {
                    $transaction->rollback();
                    $this->flash('error', Yii::t('cardscape', 'Unable to save attribute translation.'));
                    $allOK = false;
                }
            } else {
                $transaction->rollback();

                $this->flash('error', Yii::t('cardscape', 'Unable to save attribute.'));
                $allOK = false;
            }

            if ($allOK) {
                $transaction->commit();

                $this->flash('success', Yii::t('cardscape', 'New attribute created.'));
                $this->redirect(array('update', 'id' => $attribute->id));
            }
        }

        $this->render('create', array(
            'attribute' => $attribute,
            'attributeI18N' => $attributeI18N,
            'options' => $options,
            'optionsI18N' => $optionsI18N
        ));
    }

    public function actionUpdate($id) {
        $attribute = $this->loadAttributeModel($id);

        $language = Yii::app()->language;
        $translations = $attribute->translations(array('condition' => "isoCode = '{$language}'"));
        $attributeI18N = reset($translations);

        if (isset($_POST['Attribute'])) {
            $allOK = true;
            $language = Yii::app()->language;

            $attribute->attributes = $_POST['Attribute'];
            $attributeI18N->attributes = $_POST['AttributeI18N'];

            $transaction = $attribute->dbConnection->beginTransaction();
            if ($attribute->save()) {
                if ($attributeI18N->save()) {
                    //lets just remove every option to make updates simpler, 
                    //if anything fails just rollback.
                    foreach ($attribute->options as $option) {
                        foreach ($option->translations as $translation) {
                            if (!$translation->delete()) {
                                $transaction->rollback();

                                $this->flash('error', Yii::t('cardscape', 'Could not delete old translation.'));
                                $allOK = false;
                                break;
                            }
                        }
                        if (!$allOK) {
                            break;
                        }

                        if (!$option->delete()) {
                            $transaction->rollback();

                            $this->flash('error', Yii::t('cardscape', 'Could not delete old attribute option.'));
                            $allOK = false;
                            break;
                        }
                    }

                    if ($allOK && $attribute->multivalue) {
                        foreach ($_POST['AttributeOption']['key'] as $index => $value) {
                            $attributeOption = new AttributeOption();
                            $attributeOption->attributeId = $attribute->id;
                            $attributeOption->key = trim($value);
                            if (!$attributeOption->save()) {
                                $transaction->rollback();

                                $this->flash('error', Yii::t('cardscape', 'Unable to save attribute options.'));
                                $allOK = false;
                                break;
                            }

                            $attributeOptionI18N = new AttributeOptionI18N();
                            $attributeOptionI18N->attributeOptionId = $attributeOption->id;
                            $attributeOptionI18N->string = trim($_POST['AttributeOptionI18N']['string'][$index]);
                            $attributeOptionI18N->isoCode = $language;
                            if (!$attributeOptionI18N->save()) {
                                $transaction->rollback();

                                $this->flash('error', Yii::t('cardscape', 'Unable to save one of the options\' translation.'));
                                $allOK = false;
                                break;
                            }
                        }
                    }
                } else {
                    $transaction->rollback();

                    $this->flash('error', Yii::t('cardscape', 'Unable to save attribute\'s translation.'));
                    $allOK = false;
                }
            } else {
                $transaction->rollback();

                $this->flash('error', Yii::t('cardscape', 'Unable to save attribute.'));
                $allOK = false;
            }

            if ($allOK) {
                $transaction->commit();

                $this->flash('success', Yii::t('cardscape', 'New attribute created.'));
                $this->redirect(array('update', 'id' => $attribute->id));
            }
        }

        $options = array();
        $optionsI18N = array();
        if ($attribute->multivalue) {
            foreach ($attribute->options as $option) {
                $options[] = $option->key;
                $translations = $option->translations(array('condition' => "isoCode = '{$language}'"));
                $translation = reset($translations);
                $optionsI18N[] = $translation->string;
            }
        }

        $this->render('update', array(
            'attribute' => $attribute,
            'attributeI18N' => $attributeI18N,
            'options' => $options,
            'optionsI18N' => $optionsI18N
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest && (($attribute = $this->loadAttributeModel($id)) !== null)) {
            $attribute->active = 0;

            echo json_encode(array('success' => $attribute->save()));
        } else {
            throw new CHttpException(400, Yii::t('cardscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

}
