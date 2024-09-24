<?php

namespace DotsUnited;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Json\JsonManipulator;
use Composer\Package\Locker;
use Composer\Script\Event;

class ComposerScripts
{
    public static function postCreateProject(Event $event)
    {
        $args = $event->getArguments();

        $io = $event->getIO();

        $projectIdentifier = isset($args['directory']) ? $args['directory'] : 'my-project';
        $projectIdentifier = $io->ask('Enter the project identifier [<comment>' . $projectIdentifier . '</comment>]: ', $projectIdentifier);

        $projectName = ucwords(str_replace('-', ' ', $projectIdentifier));
        $projectName = $io->ask('Enter the project name [<comment>' . $projectName . '</comment>]: ', $projectName);

        // --- Add Deployment

        $deployment = $io->ask('Add a deployment type (<comment>ssh/ftp/NONE</comment>): ', 'none');

        if ($deployment === 'ftp') {
            $platform = $io->ask('Enter the platform (<comment>github/GITLAB</comment>): ', 'gitlab');
        } else {
            $platform = 'none';
        }

        self::setupDeployment($deployment, $platform, $projectName, $projectIdentifier);

        // --- Replace in files & dirs

        self::replace(__DIR__ . '/.gitignore', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/package.json', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/README.md.template', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/tailwind.config.ts', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/vite.config.ts', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/vite-gutenberg.config.ts', $projectName, $projectIdentifier);

        self::replaceDir(__DIR__ . '/assets', $projectName, $projectIdentifier);
        self::replaceDir(__DIR__ . '/public/wp-content/mu-plugins/wordpress-boilerplate', $projectName, $projectIdentifier);
        self::replaceDir(__DIR__ . '/public/wp-content/themes', $projectName, $projectIdentifier);
        self::replaceDir(__DIR__ . '/public/favicons', $projectName, $projectIdentifier);

        // --- Copy/rename files & dirs

        rename(__DIR__ . '/assets/gutenberg/plugins/wordpress-boilerplate', __DIR__ . '/assets/gutenberg/plugins/' . $projectIdentifier);
        rename(__DIR__ . '/public/wp-content/mu-plugins/wordpress-boilerplate/wordpress-boilerplate.php', __DIR__ . '/public/wp-content/mu-plugins/wordpress-boilerplate/' . $projectIdentifier . '.php');
        rename(__DIR__ . '/public/wp-content/mu-plugins/wordpress-boilerplate', __DIR__ . '/public/wp-content/mu-plugins/' . $projectIdentifier);
        rename(__DIR__ . '/public/wp-content/themes/wordpress-boilerplate/languages/wordpress-boilerplate.pot', __DIR__ . '/public/wp-content/themes/wordpress-boilerplate/languages/' . $projectIdentifier . '.pot');
        rename(__DIR__ . '/public/wp-content/themes/wordpress-boilerplate', __DIR__ . '/public/wp-content/themes/' . $projectIdentifier);

        // --- Cleanup

        unlink(__DIR__ . '/LICENSE');

        unlink(__DIR__ . '/README.md');
        rename(__DIR__ . '/README.md.template', __DIR__ . '/README.md');

        self::removeDir(__DIR__ . '/.docker');

        // ---

        $manipulator = new JsonManipulator(
            file_get_contents(__DIR__ . '/composer.json')
        );

        $manipulator->removeProperty('name');
        $manipulator->removeProperty('description');
        $manipulator->removeProperty('keywords');
        $manipulator->removeProperty('homepage');
        $manipulator->removeProperty('license');
        $manipulator->removeSubNode('require-dev', 'composer/composer');
        $manipulator->removeProperty('autoload');
        $manipulator->removeSubNode('scripts', 'post-create-project-cmd');

        file_put_contents(
            __DIR__ . '/composer.json',
            $manipulator->getContents()
        );

        self::updateComposerLock(
            __DIR__ . '/composer.json',
            $event->getComposer(),
            $io
        );

        // ---

        unlink(__DIR__ . '/ComposerScripts.php');
    }

    private static function replaceDir($dir, $projectName, $projectIdentifier)
    {
        foreach (glob(rtrim($dir, '\\/') . '/*') as $file) {
            if (is_dir($file)) {
                self::replaceDir($file, $projectName, $projectIdentifier);
            } else {
                self::replace($file, $projectName, $projectIdentifier);
            }
        }
    }

    private static function removeDir($dir)
    {
        $files = glob($dir . '/*');

        foreach ($files as $file) {
            is_dir($file) ? self::removeDir($file) : unlink($file);
        }

        rmdir($dir);
    }

    private static function replace($file, $projectName, $projectIdentifier)
    {
        $content = file_get_contents($file);

        $content = str_ireplace(
            [
                'wordpress boilerplate',
                'wordpress-boilerplate',
                'wordpress_boilerplate',
                'WordpressBoilerplate',
            ],
            [
                $projectName,
                $projectIdentifier,
                str_replace('-', '_', $projectIdentifier),
                str_replace('-', '', ucwords($projectIdentifier, '-')),
            ],
            $content
        );

        file_put_contents($file, $content);
    }

    private static function updateComposerLock($composerFile, Composer $composer, IOInterface $io)
    {
        $lock = substr($composerFile, 0, -4) . 'lock';
        $composerJson = file_get_contents($composerFile);
        $lockFile = new JsonFile($lock, null, $io);
        $locker = new Locker(
            $io,
            $lockFile,
            $composer->getInstallationManager(),
            $composerJson
        );
        $lockData = $locker->getLockData();
        $lockData['content-hash'] = Locker::getContentHash($composerJson);
        $lockFile->write($lockData);
    }

    private static function setupDeployment($type, $platform, $projectName, $projectIdentifier)
    {
        switch ($type) {
            case 'ftp':
                if ($platform === 'github') {
                    unlink(__DIR__ . '/.gitlab-ci.ftp.dist.yml');
                    unlink(__DIR__ . '/.gitlab-ci.ssh.dist.yml');
                    unlink(__DIR__ . '/deploy.dist.php');
                    unlink(__DIR__ . '/.github/workflows/docker.yml');
                    self::replace(__DIR__ . '/.github/workflows/deploy.yml', $projectName, $projectIdentifier);
                } else {
                    unlink(__DIR__ . '/.gitlab-ci.ssh.dist.yml');
                    unlink(__DIR__ . '/deploy.dist.php');
                    rename(__DIR__ . '/.gitlab-ci.ftp.dist.yml', __DIR__ . '/.gitlab-ci.yml');
                    self::replace(__DIR__ . '/.gitlab-ci.yml', $projectName, $projectIdentifier);
                    self::removeDir(__DIR__ . '/.github');
                }
                break;
            case 'ssh':
                unlink(__DIR__ . '/.gitlab-ci.ftp.dist.yml');
                rename(__DIR__ . '/.gitlab-ci.ssh.dist.yml', __DIR__ . '/.gitlab-ci.yml');
                rename(__DIR__ . '/deploy.dist.php', __DIR__ . '/deploy.php');
                self::replace(__DIR__ . '/.gitlab-ci.yml', $projectName, $projectIdentifier);
                self::replace(__DIR__ . '/deploy.php', $projectName, $projectIdentifier);
                self::removeDir(__DIR__ . '/.github');
                break;
            case 'none':
            default:
                unlink(__DIR__ . '/.gitlab-ci.ftp.dist.yml');
                unlink(__DIR__ . '/.gitlab-ci.ssh.dist.yml');
                unlink(__DIR__ . '/deploy.dist.php');
                self::removeDir(__DIR__ . '/.github');
                break;
        }
    }
}
