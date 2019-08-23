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
        self::setupDeployment($deployment, $projectName, $projectIdentifier);

        // --- Add Wordpress

        $withWordpress = $io->askConfirmation('Should wordpress be added to the project? (<comment>y/N</comment>) ', false);
        self::setupWordpress($withWordpress, $io);

        // --- Replace in files & dirs

        self::replace(__DIR__ . '/.gitignore', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/package.json', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/package-lock.json', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/README.md.template', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/webpack.config.js', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/webpack-blocks.config.js', $projectName, $projectIdentifier);

        self::replace(__DIR__ . '/public/wp-config.dist.php', $projectName, $projectIdentifier);

        self::replaceDir(__DIR__ . '/assets', $projectName, $projectIdentifier);
        self::replaceDir(__DIR__ . '/public/wp-content/mu-plugins/wordpress-boilerplate', $projectName, $projectIdentifier);
        self::replaceDir(__DIR__ . '/public/wp-content/themes', $projectName, $projectIdentifier);
        self::replaceDir(__DIR__ . '/public/favicons', $projectName, $projectIdentifier);

        // --- Copy/rename files & dirs

        rename(__DIR__ . '/public/wp-content/mu-plugins/wordpress-boilerplate/wordpress-boilerplate.php', __DIR__ . '/public/app/mu-plugins/wordpress-boilerplate/' . $projectIdentifier . '.php');
        rename(__DIR__ . '/public/wp-content/mu-plugins/wordpress-boilerplate', __DIR__ . '/public/app/mu-plugins/' . $projectIdentifier);
        rename(__DIR__ . '/public/wp-content/themes/wordpress-boilerplate', __DIR__ . '/public/app/themes/' . $projectIdentifier);

        // --- Cleanup

        unlink(__DIR__ . '/LICENSE');

        unlink(__DIR__ . '/README.md');
        rename(__DIR__ . '/README.md.template', __DIR__ . '/README.md');

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

    private static function replace($file, $projectName, $projectIdentifier)
    {
        $content = file_get_contents($file);

        $content = str_ireplace(
            array(
                'wordpress boilerplate',
                'wordpress-boilerplate',
                'wordpress_boilerplate',
                'WordpressBoilerplate',
            ),
            array(
                $projectName,
                $projectIdentifier,
                str_replace('-', '_', $projectIdentifier),
                ucwords($projectIdentifier, '-'),
            ),
            $content
        );

        file_put_contents($file, $content);
    }

    private static function updateComposerLock($composerFile, Composer $composer, IOInterface $io)
    {
        $lock = substr($composerFile, 0, -4).'lock';
        $composerJson = file_get_contents($composerFile);
        $lockFile = new JsonFile($lock, null, $io);
        $locker = new Locker(
            $io,
            $lockFile,
            $composer->getRepositoryManager(),
            $composer->getInstallationManager(),
            $composerJson
        );
        $lockData = $locker->getLockData();
        $lockData['content-hash'] = Locker::getContentHash($composerJson);
        $lockFile->write($lockData);
    }

    private static function setupDeployment($type, $projectName, $projectIdentifier)
    {
        switch ($type) {
            case 'ftp':
                unlink(__DIR__ . '/.gitlab-ci.ssh.dist.yml');
                unlink(__DIR__ . '/deploy.dist.php');
                rename(__DIR__ . '/.gitlab-ci.ftp.dist.yml', __DIR__ . '/.gitlab-ci.yml');
                self::replace(__DIR__ . '/.gitlab-ci.yml', $projectName, $projectIdentifier);
                break;
            case 'ssh':
                unlink(__DIR__ . '/.gitlab-ci.ftp.dist.yml');
                rename(__DIR__ . '/.gitlab-ci.ssh.dist.yml', __DIR__ . '/.gitlab-ci.yml');
                rename(__DIR__ . '/deploy.dist.php', __DIR__ . '/deploy.php');
                self::replace(__DIR__ . '/.gitlab-ci.yml', $projectName, $projectIdentifier);
                self::replace(__DIR__ . '/deploy.php', $projectName, $projectIdentifier);
                break;
            case 'none':
            default:
                unlink(__DIR__ . '/.gitlab-ci.ftp.dist.yml');
                unlink(__DIR__ . '/.gitlab-ci.ssh.dist.yml');
                unlink(__DIR__ . '/deploy.dist.php');
                break;
        }
    }

    private static function setupWordpress($withWordpress, IOInterface $io)
    {
        if (!$withWordpress) {
            return;
        }

        $io->write('Download latest wordpress version from wordpress.org...');

        if (!copy('https://wordpress.org/latest.zip', __DIR__ . '/wordpress.zip')) {
            return;
        }

        $io->write('Extract zip archive...');

        $zip = new \ZipArchive;
        if (true === $zip->open(__DIR__ . '/wordpress.zip')) {
            $zip->extractTo(__DIR__ . '/public');
            $zip->close();
        }

		// TODO: move wordpress (without wp-content) to public (after extract it will be in public/wordpress

		// copy(__DIR__ . '/public/wp-config.dist.php', __DIR__ . '/public/wp-config.php');
        unlink(__DIR__ . '/wordpress.zip');
    }
}
