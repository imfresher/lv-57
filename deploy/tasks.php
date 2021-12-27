<?php

task('deploy:current_deploy', [
    'deploy:cron',
]);

desc('Cron on localhost');
task('deploy:cron', function () {
    $result = test('[ -d {{deploy_path}}/current ] && [ -L {{deploy_path}}/current ]');
    if (! $result) {
        return;
    }

    $checkCronFile = test('[ -f {{deploy_path}}/current/deploy/cron_root ]');

    if ($checkCronFile) {
        // Write out current crontab to tmp
        run('crontab -l > /tmp/cron_root');

        // Change crontab config.
        run('cat {{deploy_path}}/current/deploy/cron_root > /tmp/cron_root');

        // Install new cron file
        run('crontab /tmp/cron_root');

        // Clear tmp
        run('rm /tmp/cron_root');
    }
});
