<?php

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
