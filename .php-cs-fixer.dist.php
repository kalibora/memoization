<?php

$finder = \PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__)
;

return (new \PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_summary' => false,
        'yoda_style' => false,
        'global_namespace_import' => true,
    ])
    ->setFinder($finder)
    ->setUsingCache(false)
;
