<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit994a976de9964fad5c1aa151a325fe91
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Rakit\\Validation\\' => 17,
        ),
        'P' => 
        array (
            'Plasticbrain\\FlashMessages\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Rakit\\Validation\\' => 
        array (
            0 => __DIR__ . '/..' . '/rakit/validation/src',
        ),
        'Plasticbrain\\FlashMessages\\' => 
        array (
            0 => __DIR__ . '/..' . '/plasticbrain/php-flash-messages/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit994a976de9964fad5c1aa151a325fe91::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit994a976de9964fad5c1aa151a325fe91::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
