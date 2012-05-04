<?php $this->title = 'Administration'; ?>

<h1>Administration</h1>

<?php
$this->widget('CTabView', array(
    'activeTab' => 'email',
    'tabs' => array(
        'email' => array(
            'title' => 'E-mail',
            'view' => '_email',
            'data' => array('seForm' => $seForm)
        ),
        'users' => array(
            'title' => 'Users',
            'view' => '_user',
            'data' => array('suForm' => $suForm)
        ),
        'system' => array(
            'title' => 'System',
            'view' => '_system',
            'data' => array(
                'ssForm' => $ssForm,
                'languages' => $languages
            )
        )
    )
));

