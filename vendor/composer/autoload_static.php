<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2e2d5f43e9bfc3ab1c49cb055676561f
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Ilovepdf\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ilovepdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/ilovepdf/ilovepdf-php/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2e2d5f43e9bfc3ab1c49cb055676561f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2e2d5f43e9bfc3ab1c49cb055676561f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2e2d5f43e9bfc3ab1c49cb055676561f::$classMap;

        }, null, ClassLoader::class);
    }
}
