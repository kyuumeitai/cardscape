<h2>Card Types</h2>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));