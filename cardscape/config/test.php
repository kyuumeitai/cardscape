<?php

return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.dev.php'), array(
            'components' => array(
                'fixture' => array(
                    'class' => 'system.test.CDbFixtureManager',
                ),
            /* uncomment the following to provide test database connection
              'db'=>array(
              'connectionString'=>'DSN for test database',
              ),
             */
            ),
                )
);
