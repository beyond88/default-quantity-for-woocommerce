<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit71636747f311c95dd455df204bce9aa4
{
    public static $files = array (
        '37f3140e405a0392684beea85f602777' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPCSStandards\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 57,
        ),
        'M' => 
        array (
            'Mak\\DefaultQuantityForWoocommerce\\' => 34,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPCSStandards\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
        'Mak\\DefaultQuantityForWoocommerce\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Mak\\DefaultQuantityForWoocommerce\\API' => __DIR__ . '/../..' . '/includes/API.php',
        'Mak\\DefaultQuantityForWoocommerce\\Admin' => __DIR__ . '/../..' . '/includes/Admin.php',
        'Mak\\DefaultQuantityForWoocommerce\\Admin\\PluginMeta' => __DIR__ . '/../..' . '/includes/Admin/PluginMeta.php',
        'Mak\\DefaultQuantityForWoocommerce\\Admin\\Settings' => __DIR__ . '/../..' . '/includes/Admin/Settings.php',
        'Mak\\DefaultQuantityForWoocommerce\\Ajax' => __DIR__ . '/../..' . '/includes/Ajax.php',
        'Mak\\DefaultQuantityForWoocommerce\\Assets' => __DIR__ . '/../..' . '/includes/Assets.php',
        'Mak\\DefaultQuantityForWoocommerce\\Frontend' => __DIR__ . '/../..' . '/includes/Frontend.php',
        'Mak\\DefaultQuantityForWoocommerce\\Frontend\\Storefront' => __DIR__ . '/../..' . '/includes/Frontend/Storefront.php',
        'Mak\\DefaultQuantityForWoocommerce\\Helpers' => __DIR__ . '/../..' . '/includes/Helpers.php',
        'Mak\\DefaultQuantityForWoocommerce\\Installer' => __DIR__ . '/../..' . '/includes/Installer.php',
        'Mak\\DefaultQuantityForWoocommerce\\Traits\\Singleton' => __DIR__ . '/../..' . '/includes/Traits/Singleton.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit71636747f311c95dd455df204bce9aa4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit71636747f311c95dd455df204bce9aa4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit71636747f311c95dd455df204bce9aa4::$classMap;

        }, null, ClassLoader::class);
    }
}
