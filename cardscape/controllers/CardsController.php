<?php

/* Copyright (C) 2012  Cardscape project
 * Web based collaborative platform for creating Collectible Card Games
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
 * This class should be merged with the <em>CardController</em>. I'm using it to 
 * develop the system further without having to wait for a more complete card 
 * controller.
 */
class CardsController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index, gallery'),
                'users' => array('*')
            )
        );
    }

    public function actionIndex() {
        $this->redirect(array('gallery'));
    }

    public function actionGallery() {
        //NOTE: just testing the layout, this code does nothing.
        $cards = Card::model()->findAll('active = 1');
        $this->render('gallery', array('cards' => $cards));
    }

}
