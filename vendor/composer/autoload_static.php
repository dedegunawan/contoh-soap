<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite4db827581513553fc8961eac9e2bb4c
{
    public static $files = array (
        'fa3df3013f51e030ec6f48c5e17462d5' => __DIR__ . '/..' . '/lindelius/php-jwt/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'l' => 
        array (
            'lawiet\\src\\' => 11,
            'lawiet\\' => 7,
        ),
        'L' => 
        array (
            'Lindelius\\JWT\\' => 14,
        ),
        'I' => 
        array (
            'IpinApp\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'lawiet\\src\\' => 
        array (
            0 => __DIR__ . '/..' . '/lawiet/nusoap/src',
        ),
        'lawiet\\' => 
        array (
            0 => __DIR__ . '/..' . '/lawiet/nusoap',
        ),
        'Lindelius\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/lindelius/php-jwt/src',
        ),
        'IpinApp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite4db827581513553fc8961eac9e2bb4c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite4db827581513553fc8961eac9e2bb4c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}