<?php

/**
 * Este servicio es responsable de realizar alta, baja, modificacion
 * y seleccion de roles.
 * 
 * @author      Nicolas Garcia
 */


namespace Usuarios\Service;

use DBAL\Entity\Roles;
use DBAL\Entity\CategoriasRoles;

class RolesManager
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
    
    public function getRoles($descripcion,$categoria){
        
        if(($descripcion == '') and ($categoria == -1)){
            $roles = $this->entityManager->getRepository(Roles::class)->findAll();
        }
        else{
            $parametros = [];
            if(trim($descripcion) != ''){
                $parametros['Descripcion'] = $descripcion;
            }
            if(trim($categoria) != -1){
                $categ = $this->entityManager->
                getRepository(CategoriasRoles::class)->
                        findOneBy(['id' => $categoria]);
                $parametros['categoriaRol'] = $categ;
            }
    
            $roles = $this->entityManager->
            getRepository(Roles::class)->findBy($parametros);
        }
        
        return $roles;
    }
    
    public function getCategs(){
        
        $categs = $this->entityManager->getRepository(CategoriasRoles::class)->findAll();
        
        return $categs;
    }
    
    
    
   public function rolesToJson($roles){
        
        $retorno = [];
        
        foreach($roles as $rol){
            $categ = '';
            if($rol->getCategoriaRol() != null){
                $categ = $rol->getCategoriaRol()->getDescripcion();
            }
            $rolAux = [
                'IdRol' => $rol->getId(),
                'Descripcion' => $rol->getDescripcion(),
                'Categoria' => $categ
            ];
            
            $retorno[] = $rolAux;
        }

        
        return json_encode($retorno);
    }
    
    public function categToJson($categToJson){
        
        $retorno = [];
        
        foreach($categToJson as $categ){  
            $categAux = [
                'IdCateg' => $categ->getId(),
                'Descripcion' => $categ->getDescripcion(),
            ];
            
            $retorno[] = $categAux;
        }

        
        return json_encode($retorno);
    }
    
    
    public function deleteRol($id){
        $em = $this->entityManager;
        
        $rol = $this->entityManager->
                getRepository(Roles::class)->findOneBy(['id' => $id]);
               
        $em->remove($rol);
        
        $em->flush();
    }
    
    public function saveRoles($params){
        $categoria = $params['CategoriaRol'];
        $desc = $params['descrRol'];
        
        $rol = new Roles ();
        $rol->setDescripcion($desc);                
        if(trim($categoria) != -1){
            $categ = $this->entityManager->
            getRepository(CategoriasRoles::class)->
                        findOneBy(['id' => $categoria]);
            $rol->setCategoriaRol($categ);    
        }
        $em = $this->entityManager;
               
        $em->persist($rol);
        
        $em->flush();
    }
    
    public function updateRoles($idRol,$params){
        $em = $this->entityManager;
        $categoria = $params['CategoriaRol'];
        $desc = $params['descrRol'];
        
        
        
        $rol = $this->entityManager->
            getRepository(Roles::class)->
                        findOneBy(['id' => $idRol]);
        $rol->setDescripcion($desc);   
        

        if(trim($categoria) != -1){
            $categ = $this->entityManager->
            getRepository(CategoriasRoles::class)->
                        findOneBy(['id' => $categoria]);
            $rol->setCategoriaRol($categ);    
        }
        else{
           $rol->setCategoriaRol(NULL);   
        }
                       
        $em->persist($rol);
        
        $em->flush();
    }
      
    
    public function getRolById($id){
        return $this->entityManager->getRepository(Roles::class)->
                        findOneBy(['id' => $id]);
        
    }
}
