<?php
/**
 * Sobrescritura del archivo global
 *
 * @NOTE: En este archivo se especifican todos los parametros
 * que requieran claves o accesos con implicancias de seguridad
 */
use Doctrine\DBAL\Driver\SQLSrv\Driver as SQLDriver;
        
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => SQLDriver::class,
                'params' => [
                    'host' => 'localhost',
                    'dbname' => 'cedna',
                    'user' => 'admin',
                    'port' => '1433',
                    'password' => 'UMwFE4vumKPy'
                ],
            ],            
        ],        
    ],

    'timer_notifications' => 3000,
];