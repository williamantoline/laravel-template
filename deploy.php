<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config
set('keep_releases', 3);

set('repository', 'https://github.com/williamantoline/laravel-template.git');
set('update_code_strategy', 'clone');

//add('shared_files', []);
//add('shared_dirs', []);
//add('writable_dirs', []);


task('my_task', function () {
    run('cd {{alias}} && composer update > b');
});


// Hosts
host('playground.com')
    ->setLabels(['env' => 'production'])
    ->setHostname('103.76.120.194')
    ->setRemoteUser('williamantoline')
    ->setIdentityFile('~/.ssh/id_rsa')
    ->setDeployPath('~/{{alias}}')
    ->set('stage', 'production')
    ->set('branch', 'deploy');

host('staging.playground.com')
    ->setLabels(['env' => 'staging'])
    ->setHostname('103.76.120.194')
    ->setRemoteUser('williamantoline')
    ->setIdentityFile('~/.ssh/id_rsa')
    ->setDeployPath('~/{{alias}}')
    ->set('stage', 'staging')
    ->set('branch', 'deploy');

// Hooks
after('deploy:failed', 'deploy:unlock');
