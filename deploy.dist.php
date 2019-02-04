<?php

namespace Deployer;

require_once 'recipe/common.php';
require_once 'recipe/rsync.php';

use Symfony\Component\Console\Input\InputOption;

// Disable ssh multiplexing handled by deployer.
// The dotsunited/deployer Docker image handles multiplexing by itself.
// Can be re-enabled with `dep --option=ssh_multiplexing=true`.
set('ssh_multiplexing', false);

set('repository', 'git@github.com:dotsunited/wordpress-boilerplate.git');
set('default_stage', 'production');
set('keep_releases', 3);

set('http_user', 'wordpress-boilerplate');

// ---

host('wordpress-boilerplate.localhost')
    ->user('wordpress-boilerplate')
    ->hostname('127.0.0.1')

    ->set('deploy_path', '/path/to/wordpress-boilerplate')

    ->stage('production')
    ->set('branch', 'master')

    ->set('url', 'https://wordpress-boilerplate.localhost');

host('staging.wordpress-boilerplate.localhost')
    ->user('wordpress-boilerplate')
    ->hostname('127.0.0.1')

    ->set('deploy_path', '/path/to/wordpress-boilerplate-staging')

    ->stage('staging')
    ->set('branch', 'staging')

    ->set('url', 'http://wordpress-boilerplate.localhost');

// ---

set('shared_files', ['public/.htaccess', 'public/wp-config.php']);
set('shared_dirs', ['public/wp']);
set('writable_dirs', ['public/wp/wp-content/uploads']);

option('no-local-build', null, InputOption::VALUE_NONE, 'Disable local build and deploy from current branch');

$url = null;
$stage = null;
$branch = null;
$localBuild = false;

set('rsync_src', function () use (&$stage, &$branch, &$localBuild) {
    if ($localBuild) {
        return __DIR__.'/.deploy/' . $stage . '/' . $branch . '/current';
    }

    return __DIR__;
});

task('populate_info', function () use (&$url, &$stage, &$branch) {
    $url = get('url');
    $stage = get('stage');
    $branch = get('branch');
});

task('build', function () use (&$stage, &$branch, &$localBuild) {
    if (input()->getOption('no-local-build')) {
        $question = 'Local build disabled with --no-local-build, are you sure you want deploy from current branch';
        $comment  = '  Local build disabled with <fg=cyan>--no-local-build</fg=cyan>, deploying from current branch';

        try {
            $currentBranch = runLocally('git rev-parse --abbrev-ref HEAD');

            $question .= ' ' . $currentBranch;
            $comment .= ' <fg=magenta>' . $currentBranch . '</fg=magenta>';
        } catch (\Throwable $exception) {
        }

        if (askConfirmation($question . '?', true)) {
            writeln($comment);
            return;
        }
    }

    $localBuild = true;

    writeln('  Local build for stage <fg=magenta>' . $stage . '</fg=magenta> and branch <fg=magenta>' . $branch . '</fg=magenta>');

    set('deploy_path', __DIR__.'/.deploy/' . $stage . '/' . $branch);
    set('keep_releases', 2);
    set('stage', $stage);
    set('branch', $branch);

    invoke('deploy:prepare');
    invoke('deploy:release');
    invoke('deploy:update_code');
    //invoke('deploy:vendors');
    invoke('deploy:symlink');
    invoke('cleanup');
})->local()->desc('Build project');

task('reset_opcache', function () use (&$url) {
    runLocally('curl --silent --head --location "' . $url . '/deploy/opcache-reset.php?key=mFBuhxwIiY1lSq43N2bSLdJAZSbJURZEKQxMRSxSPQ9sSOI5JUh9xqDv0WfPGTRn"');
})->local()->desc('Reset the opcache on the remote server via HTTP request');

task('clear_cache', function () {
    $sudo  = get('clear_use_sudo') ? 'sudo' : '';

    run("$sudo rm -rf {{release_path}}/public/wp/wp-content/cache/*");
})->desc('Clear wordpress cache');

task('deploy', [
    'deploy:info',
    'populate_info',
    'build',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'rsync:warmup',
    'rsync',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');

after('deploy', 'success');

after('deploy', 'clear_cache');

after('deploy:failed', 'deploy:unlock');
