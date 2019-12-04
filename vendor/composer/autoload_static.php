<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit316eac86e48866355108d6dd82ec4f74
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Premmerce\\SDK\\' => 14,
        ),
        'C' => 
        array (
            'Codeable\\Poll\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Premmerce\\SDK\\' => 
        array (
            0 => __DIR__ . '/..' . '/premmerce/wordpress-sdk/src',
        ),
        'Codeable\\Poll\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit316eac86e48866355108d6dd82ec4f74::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit316eac86e48866355108d6dd82ec4f74::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
