<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('storage')
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->notName('.php_cs.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2'                               => true,
        'no_unused_imports'                   => true,
        'fully_qualified_strict_types'        => true,
        'class_attributes_separation'         => true,
        'no_superfluous_elseif'               => true,
        'no_useless_else'                     => true,
        'phpdoc_add_missing_param_annotation' => true,
        'single_quote'                        => true,
    ])
    ->setFinder($finder);
