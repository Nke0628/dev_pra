<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'https://github.com/Nke0628/dev_pra.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);


// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('133.125.36.201')
    ->port(22)
    ->user('vpsuser')
    ->stage('staging')
    ->set('branch', 'staging')
    ->identityFile('~/.ssh/dev_pra')
    ->set('deploy_path', '/home/www/html/staging');

host('133.125.36.201')
    ->port(22)
    ->user('vpsuser')
    ->stage('production')
    ->set('branch', 'master')
    ->identityFile('~/.ssh/dev_pra')
    ->set('deploy_path', '/home/www/html/production');

// Tasks

desc('Deploy your dev_app');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

desc('test_task');
task('test_task', function () {
    $result = run('cd /var/www/html; pwd');
    writeln("Current dir: $result");
});

after('deploy', 'test_task');

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

