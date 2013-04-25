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

class AttributesController extends CardscapeController {

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
     * 
     * @param integer $id
     * @return Attribute
     * @throws CHttpException
     */
    private function loadAttributeModel($id) {
        if (($attribute = Attribute::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, Yii::t('cardscape', 'Invalid attribute. You\'re trying to load an attribute that does not exist.'));
        }

        return $attribute;
    }

    public function actionIndex() {
        $filter = new AttributeI18N('search');
        if (isset($_GET['AttributeI18N'])) {
            $filter->attributes = $_GET['AttributeI18N'];
        }

        $this->render('index', array('filter' => $filter));
    }

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
                                $allOK = false;
                                break;
                            }

                            $attributeOptionI18N = new AttributeOptionI18N();
                            $attributeOptionI18N->attributeOptionId = $attributeOption->id;
                            $attributeOptionI18N->string = trim($_POST['AttributeOptionI18N']['string'][$index]);
                            $attributeOptionI18N->isoCode = $language;
                            if (!$attributeOptionI18N->save()) {
                                $transaction->rollback();
                                $allOK = false;
                                break;
                            }
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

            if ($allOK) {
                $transaction->commit();
                $this->redirect(array('update', 'id' => $attribute->id));
            }
        }

        //TODO: Add proper flash messages.
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
                                $allOK = false;
                                break;
                            }
                        }
                        if (!$allOK) {
                            break;
                        }

                        if (!$option->delete()) {
                            $transaction->rollback();
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
                                $allOK = false;
                                break;
                            }

                            $attributeOptionI18N = new AttributeOptionI18N();
                            $attributeOptionI18N->attributeOptionId = $attributeOption->id;
                            $attributeOptionI18N->string = trim($_POST['AttributeOptionI18N']['string'][$index]);
                            $attributeOptionI18N->isoCode = $language;
                            if (!$attributeOptionI18N->save()) {
                                $transaction->rollback();
                                $allOK = false;
                                break;
                            }
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

            if ($allOK) {
                $transaction->commit();
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

        //TODO: Add proper flash messages.
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
            $attribute->save();
            //TODO: Add proper flash messages.

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('cardscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

}
