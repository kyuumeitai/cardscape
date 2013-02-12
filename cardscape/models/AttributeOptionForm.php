<?php

/* AttributeOptionForm.php
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

class AttributeOptionForm extends CFormModel {

    private $name;
    private $value;

    public function rules() {
        return array(
            array('name, value', 'required'),
            array('name', 'length', 'max' => 150),
            array('value', 'length', 'max' => 15)
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'name' => 'Option Name',
            'value' => 'Value'
        );
    }

}
