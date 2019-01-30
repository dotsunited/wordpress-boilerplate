<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/public/app');

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_summary' => false,
    ])
    ->setFinder($finder);
