<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit704e13c3917bbfc41c850f90cd589f26
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Model\\' => 6,
        ),
        'C' => 
        array (
            'Controller\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/model',
        ),
        'Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controller',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit704e13c3917bbfc41c850f90cd589f26::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit704e13c3917bbfc41c850f90cd589f26::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
