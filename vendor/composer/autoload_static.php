<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd8287638056fb79c1752d3fae9521463
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Julius\\EduAssista\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Julius\\EduAssista\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd8287638056fb79c1752d3fae9521463::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd8287638056fb79c1752d3fae9521463::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd8287638056fb79c1752d3fae9521463::$classMap;

        }, null, ClassLoader::class);
    }
}
