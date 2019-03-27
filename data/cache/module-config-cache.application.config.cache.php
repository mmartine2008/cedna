<?php
return array (
  'service_manager' => 
  array (
    'aliases' => 
    array (
      'HttpRouter' => 'Zend\\Router\\Http\\TreeRouteStack',
      'router' => 'Zend\\Router\\RouteStackInterface',
      'Router' => 'Zend\\Router\\RouteStackInterface',
      'RoutePluginManager' => 'Zend\\Router\\RoutePluginManager',
      'ValidatorManager' => 'Zend\\Validator\\ValidatorPluginManager',
      'Zend\\Session\\SessionManager' => 'Zend\\Session\\ManagerInterface',
      'Zend\\Db\\Adapter\\Adapter' => 'Zend\\Db\\Adapter\\AdapterInterface',
      'TranslatorPluginManager' => 'Zend\\I18n\\Translator\\LoaderPluginManager',
      'MvcTranslator' => 'Zend\\Mvc\\I18n\\Translator',
    ),
    'factories' => 
    array (
      'Zend\\Router\\Http\\TreeRouteStack' => 'Zend\\Router\\Http\\HttpRouterFactory',
      'Zend\\Router\\RoutePluginManager' => 'Zend\\Router\\RoutePluginManagerFactory',
      'Zend\\Router\\RouteStackInterface' => 'Zend\\Router\\RouterFactory',
      'Zend\\Validator\\ValidatorPluginManager' => 'Zend\\Validator\\ValidatorPluginManagerFactory',
      'Zend\\Session\\Config\\ConfigInterface' => 'Zend\\Session\\Service\\SessionConfigFactory',
      'Zend\\Session\\ManagerInterface' => 'Zend\\Session\\Service\\SessionManagerFactory',
      'Zend\\Session\\Storage\\StorageInterface' => 'Zend\\Session\\Service\\StorageFactory',
      'Zend\\Db\\Adapter\\AdapterInterface' => 'Zend\\Db\\Adapter\\AdapterServiceFactory',
      'Zend\\I18n\\Translator\\TranslatorInterface' => 'Zend\\I18n\\Translator\\TranslatorServiceFactory',
      'Zend\\I18n\\Translator\\LoaderPluginManager' => 'Zend\\I18n\\Translator\\LoaderPluginManagerFactory',
      'Zend\\Mvc\\I18n\\Translator' => 'Zend\\Mvc\\I18n\\TranslatorFactory',
      'doctrine.cli' => 'DoctrineModule\\Service\\CliFactory',
      'Doctrine\\ORM\\EntityManager' => 'DoctrineORMModule\\Service\\EntityManagerAliasCompatFactory',
      'translator' => 'Zend\\I18n\\Translator\\TranslatorServiceFactory',
      'Application\\Service\\UsuariosManager' => 'Application\\Service\\Factory\\UsuariosManagerFactory',
      'Application\\Service\\PerfilesManager' => 'Application\\Service\\Factory\\PerfilesManagerFactory',
      'Application\\Service\\OperariosManager' => 'Application\\Service\\Factory\\OperariosManagerFactory',
      'Application\\Service\\OrganigramaManager' => 'Application\\Service\\Factory\\OrganigramaManagerFactory',
      'Application\\Service\\TareasManager' => 'Application\\Service\\Factory\\TareasManagerFactory',
      'Application\\Service\\OrdenesDeCompraManager' => 'Application\\Service\\Factory\\OrdenesDeCompraManagerFactory',
      'Application\\Service\\MailManager' => 'Application\\Service\\Factory\\MailManagerFactory',
      'Application\\Service\\InduccionesManager' => 'Application\\Service\\Factory\\InduccionesManagerFactory',
      'Zend\\Authentication\\AuthenticationService' => 'Autenticacion\\Service\\Factory\\AuthenticationServiceFactory',
      'Autenticacion\\Service\\AuthManager' => 'Autenticacion\\Service\\Factory\\AuthManagerFactory',
      'Autenticacion\\Service\\UserManager' => 'Autenticacion\\Service\\Factory\\UserManagerFactory',
      'Autenticacion\\Service\\EmpresasManager' => 'Autenticacion\\Service\\Factory\\EmpresasManagerFactory',
      'Autenticacion\\Service\\RolesManager' => 'Autenticacion\\Service\\Factory\\RolesManagerFactory',
      'Autenticacion\\Service\\PerfilesManager' => 'Autenticacion\\Service\\Factory\\PerfilesManagerFactory',
      'Autenticacion\\Service\\AuthAdapter' => 'Autenticacion\\Service\\Factory\\AuthAdapterFactory',
      'Autenticacion\\Service\\UserSessionManager' => 'Autenticacion\\Service\\Factory\\UserSessionManagerFactory',
      'DBAL\\Service\\CatalogoManager' => 'DBAL\\Service\\Factory\\CatalogoManagerFactory',
      'Configuracion\\Service\\ConfiguracionManager' => 'Configuracion\\Service\\Factory\\ConfiguracionManagerFactory',
      'Configuracion\\Service\\ConfigUsuariosManager' => 'Configuracion\\Service\\Factory\\ConfigUsuariosManagerFactory',
      'Admin\\Service\\AccionManager' => 'Admin\\Service\\Factory\\AccionManagerFactory',
      'Admin\\Service\\OperacionManager' => 'Admin\\Service\\Factory\\OperacionManagerFactory',
      'Admin\\Service\\OperacionAccionPerfilManager' => 'Admin\\Service\\Factory\\OperacionAccionPerfilManagerFactory',
      'Admin\\Service\\TipoPreguntaManager' => 'Admin\\Service\\Factory\\TipoPreguntaManagerFactory',
      'Formulario\\Service\\FormularioManager' => 'Formulario\\Service\\Factory\\FormularioManagerFactory',
      'Formulario\\Service\\CednaTcpdf' => 'Formulario\\Service\\Factory\\CednaTcpdfFactory',
      'TCPDF' => 'TCPDFModule\\Factory\\TCPDFFactory',
    ),
    'abstract_factories' => 
    array (
      0 => 'Zend\\Session\\Service\\ContainerAbstractServiceFactory',
      1 => 'Zend\\Db\\Adapter\\AdapterAbstractServiceFactory',
      'DoctrineModule' => 'DoctrineModule\\ServiceFactory\\AbstractDoctrineServiceFactory',
    ),
    'delegators' => 
    array (
      'HttpRouter' => 
      array (
        0 => 'Zend\\Mvc\\I18n\\Router\\HttpRouterDelegatorFactory',
      ),
      'Zend\\Router\\Http\\TreeRouteStack' => 
      array (
        0 => 'Zend\\Mvc\\I18n\\Router\\HttpRouterDelegatorFactory',
      ),
    ),
    'invokables' => 
    array (
      'DoctrineModule\\Authentication\\Storage\\Session' => 'Zend\\Authentication\\Storage\\Session',
      'doctrine.dbal_cmd.runsql' => 'Doctrine\\DBAL\\Tools\\Console\\Command\\RunSqlCommand',
      'doctrine.dbal_cmd.import' => 'Doctrine\\DBAL\\Tools\\Console\\Command\\ImportCommand',
      'doctrine.orm_cmd.clear_cache_metadata' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\MetadataCommand',
      'doctrine.orm_cmd.clear_cache_result' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\ResultCommand',
      'doctrine.orm_cmd.clear_cache_query' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\QueryCommand',
      'doctrine.orm_cmd.schema_tool_create' => 'Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\CreateCommand',
      'doctrine.orm_cmd.schema_tool_update' => 'Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\UpdateCommand',
      'doctrine.orm_cmd.schema_tool_drop' => 'Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\DropCommand',
      'doctrine.orm_cmd.convert_d1_schema' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ConvertDoctrine1SchemaCommand',
      'doctrine.orm_cmd.generate_entities' => 'Doctrine\\ORM\\Tools\\Console\\Command\\GenerateEntitiesCommand',
      'doctrine.orm_cmd.generate_proxies' => 'Doctrine\\ORM\\Tools\\Console\\Command\\GenerateProxiesCommand',
      'doctrine.orm_cmd.convert_mapping' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ConvertMappingCommand',
      'doctrine.orm_cmd.run_dql' => 'Doctrine\\ORM\\Tools\\Console\\Command\\RunDqlCommand',
      'doctrine.orm_cmd.validate_schema' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ValidateSchemaCommand',
      'doctrine.orm_cmd.info' => 'Doctrine\\ORM\\Tools\\Console\\Command\\InfoCommand',
      'doctrine.orm_cmd.ensure_production_settings' => 'Doctrine\\ORM\\Tools\\Console\\Command\\EnsureProductionSettingsCommand',
      'doctrine.orm_cmd.generate_repositories' => 'Doctrine\\ORM\\Tools\\Console\\Command\\GenerateRepositoriesCommand',
    ),
    'shared' => 
    array (
      'TCPDF' => false,
    ),
  ),
  'route_manager' => 
  array (
    'factories' => 
    array (
      'symfony_cli' => 'DoctrineModule\\Service\\SymfonyCliRouteFactory',
    ),
  ),
  'router' => 
  array (
    'routes' => 
    array (
      'doctrine_orm_module_yuml' => 
      array (
        'type' => 'literal',
        'options' => 
        array (
          'route' => '/ocra_service_manager_yuml',
          'defaults' => 
          array (
            'controller' => 'DoctrineORMModule\\Yuml\\YumlController',
            'action' => 'index',
          ),
        ),
      ),
      'home' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\AuthController',
            'action' => 'login',
          ),
        ),
      ),
      'index' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/index',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\CednaController',
            'action' => 'index',
          ),
        ),
      ),
      'operarios' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/operarios[/:action[/:id]]',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\OperariosController',
            'action' => 'index',
          ),
        ),
        'constraints' => 
        array (
          'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
          'id' => '[a-zA-Z0-9_-]*',
        ),
        'may_terminate' => true,
      ),
      'inducciones' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/inducciones[/:action[/:id]]',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\InduccionesController',
            'action' => 'index',
          ),
        ),
        'constraints' => 
        array (
          'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
          'id' => '[a-zA-Z0-9_-]*',
        ),
        'may_terminate' => true,
      ),
      'organigrama' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/organigrama',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\OrganigramaController',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'nodos' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/nodos[/:action[/:id]]',
              'defaults' => 
              array (
                'action' => 'nodos',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              'id' => '[a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
          'autoridades' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/autoridades[/:action[/:id]]',
              'defaults' => 
              array (
                'action' => 'autoridades',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              'id' => '[a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
          'dibujar' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/dibujar',
              'defaults' => 
              array (
                'action' => 'dibujar',
              ),
            ),
            'may_terminate' => true,
          ),
        ),
      ),
      'tareas' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/tareas[/:action[/:id]]',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\TareasController',
            'action' => 'index',
          ),
        ),
        'constraints' => 
        array (
          'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
          'id' => '[a-zA-Z0-9_-]*',
        ),
        'may_terminate' => true,
      ),
      'planificacion' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/planificacion[/:action[/:id]]',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\PlanificacionController',
            'action' => 'index',
          ),
        ),
        'constraints' => 
        array (
          'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
          'id' => '[a-zA-Z0-9_-]*',
        ),
        'may_terminate' => true,
      ),
      'ordenes-de-compra' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/ordenes-de-compra[/:action[/:id]]',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\OrdenesDeCompraController',
            'action' => 'index',
          ),
        ),
        'constraints' => 
        array (
          'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
          'id' => '[a-zA-Z0-9_-]*',
        ),
        'may_terminate' => true,
      ),
      'mail' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/mail[/:action[/:id]]',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\MailController',
            'action' => 'index',
          ),
        ),
        'constraints' => 
        array (
          'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
          'id' => '[a-zA-Z0-9_-]*',
        ),
        'may_terminate' => true,
      ),
      'login' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/login',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\AuthController',
            'action' => 'login',
          ),
        ),
      ),
      'sendmail' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/sendmail',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\AuthController',
            'action' => 'sendmail',
          ),
        ),
      ),
      'logout' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/logout',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\AuthController',
            'action' => 'logout',
          ),
        ),
      ),
      'reset-password' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/reset-password[/:userPass]',
          'constraints' => 
          array (
            'userPass' => '[a-zA-Z0-9\\_]+',
          ),
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\AuthController',
            'action' => 'resetPassword',
          ),
        ),
      ),
      'usuario' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/usuario[/:action][/:id]',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\AuthController',
            'action' => 'edit',
          ),
        ),
      ),
      'registro' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/registro',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\AuthController',
            'action' => 'registro',
          ),
        ),
      ),
      'auth' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/auth[/:action][/:id]',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\AuthController',
          ),
        ),
      ),
      'roles' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/roles',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\RolesController',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'accion' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '[/:action[/:param1[/:param2]]]',
              'constraints' => 
              array (
                'action' => '(?!alta|editar)[a-zA-Z][a-zA-Z0-9_-]*',
                'param1' => '[a-zA-Z0-9_-]*',
                'param2' => '[a-zA-Z0-9_-]*',
              ),
            ),
          ),
          'alta' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/alta',
              'defaults' => 
              array (
                'controller' => 'Autenticacion\\Controller\\RolesController',
                'action' => 'alta',
              ),
              'constraints' => 
              array (
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'id' => '[a-zA-Z0-9_-]*',
              ),
            ),
          ),
          'editar' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/editar[/:id]',
              'defaults' => 
              array (
                'controller' => 'Autenticacion\\Controller\\RolesController',
                'action' => 'editar',
              ),
              'constraints' => 
              array (
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'id' => '[a-zA-Z0-9_-]*',
              ),
            ),
          ),
        ),
      ),
      'perfiles' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/perfiles',
          'defaults' => 
          array (
            'controller' => 'Autenticacion\\Controller\\PerfilesController',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'accion' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '[/:action[/:param1[/:param2]]]',
              'constraints' => 
              array (
                'action' => '(?!alta|editar)[a-zA-Z][a-zA-Z0-9_-]*',
                'param1' => '[a-zA-Z0-9_-]*',
                'param2' => '[a-zA-Z0-9_-]*',
              ),
            ),
          ),
          'alta' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/alta',
              'defaults' => 
              array (
                'controller' => 'Autenticacion\\Controller\\PerfilesController',
                'action' => 'alta',
              ),
              'constraints' => 
              array (
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'id' => '[a-zA-Z0-9_-]*',
              ),
            ),
          ),
          'editar' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/editar[/:id]',
              'defaults' => 
              array (
                'controller' => 'Autenticacion\\Controller\\PerfilesController',
                'action' => 'editar',
              ),
              'constraints' => 
              array (
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'id' => '[a-zA-Z0-9_-]*',
              ),
            ),
          ),
        ),
      ),
      'configuracion' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/configuracion',
          'defaults' => 
          array (
            'controller' => 'Configuracion\\Controller\\ConfiguracionController',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'perfiles' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/perfiles[/:action[/:id]]',
              'defaults' => 
              array (
                'controller' => 'Configuracion\\Controller\\ConfigPerfilesController',
                'action' => 'index',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              'id' => '[a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
          'usuarios' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/usuarios[/:action[/:id]]',
              'defaults' => 
              array (
                'controller' => 'Configuracion\\Controller\\ConfigUsuariosController',
                'action' => 'index',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              'id' => '[a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
          'notificaciones-por-perfil' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/notificaciones-por-perfil[/:action]',
              'defaults' => 
              array (
                'controller' => 'Configuracion\\Controller\\ConfigNotifXPerfilController',
                'action' => 'index',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
        ),
      ),
      'abm' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/abm',
          'defaults' => 
          array (
            'controller' => 'Admin\\Controller\\ABMController',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'accion' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/accion[/:action[/:id]]',
              'defaults' => 
              array (
                'controller' => 'Admin\\Controller\\AccionController',
                'action' => 'index',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              'id' => '[a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
          'operacion' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/operacion[/:action[/:id]]',
              'defaults' => 
              array (
                'controller' => 'Admin\\Controller\\OperacionController',
                'action' => 'index',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              'id' => '[a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
          'operacionAccionPerfil' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/operacionAccionPerfil[/:action[/:id]]',
              'defaults' => 
              array (
                'controller' => 'Admin\\Controller\\OperacionAccionPerfilController',
                'action' => 'index',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              'id' => '[a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
          'tipo-pregunta' => 
          array (
            'type' => 'Zend\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/tipo-pregunta[/:action[/:id]]',
              'defaults' => 
              array (
                'controller' => 'Admin\\Controller\\TipoPreguntaController',
                'action' => 'index',
              ),
            ),
            'constraints' => 
            array (
              'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              'id' => '[a-zA-Z0-9_-]*',
            ),
            'may_terminate' => true,
          ),
        ),
      ),
      'formulario' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/formulario[/:action[/:id]]',
          'defaults' => 
          array (
            'controller' => 'Formulario\\Controller\\FormularioController',
            'action' => 'index',
          ),
        ),
        'constraints' => 
        array (
          'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
          'id' => '[a-zA-Z0-9_-]*',
        ),
      ),
      'imprimir' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/imprimir/:id',
          'defaults' => 
          array (
            'action' => 'imprimir',
            'controller' => 'Formulario\\Controller\\FormularioController',
          ),
          'constraints' => 
          array (
            'id' => '[1-9]\\d*',
          ),
        ),
      ),
    ),
  ),
  'filters' => 
  array (
    'aliases' => 
    array (
      'alnum' => 'Zend\\I18n\\Filter\\Alnum',
      'Alnum' => 'Zend\\I18n\\Filter\\Alnum',
      'alpha' => 'Zend\\I18n\\Filter\\Alpha',
      'Alpha' => 'Zend\\I18n\\Filter\\Alpha',
      'numberformat' => 'Zend\\I18n\\Filter\\NumberFormat',
      'numberFormat' => 'Zend\\I18n\\Filter\\NumberFormat',
      'NumberFormat' => 'Zend\\I18n\\Filter\\NumberFormat',
      'numberparse' => 'Zend\\I18n\\Filter\\NumberParse',
      'numberParse' => 'Zend\\I18n\\Filter\\NumberParse',
      'NumberParse' => 'Zend\\I18n\\Filter\\NumberParse',
    ),
    'factories' => 
    array (
      'Zend\\I18n\\Filter\\Alnum' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Filter\\Alpha' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Filter\\NumberFormat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Filter\\NumberParse' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
    ),
  ),
  'validators' => 
  array (
    'aliases' => 
    array (
      'alnum' => 'Zend\\I18n\\Validator\\Alnum',
      'Alnum' => 'Zend\\I18n\\Validator\\Alnum',
      'alpha' => 'Zend\\I18n\\Validator\\Alpha',
      'Alpha' => 'Zend\\I18n\\Validator\\Alpha',
      'datetime' => 'Zend\\I18n\\Validator\\DateTime',
      'dateTime' => 'Zend\\I18n\\Validator\\DateTime',
      'DateTime' => 'Zend\\I18n\\Validator\\DateTime',
      'float' => 'Zend\\I18n\\Validator\\IsFloat',
      'Float' => 'Zend\\I18n\\Validator\\IsFloat',
      'int' => 'Zend\\I18n\\Validator\\IsInt',
      'Int' => 'Zend\\I18n\\Validator\\IsInt',
      'isfloat' => 'Zend\\I18n\\Validator\\IsFloat',
      'isFloat' => 'Zend\\I18n\\Validator\\IsFloat',
      'IsFloat' => 'Zend\\I18n\\Validator\\IsFloat',
      'isint' => 'Zend\\I18n\\Validator\\IsInt',
      'isInt' => 'Zend\\I18n\\Validator\\IsInt',
      'IsInt' => 'Zend\\I18n\\Validator\\IsInt',
      'phonenumber' => 'Zend\\I18n\\Validator\\PhoneNumber',
      'phoneNumber' => 'Zend\\I18n\\Validator\\PhoneNumber',
      'PhoneNumber' => 'Zend\\I18n\\Validator\\PhoneNumber',
      'postcode' => 'Zend\\I18n\\Validator\\PostCode',
      'postCode' => 'Zend\\I18n\\Validator\\PostCode',
      'PostCode' => 'Zend\\I18n\\Validator\\PostCode',
    ),
    'factories' => 
    array (
      'Zend\\I18n\\Validator\\Alnum' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\Alpha' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\DateTime' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\IsFloat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\IsInt' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\PhoneNumber' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\PostCode' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
    ),
  ),
  'view_helpers' => 
  array (
    'aliases' => 
    array (
      'currencyformat' => 'Zend\\I18n\\View\\Helper\\CurrencyFormat',
      'currencyFormat' => 'Zend\\I18n\\View\\Helper\\CurrencyFormat',
      'CurrencyFormat' => 'Zend\\I18n\\View\\Helper\\CurrencyFormat',
      'dateformat' => 'Zend\\I18n\\View\\Helper\\DateFormat',
      'dateFormat' => 'Zend\\I18n\\View\\Helper\\DateFormat',
      'DateFormat' => 'Zend\\I18n\\View\\Helper\\DateFormat',
      'numberformat' => 'Zend\\I18n\\View\\Helper\\NumberFormat',
      'numberFormat' => 'Zend\\I18n\\View\\Helper\\NumberFormat',
      'NumberFormat' => 'Zend\\I18n\\View\\Helper\\NumberFormat',
      'plural' => 'Zend\\I18n\\View\\Helper\\Plural',
      'Plural' => 'Zend\\I18n\\View\\Helper\\Plural',
      'translate' => 'Zend\\I18n\\View\\Helper\\Translate',
      'Translate' => 'Zend\\I18n\\View\\Helper\\Translate',
      'translateplural' => 'Zend\\I18n\\View\\Helper\\TranslatePlural',
      'translatePlural' => 'Zend\\I18n\\View\\Helper\\TranslatePlural',
      'TranslatePlural' => 'Zend\\I18n\\View\\Helper\\TranslatePlural',
    ),
    'factories' => 
    array (
      'Zend\\I18n\\View\\Helper\\CurrencyFormat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\DateFormat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\NumberFormat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\Plural' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\Translate' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\TranslatePlural' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
    ),
    'invokables' => 
    array (
      'translate' => 'Zend\\I18n\\View\\Helper\\Translate',
    ),
  ),
  'doctrine' => 
  array (
    'cache' => 
    array (
      'apc' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ApcCache',
        'namespace' => 'DoctrineModule',
      ),
      'apcu' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ApcuCache',
        'namespace' => 'DoctrineModule',
      ),
      'array' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ArrayCache',
        'namespace' => 'DoctrineModule',
      ),
      'filesystem' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\FilesystemCache',
        'directory' => 'data/DoctrineModule/cache',
        'namespace' => 'DoctrineModule',
      ),
      'memcache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
        'instance' => 'my_memcache_alias',
        'namespace' => 'DoctrineModule',
      ),
      'memcached' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
        'instance' => 'my_memcached_alias',
        'namespace' => 'DoctrineModule',
      ),
      'predis' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\PredisCache',
        'instance' => 'my_predis_alias',
        'namespace' => 'DoctrineModule',
      ),
      'redis' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\RedisCache',
        'instance' => 'my_redis_alias',
        'namespace' => 'DoctrineModule',
      ),
      'wincache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
        'namespace' => 'DoctrineModule',
      ),
      'xcache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\XcacheCache',
        'namespace' => 'DoctrineModule',
      ),
      'zenddata' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
        'namespace' => 'DoctrineModule',
      ),
    ),
    'authentication' => 
    array (
      'odm_default' => 
      array (
      ),
      'orm_default' => 
      array (
        'objectManager' => 'doctrine.entitymanager.orm_default',
      ),
    ),
    'authenticationadapter' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'authenticationstorage' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'authenticationservice' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'connection' => 
    array (
      'orm_default' => 
      array (
        'configuration' => 'orm_default',
        'eventmanager' => 'orm_default',
        'params' => 
        array (
          'host' => 'localhost',
          'port' => '1433',
          'user' => 'admin',
          'password' => 'UMwFE4vumKPy',
          'dbname' => 'cedna',
        ),
        'driverClass' => 'Doctrine\\DBAL\\Driver\\SQLSrv\\Driver',
      ),
    ),
    'configuration' => 
    array (
      'orm_default' => 
      array (
        'metadata_cache' => 'array',
        'query_cache' => 'array',
        'result_cache' => 'array',
        'hydration_cache' => 'array',
        'driver' => 'orm_default',
        'generate_proxies' => true,
        'proxy_dir' => 'data/DoctrineORMModule/Proxy',
        'proxy_namespace' => 'DoctrineORMModule\\Proxy',
        'filters' => 
        array (
        ),
        'datetime_functions' => 
        array (
        ),
        'string_functions' => 
        array (
        ),
        'numeric_functions' => 
        array (
        ),
        'second_level_cache' => 
        array (
        ),
      ),
    ),
    'driver' => 
    array (
      'orm_default' => 
      array (
        'class' => 'Doctrine\\Common\\Persistence\\Mapping\\Driver\\MappingDriverChain',
        'drivers' => 
        array (
          'Autenticacion\\Entity' => 'Autenticacion_driver',
          'DBAL\\Entity' => 'DBAL_driver',
        ),
      ),
      'Autenticacion_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => '/home/juano/Cedna/cedna/module/Autenticacion/config/../src/Entity',
        ),
      ),
      'DBAL_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => '/home/juano/Cedna/cedna/module/DBAL/config/../src/Entity',
        ),
      ),
    ),
    'entitymanager' => 
    array (
      'orm_default' => 
      array (
        'connection' => 'orm_default',
        'configuration' => 'orm_default',
      ),
    ),
    'eventmanager' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'sql_logger_collector' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'mapping_collector' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'formannotationbuilder' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'entity_resolver' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'migrations_configuration' => 
    array (
      'orm_default' => 
      array (
        'directory' => 'data/DoctrineORMModule/Migrations',
        'name' => 'Doctrine Database Migrations',
        'namespace' => 'DoctrineORMModule\\Migrations',
        'table' => 'migrations',
        'column' => 'version',
      ),
    ),
    'migrations_cmd' => 
    array (
      'generate' => 
      array (
      ),
      'execute' => 
      array (
      ),
      'migrate' => 
      array (
      ),
      'status' => 
      array (
      ),
      'version' => 
      array (
      ),
      'diff' => 
      array (
      ),
      'latest' => 
      array (
      ),
    ),
  ),
  'doctrine_factories' => 
  array (
    'cache' => 'DoctrineModule\\Service\\CacheFactory',
    'eventmanager' => 'DoctrineModule\\Service\\EventManagerFactory',
    'driver' => 'DoctrineModule\\Service\\DriverFactory',
    'authenticationadapter' => 'DoctrineModule\\Service\\Authentication\\AdapterFactory',
    'authenticationstorage' => 'DoctrineModule\\Service\\Authentication\\StorageFactory',
    'authenticationservice' => 'DoctrineModule\\Service\\Authentication\\AuthenticationServiceFactory',
    'connection' => 'DoctrineORMModule\\Service\\DBALConnectionFactory',
    'configuration' => 'DoctrineORMModule\\Service\\ConfigurationFactory',
    'entitymanager' => 'DoctrineORMModule\\Service\\EntityManagerFactory',
    'entity_resolver' => 'DoctrineORMModule\\Service\\EntityResolverFactory',
    'sql_logger_collector' => 'DoctrineORMModule\\Service\\SQLLoggerCollectorFactory',
    'mapping_collector' => 'DoctrineORMModule\\Service\\MappingCollectorFactory',
    'formannotationbuilder' => 'DoctrineORMModule\\Service\\FormAnnotationBuilderFactory',
    'migrations_configuration' => 'DoctrineORMModule\\Service\\MigrationsConfigurationFactory',
    'migrations_cmd' => 'DoctrineORMModule\\Service\\MigrationsCommandFactory',
  ),
  'controllers' => 
  array (
    'factories' => 
    array (
      'DoctrineModule\\Controller\\Cli' => 'DoctrineModule\\Service\\CliControllerFactory',
      'Application\\Controller\\CednaController' => 'Application\\Controller\\Factory\\CednaControllerFactory',
      'Application\\Controller\\OperariosController' => 'Application\\Controller\\Factory\\OperariosControllerFactory',
      'Application\\Controller\\OrganigramaController' => 'Application\\Controller\\Factory\\OrganigramaControllerFactory',
      'Application\\Controller\\TareasController' => 'Application\\Controller\\Factory\\TareasControllerFactory',
      'Application\\Controller\\OrdenesDeCompraController' => 'Application\\Controller\\Factory\\OrdenesDeCompraControllerFactory',
      'Application\\Controller\\PlanificacionController' => 'Application\\Controller\\Factory\\PlanificacionControllerFactory',
      'Application\\Controller\\MailController' => 'Application\\Controller\\Factory\\MailControllerFactory',
      'Application\\Controller\\InduccionesController' => 'Application\\Controller\\Factory\\InduccionesControllerFactory',
      'Autenticacion\\Controller\\AuthController' => 'Autenticacion\\Controller\\Factory\\AuthControllerFactory',
      'Configuracion\\Controller\\ConfiguracionController' => 'Configuracion\\Controller\\Factory\\ConfiguracionControllerFactory',
      'Configuracion\\Controller\\ConfigPerfilesController' => 'Configuracion\\Controller\\Factory\\ConfigPerfilesControllerFactory',
      'Configuracion\\Controller\\ConfigUsuariosController' => 'Configuracion\\Controller\\Factory\\ConfigUsuariosControllerFactory',
      'Configuracion\\Controller\\ConfigNotifXPerfilController' => 'Configuracion\\Controller\\Factory\\ConfigNotifXPerfilControllerFactory',
      'Admin\\Controller\\ABMController' => 'Admin\\Controller\\Factory\\ABMControllerFactory',
      'Admin\\Controller\\AccionController' => 'Admin\\Controller\\Factory\\AccionControllerFactory',
      'Admin\\Controller\\OperacionController' => 'Admin\\Controller\\Factory\\OperacionControllerFactory',
      'Admin\\Controller\\OperacionAccionPerfilController' => 'Admin\\Controller\\Factory\\OperacionAccionPerfilControllerFactory',
      'Admin\\Controller\\TipoPreguntaController' => 'Admin\\Controller\\Factory\\TipoPreguntaControllerFactory',
      'Formulario\\Controller\\BaseFormularioController' => 'Formulario\\Controller\\Factory\\BaseFormularioControllerFactory',
      'Formulario\\Controller\\FormularioController' => 'Formulario\\Controller\\Factory\\FormularioControllerFactory',
    ),
  ),
  'console' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'doctrine_cli' => 
        array (
          'type' => 'symfony_cli',
        ),
      ),
    ),
  ),
  'form_elements' => 
  array (
    'aliases' => 
    array (
      'objectselect' => 'DoctrineModule\\Form\\Element\\ObjectSelect',
      'objectradio' => 'DoctrineModule\\Form\\Element\\ObjectRadio',
      'objectmulticheckbox' => 'DoctrineModule\\Form\\Element\\ObjectMultiCheckbox',
    ),
    'factories' => 
    array (
      'DoctrineModule\\Form\\Element\\ObjectSelect' => 'DoctrineORMModule\\Service\\ObjectSelectFactory',
      'DoctrineModule\\Form\\Element\\ObjectRadio' => 'DoctrineORMModule\\Service\\ObjectRadioFactory',
      'DoctrineModule\\Form\\Element\\ObjectMultiCheckbox' => 'DoctrineORMModule\\Service\\ObjectMultiCheckboxFactory',
    ),
  ),
  'hydrators' => 
  array (
    'factories' => 
    array (
      'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject' => 'DoctrineORMModule\\Service\\DoctrineObjectHydratorFactory',
    ),
  ),
  'view_manager' => 
  array (
    'template_map' => 
    array (
      'zend-developer-tools/toolbar/doctrine-orm-queries' => '/home/juano/Cedna/cedna/vendor/doctrine/doctrine-orm-module/config/../view/zend-developer-tools/toolbar/doctrine-orm-queries.phtml',
      'zend-developer-tools/toolbar/doctrine-orm-mappings' => '/home/juano/Cedna/cedna/vendor/doctrine/doctrine-orm-module/config/../view/zend-developer-tools/toolbar/doctrine-orm-mappings.phtml',
      'layout/layout' => '/home/juano/Cedna/cedna/module/Formulario/config/../view/layout/layout.phtml',
      'application/index/index' => '/home/juano/Cedna/cedna/module/Formulario/config/../view/application/index/index.phtml',
      'error/404' => '/home/juano/Cedna/cedna/module/Formulario/config/../view/error/404.phtml',
      'error/index' => '/home/juano/Cedna/cedna/module/Formulario/config/../view/error/index.phtml',
      'configuracion/index/index' => '/home/juano/Cedna/cedna/module/Configuracion/config/../view/configuracion/index/index.phtml',
      'admin/index/index' => '/home/juano/Cedna/cedna/module/Admin/config/../view/admin/index/index.phtml',
    ),
    'display_not_found_reason' => true,
    'display_exceptions' => true,
    'doctype' => 'HTML5',
    'not_found_template' => 'error/404',
    'exception_template' => 'error/index',
    'template_path_stack' => 
    array (
      0 => '/home/juano/Cedna/cedna/module/Application/config/../view',
      1 => '/home/juano/Cedna/cedna/module/Autenticacion/config/../view',
      2 => '/home/juano/Cedna/cedna/module/Configuracion/config/../view',
      3 => '/home/juano/Cedna/cedna/module/Admin/config/../view',
      4 => '/home/juano/Cedna/cedna/module/Formulario/config/../view',
    ),
  ),
  'zenddevelopertools' => 
  array (
    'profiler' => 
    array (
      'collectors' => 
      array (
        'doctrine.sql_logger_collector.orm_default' => 'doctrine.sql_logger_collector.orm_default',
        'doctrine.mapping_collector.orm_default' => 'doctrine.mapping_collector.orm_default',
      ),
    ),
    'toolbar' => 
    array (
      'entries' => 
      array (
        'doctrine.sql_logger_collector.orm_default' => 'zend-developer-tools/toolbar/doctrine-orm-queries',
        'doctrine.mapping_collector.orm_default' => 'zend-developer-tools/toolbar/doctrine-orm-mappings',
      ),
    ),
  ),
  'session_containers' => 
  array (
    0 => 'RegistroUsuario',
    1 => 'RegistroUsuario',
    2 => 'RegistroUsuario',
    3 => 'RegistroUsuario',
    4 => 'RegistroUsuario',
  ),
  'translator' => 
  array (
    'locale' => 'es_ES',
    'translation_file_patterns' => 
    array (
      0 => 
      array (
        'base_dir' => '/home/juano/Cedna/cedna/data/language/phpArray',
        'type' => 'phpArray',
        'pattern' => '%s.php',
      ),
      1 => 
      array (
        'base_dir' => '/home/juano/Cedna/cedna/data/language/gettext',
        'type' => 'gettext',
        'pattern' => '%s.mo',
      ),
      2 => 
      array (
        'base_dir' => '/home/juano/Cedna/cedna/data/language/phpArray',
        'type' => 'phpArray',
        'pattern' => '%s.php',
      ),
      3 => 
      array (
        'base_dir' => '/home/juano/Cedna/cedna/data/language/gettext',
        'type' => 'gettext',
        'pattern' => '%s.mo',
      ),
      4 => 
      array (
        'base_dir' => '/home/juano/Cedna/cedna/config/autoload/../data/languag/phpArray',
        'type' => 'phpArray',
        'pattern' => '%s.php',
      ),
      5 => 
      array (
        'base_dir' => '/home/juano/Cedna/cedna/config/autoload/../data/languag/gettext',
        'type' => 'gettext',
        'pattern' => '%s.mo',
      ),
    ),
  ),
  'session_config' => 
  array (
    'cookie_lifetime' => 3600,
    'gc_maxlifetime' => 2592000,
  ),
  'session_manager' => 
  array (
    'validators' => 
    array (
      0 => 'Zend\\Session\\Validator\\RemoteAddr',
    ),
  ),
  'session_storage' => 
  array (
    'type' => 'Zend\\Session\\Storage\\SessionArrayStorage',
  ),
  'smtp_options' => 
  array (
    'name' => 'gmail.com',
    'host' => 'smtp.gmail.com',
    'connection_class' => 'login',
    'port' => '587',
    'connection_config' => 
    array (
      'ssl' => 'tls',
      'username' => 'mads.trp.2018@gmail.com',
      'password' => 'mads.trp.20181234',
    ),
    'default_subject' => 'CEDNA - Sistema de Permisos de Trabajo',
    'default_from_mail' => 'support@cedna.com.ar',
    'default_from_alias' => 'CEDNA',
  ),
  'datos_empresa' => 
  array (
    'name' => 'Nombre Empresa',
    'phone' => '+5492262772277',
    'logo' => './public/img/Coca-Cola_Femsa_Logo.png',
  ),
  'timer_notifications' => 3000,
);