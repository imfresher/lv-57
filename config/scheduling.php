<?php

// Scheduling configs
return [
    'test' => '* * * * *',
    'incron' => [

    ],
    'cron' => [
        'root' => [
            // Log rotation
            // 0 0 * * * /usr/sbin/logrotate /etc/logrotate.conf
        ],
        'deploy' => [

        ],
    ],
];
