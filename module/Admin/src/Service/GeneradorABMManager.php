<?php

namespace Admin\Service;

class GeneradorABMManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
        
    }

    public function generarArchivoController($nombreEntidad, $pathArchivo){
        $stringController = \file_get_contents();

        $stringController = str_replace('$NombreModulo', $nombreEntidad.'Controller', $stringController);
        $stringController = str_replace('$NombreEntidad', $nombreEntidad, $stringController);
        $stringController = str_replace('$nombre_entidad', strtolower($nombreEntidad), $stringController);

        file_put_contents($nombreEntidad.'Controller.php', $stringController);
    }

    public function generarArchivoControllerFactory($nombreEntidad, $pathArchivo){
        $stringController = \file_get_contents();

        $stringController = str_replace('$NombreModulo', $nombreEntidad.'Controller', $stringController);
        $stringController = str_replace('$NombreEntidad', $nombreEntidad, $stringController);
        $stringController = str_replace('$nombre_entidad', strtolower($nombreEntidad), $stringController);

        file_put_contents($nombreEntidad.'ControllerFactory.php', $stringController);
    }

    public function generarArchivoManager($nombreEntidad, $pathArchivo){
        $stringController = \file_get_contents();

        $stringController = str_replace('$NombreModulo', $nombreEntidad.'Manager', $stringController);
        $stringController = str_replace('$NombreEntidad', $nombreEntidad, $stringController);
        
        //FALTA RESOLVER LOS SET DE ATRIBUTOS

        file_put_contents($nombreEntidad.'Manager.php', $stringController);
    }

    public function generarArchivoManagerFactory($nombreEntidad, $pathArchivo){
        $stringController = \file_get_contents();

        $stringController = str_replace('$NombreModulo', $nombreEntidad.'Manager', $stringController);
        $stringController = str_replace('$NombreEntidad', $nombreEntidad, $stringController);

        file_put_contents($nombreEntidad.'ManagerFactory.php', $stringController);
    }
}