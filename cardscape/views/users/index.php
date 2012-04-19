<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'username',
        'email:email',
        array(
            'name' => 'role',
            'value' => '$data->getRoleName($data->role)'
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));