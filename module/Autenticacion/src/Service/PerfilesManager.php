<?php

/**
 * Este servicio es responsable de realizar alta, baja, modificacion
 * y seleccion de perfiles.
 * 
 * @author      Nicolas Garcia
 */


namespace Autenticacion\Service;

use DBAL\Entity\Perfiles;
use DBAL\Entity\Roles;
use DBAL\Entity\Usuarios as EntidadUsuarios;
use DBAL\Entity\Establecimientos;
use DBAL\Entity\UsuariosxPerfiles;
use DBAL\Entity\OperadoresInSitu;
use DBAL\Entity\Empresas;
use DBAL\Entity\Operacion;
use DBAL\Entity\Accion;
use DBAL\Entity\OperacionAccion;

class PerfilesManager
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
    
    /**
     * Busca perfiles segun nombre o descripcion
     * @param type $nombre
     * @param type $descripcion
     * @return type
     */
    public function buscarPerfiles($parametros){

        $filtro = [];
        if (array_key_exists('nomPerfil', $parametros) && 
            ($parametros['nomPerfil'] != '')
            )
        {
            $filtro['nombre'] = $parametros['nomPerfil'];
        }

        if (array_key_exists('descrPerfil', $parametros) && 
        ($parametros['descrPerfil'] != '')
        )
        {
            $filtro['Descripcion'] = $parametros['descrPerfil'];
        }

        $perfiles = $this->getAllPerfilesInternos($filtro);
            
        return $perfiles;
    }
    
    /**
     * Borra el detalle de un perfil, para poder editarlo
     * @param type $Perfil
     */
    private function borrarDetallePerfil($Perfil)
    {
        $PerfilesAcciones = $this->entityManager
                                ->getRepository(OperacionAccion::class)
                                ->findBy(['Perfil' => $Perfil]);
        
        foreach ($PerfilesAcciones as $PerfilAccion) {
            $this->entityManager->remove($PerfilAccion);
        }
        
        $this->entityManager->flush();
    }
    
    public function deletePerfil($id){
        $this->entityManager->beginTransaction();
        try {
            $Perfil = $this->entityManager->
                    getRepository(Perfiles::class)->findOneBy(['id' => $id]);

            $this->entityManager->remove($Perfil);

            $this->entityManager->flush();

            $this->entityManager->commit();

            return 'Se ha eliminado el Perfil seleccionado';
        } catch (\Exception $e) {

            $this->entityManager->rollBack();

            return 'No se ha podido eliminar. Probablemente el Perfil se encuentre en uso';
        }
        

    }
    
    private function saveNewPerfil($nombre, $descripcion) {
        $perfil = new Perfiles();
        $perfil->setNombre($nombre); 
        $perfil->setDescripcion($descripcion);                
        $perfil->setInterno(1);
        $perfil->setDefaultHome('gestion');
        
        $em = $this->entityManager;
        $em->persist($perfil);
        $em->flush();

        return $perfil;
    }

    private function formularDetallePerfil($Perfil, $rolesTexto, $item) {
        $OperacionAccion = new OperacionAccion();
        
        $OperacionAccion->setPerfil($Perfil);
        
        if (count($item['childs'])==0)
        {
            $operacionId = $rolesTexto['id'];
            $accionId = $item['id'];
            if ($item['seleccionado'])
            {
                $Accion = $this->getAccion($accionId);
                $OperacionAccion->setAccion($Accion);
            }
        } else
        {
            $operacionId = $item['id'];
        }

        $Operacion = $this->getOperacion($operacionId);
        $OperacionAccion->setOperacion($Operacion);

        $this->entityManager->persist($OperacionAccion);
        $this->entityManager->flush();
        
    }
    

    private function saveDetallePerfil($Perfil, $rolesTexto) {
        foreach ($rolesTexto['childs'] as $item)
        {
            if (array_key_exists('seleccionado', $item))
            {
                $this->formularDetallePerfil($Perfil, $rolesTexto, $item);
                
                $this->saveDetallePerfil($Perfil, $item);
            }
        }
        
    }

    private function actualizarNobreyDescripcion($Perfil, $nombre, $descripcion)
    {
        $Perfil->setNombre($nombre);
        $Perfil->setDescripcion($descripcion);
        $this->entityManager->persist($Perfil);
        $this->entityManager->flush();

    }
    
    public function savePerfiles($params){
        
        $nombre = $params['nomPerfil'];
        $descripcion = $params['descrPerfil'];
        
        if (array_key_exists('idPerfil', $params))
        {
            // Recupero el perfil anterior, y borro su contenido
            $Perfil = $this->getPerfilById($params['idPerfil']);
            $this->borrarDetallePerfil($Perfil);            
        } else
        {
            // Grabo el nuevo perfil
            $Perfil = $this->saveNewPerfil($nombre, $descripcion);
        }
        
        $rolesTexto = json_decode($params['rolesTexto'], true);

        $this->actualizarNobreyDescripcion($Perfil, $nombre, $descripcion);

        // Graba el detalle del perfil
        $this->saveDetallePerfil($Perfil, $rolesTexto);
    }
    
    public function setRoles($perfil,$data){
        $rolesTexto= $data['rolesTexto'];
        $rolesJson = json_decode($rolesTexto);
 
        foreach ($rolesJson as $roles){             
            $auxRol = $this->entityManager->getRepository(Roles::class)->
                        findOneBy(['id' => $roles->Id]);
            $perfil->addRol($auxRol);   
            }
    }
    
    public function setPerfiles($usuario,$data){
        $perfilesTexto= $data['perfilesTexto'];
        $perfilesJson = json_decode($perfilesTexto);
 
        
        foreach ($perfilesJson as $perfil){             
            $auxPerfil = $this->entityManager->getRepository(Perfiles::class)->
                        findOneBy(['id' => $perfil->IdPerfil]);
            $usuario->addPerfil($auxPerfil);              
            }

    }
    
    public function updatePerfiles($idPerfil,$params){
        $em = $this->entityManager;
        $nombre = $params['nomPerfil'];
        $desc = $params['descrPerfil'];

        $perfil = $this->entityManager->
            getRepository(Perfiles::class)->
                        findOneBy(['id' => $idPerfil]);
        $perfil->setDescripcion($desc);   
        $perfil->setNombre($nombre); 
        $perfil->removeAllRoles();
        $this->setRoles($perfil,$params);
                       
        $em->persist($perfil);
        
        $em->flush();
    }
      
  
    public function getPerfilById($id){
        return $this->entityManager->getRepository(Perfiles::class)->
                        findOneBy(['id' => $id]);
        
    }
    
    public function getAllPerfiles(){
        return $this->entityManager->getRepository(Perfiles::class)->findAll();
    }
    
    public function getAllPerfilesInternos($parametros = null){
        $parametros['interno'] = 1;
        
        return $this->entityManager->getRepository(Perfiles::class)->
                findby($parametros);
    }
    
    
    
    public function getUsuarioByFullName($fullName)
    {
        $usuario = $this->entityManager->
                getRepository(EntidadUsuarios::class)->
                findOneBy(['fullName' => $fullName]);
        
        return $usuario;
    }
    
    public function getUsuarioPerfil($Perfil, $fullname)
    {
        $Usuario = $this->getUsuarioByFullName($fullname);
        
        $usuarioXPerfil = $this->entityManager->
                getRepository(UsuariosxPerfiles::class)->
                findOneBy(['usuario' => $Usuario->getId(), 
                        'perfil' => $Perfil->getId()]);

        return $usuarioXPerfil;
    } 

    public function getPerfilByNombre($perfilNombre)
    {
        $Perfil = $this->entityManager->
                getRepository(Perfiles::class)->
                findOneBy(['nombre' => $perfilNombre]);

        return $Perfil;        
    }

    public function getUsuario($nombreUsuario) 
    {
        $Usuario = $this->entityManager->
                getRepository(EntidadUsuarios::class)->findOneBy(['fullName'=>$nombreUsuario]);
        
        return $Usuario;
    }      

    public function getEmpresaFromUsuariosPerfil($UsuarioxPerfil)
    {
        if ($UsuarioxPerfil){
            $Usuario = $UsuarioxPerfil->getUsuario();
            $nombre = $Usuario->getFullName();

            $Empresa = $this->entityManager->
                    getRepository(Empresas::class)->
                    findOneBy(['cuit' => $nombre]);

            return $Empresa; 
        }  
        
        return null;
    }
    
    public function getEstablecimientoFromUsuariosPerfil($UsuarioxPerfil)
    {
        if ($UsuarioxPerfil){
            $Usuario = $UsuarioxPerfil->getUsuario();
            $nombre = $Usuario->getFullName();

            $Empresa = $this->entityManager->
                    getRepository(Establecimientos::class)->
                    findOneBy(['CuitNro' => $nombre]);

            return $Empresa;
        }
        
        return null;
    }  
    
    public function getOperadorInSituFromUsuariosPerfil($UsuarioxPerfil)
    {
        if ($UsuarioxPerfil){
            $Usuario = $UsuarioxPerfil->getUsuario();
            $nombre = $Usuario->getFullName();

            $Empresa = $this->entityManager->
                    getRepository(OperadoresInSitu::class)->
                    findOneBy(['CuitNro' => $nombre]);

            return $Empresa; 
        }
        
        return null;
    } 
 
    public function getPerfiles()
    {
        $perfiles = $this->entityManager->
                getRepository(Perfiles::class)->
                findAll();
        
        return $perfiles;
    }
    
    public function getPerfilOperador(){
        $Perfil = $this->entityManager->getRepository(Perfiles::class)
                                            ->findOneBy(['nombre' => Perfiles::PERFIL_OPERADOR]);
        
        return $Perfil;
    }
    
    public function getOperaciones() {
        $Operaciones = $this->entityManager
                                ->getRepository(Operacion::class)
                                ->findAll();
        
        return $Operaciones;
    }
    
    public function getOperacion($id) {
        $Operacion = $this->entityManager
                                ->getRepository(Operacion::class)
                                ->findOneBy(['Id' => $id]);
        
        return $Operacion;
    }
    
    public function getAccion($id) {
        $Operacion = $this->entityManager
                                ->getRepository(Accion::class)
                                ->findOneBy(['Id' => $id]);
        
        return $Operacion;
    }
    
    public function altaOperacion($data) {
        $nombre     = $data['nombre'];
        $titulo     = $data['titulo'];
        $icono      = $data['icono'];
        $grupoId    = $data['grupoId'];
        $orden    = $data['orden'];
       
        $Operacion = new Operacion();
        
        $Grupo = $this->getOperacion($grupoId);

        $Operacion->setNombre($nombre);
        $Operacion->setTitulo($titulo);
        $Operacion->setIcono($icono);
        $Operacion->setOrden($orden);
        
        if ($Grupo) {
            $Operacion->setParent($Grupo);        
        }
        
        $this->entityManager->persist($Operacion);
        $this->entityManager->flush();
        
        return "Operacion agregada";
    }
    
    public function editarOperacion($data) {
        $id         = $data['id'];
        $nombre     = $data['nombre'];
        $titulo     = $data['titulo'];
        $icono      = $data['icono'];
        $grupoId    = $data['grupoId'];
        $orden    = $data['orden'];

        if ($id == $grupoId) {
            return "No se puede referenciar a si misma";
        }
       
        $Operacion = $this->getOperacion($id);
        
        $Grupo = $this->getOperacion($grupoId);

        $Operacion->setNombre($nombre);
        $Operacion->setTitulo($titulo);
        $Operacion->setIcono($icono);
        $Operacion->setOrden($orden);
        
        if ($Grupo) {
            $Operacion->setParent($Grupo);        
        } else {
            $Operacion->setParent(null);        
        }
        
        $this->entityManager->persist($Operacion);
        $this->entityManager->flush();
        
        return "Operacion modificada";
    }
    
    public function borrarOperacion($id)
    {
        $this->entityManager->beginTransaction();
        try {
            $entityManager = $this->entityManager;
            $Entidad = $this->getOperacion($id);
            $entityManager->remove($Entidad);
            $entityManager->flush();

            $this->entityManager->commit();

            return 'Se ha eliminado la Operación seleccionada';
        } catch (\Exception $e) {

            $this->entityManager->rollBack();

            return 'No se ha podido eliminar. Probablemente la Operación se encuentre en uso';
        }        
    }
    
    public function getOperacionesRaiz()
    {
        $Operaciones = $this->entityManager
                                ->getRepository(Operacion::class)
                                ->findBy(['parent' => null], ['orden' => 'ASC']);
        
        return $Operaciones;
    }
    
    public function getJSONOperaciones() {
        $Operaciones = $this->getOperacionesRaiz();
        
        $json = [];
        foreach ($Operaciones as $Operacion) {
            $jsonOperacion = $Operacion->getJSON();
            $json[] = $jsonOperacion;
        }
            
        $resultado = implode (',', $json);
        
        return '{"childs": [' . $resultado . ']}';
    }
    
    public function getAcciones() {
        $Acciones = $this->entityManager
                                ->getRepository(Accion::class)
                                ->findAll();
        
        return $Acciones;
    }

    public function getJSONAcciones() {
        $Acciones = $this->getAcciones();
        
        $json = [];
        foreach ($Acciones as $Accion) {
            $json[] = $Accion->getJSON();
        }
            
        $json = implode (',', $json);
        
        return '{"acciones": [' . $json . ']}';
    }

    public function getJSONOperacionesAcciones($idPerfil)
    {
        $Perfil = $this->getPerfilById($idPerfil);
        
        $PerfilesAcciones = $this->entityManager
                                ->getRepository(OperacionAccion::class)
                                ->findBy(['Perfil' => $Perfil]);
        
        $resultado = [];
        foreach ($PerfilesAcciones as $PerfilAccion) {
            
            $Operacion = $PerfilAccion->getOperacion();
            $operacion_id = $Operacion->getId();
            
            if (!array_key_exists($operacion_id , $resultado))
            {
                $resultado[$operacion_id] = ['Operacion' => $operacion_id, 'Acciones' => []];
            }
            if ($PerfilAccion->getAccion()) {
                $accion_id = $PerfilAccion->getAccion()->getId();
                $resultado[$operacion_id ]['Acciones'][] = $accion_id;
            }
        }
        
        $output = [];
        foreach ($resultado as $contenido)
        {
            $output[] = $contenido;
        }
        
        return json_encode($output);
        
    }
    
    private function operacionPermitida($Operacion, $Perfil)
    {
        $PerfilesAcciones = $this->entityManager
                                ->getRepository(OperacionAccion::class)
                                ->findBy(['Perfil' => $Perfil, 'Operacion' => $Operacion]);
        
        return (count($PerfilesAcciones) > 0);
    }

    private function operacionAccionPermitida($Operacion, $Accion, $Perfil)
    {
        $PerfilesAcciones = $this->entityManager
                                ->getRepository(OperacionAccion::class)
                                ->findBy(['Perfil' => $Perfil, 
                                    'Operacion' => $Operacion, 
                                    'Accion' => $Accion]);
        
        return (count($PerfilesAcciones) > 0);
    }
    
    
    /**
     * Recorre la lista de operaciones y por cada una devuelve una
     * sublista de operaciones permitidas
     * @param type $operaciones
     * @param type $Perfil
     * @return type
     */
//    private function filtrarOperaciones($operaciones, $Perfil)
//    {
//        $resultado = [];
//        foreach ($operaciones as $Operacion) {
//            if ($this->operacionPermitida($Operacion, $Perfil)) {
//                $permitidas = $this->filtrarOperaciones($Operacion->getChildren(), $Perfil);
//                $resultado [$Operacion->getId()] = [$Operacion, $permitidas];                
//            }            
//        }
//        return $resultado;
//    }
    
   
    private function filtrarOperaciones($operaciones, $Perfil)
    {
        $resultado = [];
        foreach ($operaciones as $Operacion) {
            if ($this->operacionPermitida($Operacion, $Perfil)) {
                
                $arrOperacion = $Operacion->getArray();
                $arrOperacion['childs'] = $this->filtrarOperaciones($Operacion->getChildren(), $Perfil);
                
                $resultado [] = $arrOperacion;                
            }            
        }
        return $resultado;
    }
    
    /**
     * Devuelve las opeaciones por Perfil
     */
    public function getOperacionesPerfil ($Perfil) {
        $operaciones = $this->getOperacionesRaiz();
        
        $resultado = $this->filtrarOperaciones($operaciones, $Perfil);

        return $resultado;
        
    }
    
    
}
