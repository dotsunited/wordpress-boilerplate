<?php

namespace DotsUnited;

use Composer\Script\Event;

class ComposerScripts
{
    public static function postCreateProject(Event $event)
    {
        $args = $event->getArguments();

        /** @var \Composer\IO\IOInterface $io */
        $io = $event->getIO();

        $projectIdentifier = isset($args['directory']) ? $args['directory'] : 'my-project';
        $projectIdentifier = $io->ask('Enter the project identifier [<comment>' . $projectIdentifier . '</comment>]: ', $projectIdentifier);

        $projectName = ucwords(str_replace('-', ' ', $projectIdentifier));
        $projectName = $io->ask('Enter the project name [<comment>' . $projectName . '</comment>]: ', $projectName);

        self::replace(__DIR__ . '/.env.dist', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/.gitignore', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/composer.json.template', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/package.json', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/package-lock.json', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/README.md.template', $projectName, $projectIdentifier);
        self::replace(__DIR__ . '/webpack.config.js', $projectName, $projectIdentifier);

        self::replace(__DIR__ . '/public/wp-config.php', $projectName, $projectIdentifier);

        self::replaceDir(__DIR__ . '/assets', $projectName, $projectIdentifier);
        self::replaceDir(__DIR__ . '/public/app/themes', $projectName, $projectIdentifier);
        self::replaceDir(__DIR__ . '/public/app/favicons', $projectName, $projectIdentifier);

        rename(__DIR__ . '/public/app/themes/wordpress-boilerplate', __DIR__ . '/public/app/themes/' . $projectIdentifier);

        unlink(__DIR__ . '/composer.json');
        rename(__DIR__ . '/composer.json.template', __DIR__ . '/composer.json');

        unlink(__DIR__ . '/ComposerScripts.php');

        unlink(__DIR__ . '/README.md');
        rename(__DIR__ . '/README.md.template', __DIR__ . '/README.md');
    }

    private static function removeDir($dir)
    {
        foreach (glob(rtrim($dir, '\\/') . '/{,.}*', GLOB_BRACE) as $file) {
            $basename = basename($file);

            if ('.' === $basename || '..' === $basename) {
                continue;
            }

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

        $content = str_ireplace(
            array(
                'wordpress boilerplate',
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
