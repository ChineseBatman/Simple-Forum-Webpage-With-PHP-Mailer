<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9076bf495a1e586e7b7ae0f29fbe0713
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9076bf495a1e586e7b7ae0f29fbe0713::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9076bf495a1e586e7b7ae0f29fbe0713::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9076bf495a1e586e7b7ae0f29fbe0713::$classMap;

        }, null, ClassLoader::class);
    }
}
