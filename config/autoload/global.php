<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;


return [
        // Session configuration.
        'session_config' => [
            // Session cookie will expire in 1 hour.
            'cookie_lifetime' => 60*60*1,
            // Session data will be stored on server maximum for 30 days.
            'gc_maxlifetime'     => 60*60*24*30,
        ],
        // Session manager configuration.
        'session_manager' => [
            // Session validators (used for security).
            'validators' => [
                RemoteAddr::class,
    //            HttpUserAgent::class,
            ]
        ],
        // Session storage configuration.
        'session_storage' => [
            'type' => SessionArrayStorage::class
        ],

        
    'translator' => [
        'locale' => 'es_ES',
        // 'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'base_dir' => __DIR__.'/../data/languag/phpArray',
                'type'     => 'phpArray',
                'pattern'  => '%s.php',
            ],
            [
                'base_dir' => __DIR__.'/../data/languag/gettext',
                'type'     => 'gettext',
                'pattern'  => '%s.mo',
            ],
        ],
    ],

    'smtp_options' => [
        'name' => 'gmail.com',
        'host' => 'smtp.gmail.com',
        'connection_class' => 'login',
        'port' => '587',
        'connection_config' => [
            'ssl' => 'tls',
            'username' => 'mads.trp.2018@gmail.com',
            'password' => 'mads.trp.20181234',
        ],
        'default_subject' => 'CEDNA - Sistema de Permisos de Trabajo',
        'default_from_mail' => 'support@cedna.com.ar',
        'default_from_alias' => 'CEDNA',
    ],

    'datos_empresa' => [
        // 'name' => 'Coca-Cola',
        // 'phone' => '+5492262772277',
        // 'logo' => './public/img/Coca-Cola_Femsa_Logo.png',
        'name' => 'Arcor San Pedro',
        'phone' => '+5492262772277',
        'logo' => 'img/logo_arcor.png',
    ],

    'datos_archivos' => [
        'path' => '/home/juano/Cedna/files',
    ]
];
