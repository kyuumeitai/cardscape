<?php

class AttributeForm extends CFormModel {

    public $name;
    public $multiValue;

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 150)
        );
    }

    public function attributeLabels() {
        return array(
            'name' => 'Name',
            'multiValue' => 'Multi-value'
        );
    }

}
