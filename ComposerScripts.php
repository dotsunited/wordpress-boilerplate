<?php

namespace DotsUnited;

use Composer\Script\Event;

class ComposerScripts
{
    public static function postCreateProject(Event $event)
    {
        /** @var \Composer\IO\IOInterface $io */
        $io = $event->getIO();

        $projectName = $io->ask('<question>Enter the project name (e.g. My Project):</question> ');
        $projectIdentifier = $io->ask('<question>Enter the project identifier (e.g. my-project):</question> ');

        self::replace(__DIR__ . '/.gitignore', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/package.json', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/README.md', $projectName, $projectIdentifier);

        self::replaceDir(__DIR__ . '/web/wp-content/themes/wordpress-boilerplate', $projectName, $projectIdentifier);

        rename(__DIR__ . '/web/wp-content/themes/wordpress-boilerplate', __DIR__ . '/web/wp-content/themes/' . $projectIdentifier);

        unlink(__DIR__ . '/composer.json');
        unlink(__DIR__ . '/composer.lock');
        self::removeDir(__DIR__ . '/vendor');
        unlink(__DIR__ . '/ComposerScripts.php');
    }

    private static function removeDir($dir)
    {
        foreach (glob(rtrim($dir, '\\/') . '/*') as $file) {
            if (is_dir($file)) {
                self::removeDir($file);
            } else {
                unlink($file);
            }
        }

        rmdir($dir);
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

        $content = str_replace(
            array(
                'Wordpress Boilerplate',
                'wordpress-boilerplate',
                'wordpress_boilerplate'
            ),
            array(
                $projectName,
                $projectIdentifier,
                str_replace('-', '_', $projectIdentifier)
            ),
            $content
        );

        file_put_contents($file, $content);
    }
}
