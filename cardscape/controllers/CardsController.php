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
                'actions' => array('index', 'search'),
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
        if (isset($_POST['quicksearch'])) {
            //TODO: Implement quick search options.    
        }
        $this->render('index');
    }

    public function actionSuggest() {
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

        $card = new Card();
        $this->render('suggest', array(
            'card' => $card,
            'attributes' => $cardAttributes
        ));
    }

    public function actionSearch() {
        throw new CHttpException(501, 'Not implemented yet.');
    }

}
