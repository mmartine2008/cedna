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
                            'user' => 'sa',
                            'port' => '1433',
                            'password' => 'UMwFE4vumKPy'
                        ],
                    ],            
                ],        
            ],
    
    'afip_options' => [
        'production'    => 'FALSE',
        'proxy' => [
            'enabled' => false, 
        //    'enabled' => true,
            'proxy_host' => 'proxy.exa.unicen.edu.ar',
            'proxy_port' => '8080', 
        ],
        'credenciales' => [
            'CUIT'          => '20259746761',
            'CERT'          => 'mariano.cert',
	    'PRIVATEKEY'    => 'mariano.key'
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
            ]  
    ],
    
    'timer_notifications' => 3000,
];
