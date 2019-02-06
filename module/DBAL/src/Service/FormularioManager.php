<?php

/**
 * Este servicio es responsable de realizar alta, baja, modificacion
 * y seleccion de perfiles.
 * 
 * @author      Nicolas Garcia
 */


namespace DBAL\Service;



class FormularioManager
{
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
    
    
    
}
