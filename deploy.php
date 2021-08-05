<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'https://github.com/Nke0628/dev_pra.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Set Composer
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-suggest');


// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts



host('production')
    ->hostname('133.125.36.201')
    ->port(22)
    ->user('vpsuser')
    ->stage('production')
    ->set('branch', 'master')
    ->identityFile('~/.ssh/dev_pra')
    ->set('deploy_path', '/home/www/html/production');

host('staging')
    ->hostname('133.125.36.201')
    ->port(22)
    ->user('vpsuser')
    ->stage('staging')
    ->set('branch', 'staging')
    ->identityFile('~/.ssh/dev_pra')
    ->set('deploy_path', '/home/www/html/staging');

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

//task('npm:run', function () {
//    run('cd {{release_path}} && npm install');
//    if (input()->getArgument('stage') === 'production') {
//        run('cd {{release_path}} && npm run production');
//    } else {
//        run('cd {{release_path}} && npm run development');
//    }
//});

after('deploy', 'npm:run');

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

