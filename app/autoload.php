<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('smachara',   __DIR__ . '/../vendor');

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
