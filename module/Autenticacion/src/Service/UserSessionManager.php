<?php

/**
 * Este servicio es un Wrapper de la Session
 * Centraliza los pedidos de nombre de usaurio, perfiles, perfil activo,
 * tarea activa, etc.
 * 
 * @author      Mariano Martinez
 */

namespace Autenticacion\Service;

class UserSessionManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $sessionContainer; 
    
    /**
     * Constructor del Servicio
     */
    public function __construct($sessionContainer) 
    {
        $this->sessionContainer = $sessionContainer;
    }
 
    /**
     * Manejo de mensaje
     * @param type $mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->sessionContainer->mensaje = $mensaje;
    }

    public function addMessage($mensaje)
    {
        if ($this->isSetMensaje()) {
            $this->sessionContainer->mensaje .= '</p>'. $mensaje;
        } else
        {
            $this->setMensaje($mensaje);
        }
    }
    
    public function getMensaje()
    {
        return $this->sessionContainer->mensaje;
    }

    public function isSetMensaje()
    {
        return isset($this->sessionContainer->mensaje);
    }

    public function unsetMensaje()
    {
        unset($this->sessionContainer->mensaje);
    }

    /**
     * Gestion de userName
     * @return type
     */
    public function getUserName()
    {
        $dataSession = $this->sessionContainer->session;
        $userName = $dataSession[0];
        
        return $userName;
    }
 
    /**
     * Para compatibilidad con el servicio de autorizacion
     * registra un para [nombre, perfiles]
     * @return type
     */
    public function setUserName($userName)
    {
        $dataSession = [$userName];
        $this->sessionContainer->session = $dataSession;
    }
    
    public function isSetUserName()
    {
        return isset($this->sessionContainer->session);
    }
    
    /**
     * Gestion de perfiles
     * La session guarda en el 0 el cuit o nombre de usaurio y en 1 el arreglo de perfiles
     * Sucede que en el alta de empresa no hay 1, por eso lo controlo
     * @return type
     */
    public function getPerfiles()
    {
        $dataSession = $this->sessionContainer->session;
        if (isset($dataSession[1]))
        {
            $perfiles = $dataSession[1];
            return $perfiles;
        }
        return null;
    }

    public function isLogged()
    {
        return isset($this->sessionContainer->perfilActivo);
    }
    /**
     * Recupera una instancia de Perfil de la Session
     * @return type
     */
    public function getPerfilActivo()
    {
        if (!isset($this->sessionContainer->perfilActivo)) 
        {
            $this->sessionContainer->perfilActivo = 0;
        }
        $id_perfilActivo = $this->sessionContainer->perfilActivo;
        $perfiles = $this->getPerfiles();
        
        
        $PerfilActivo = $perfiles[$id_perfilActivo];
        
        return $PerfilActivo;
    }
    
    public function setPerfilActivo($perfilActivo){
        $this->sessionContainer->perfilActivo = $perfilActivo;
    }

    public function getManifiestoId()
    {
        $manifiestoId = $this->sessionContainer->manifiestoId;
        
        return $manifiestoId;
    }
    
    public function setManifiestoId($manifiestoId)
    {
        $this->sessionContainer->manifiestoId = $manifiestoId;
    }   
    
     public function getTamanioPaginacion()
    {
        $tamanio = $this->sessionContainer->tamanio;
        
        return $tamanio;
    }
    
    public function setTamanioPaginacion($tamanio)
    {
        $this->sessionContainer->tamanio = $tamanio;
    }

    public function getRazonSocial()
    {
        $razonSocial = $this->sessionContainer->razonSocial;
        
        return $razonSocial;
    }
    
    public function getFiltros(){
        
        return $this->sessionContainer->filtros;
    }
    
    public function limpiarFiltros(){
        $this->sessionContainer->filtros = [];
    }

    public function setFiltros($filtros){
        $this->sessionContainer->filtros = $filtros;
    }

    public function getFiltrosEstadisticas(){
        
        return $this->sessionContainer->filtrosEstadisticas;
    }

    public function setFiltrosEstadisticas($filtrosEstadisticas){
        $this->sessionContainer->filtrosEstadisticas = $filtrosEstadisticas;
    }

    public function limpiarFiltrosEstadisticas(){
        $this->sessionContainer->filtrosEstadisticas = [];
    }

    public function getFiltrosEstablecimiento(){
        
        return $this->sessionContainer->filtrosEstablecimiento;
    }
    
    public function limpiarFiltrosEstablecimiento(){
        $this->sessionContainer->filtrosEstablecimiento = [];
    }

    public function setFiltrosEstablecimiento($filtros){
        $this->sessionContainer->filtrosEstablecimiento = $filtros;
    }

    public function getFiltrosEmpresa(){
        
        return $this->sessionContainer->filtrosEmpresa;
    }
    
    public function limpiarFiltrosEmpresa(){
        $this->sessionContainer->filtrosEmpresa = [];
    }

    public function setFiltrosEmpresa($filtros){
        $this->sessionContainer->filtrosEmpresa = $filtros;
    }

    private function unsetFiltros(){
        unset($this->sessionContainer->filtros);
        unset($this->sessionContainer->filtrosEstablecimiento);
        unset($this->sessionContainer->filtrosEmpresa);
        //unset($this->sessionContainer->filtrosEmpresa);
    }

    public function setDatosRespInsc($datos) 
    {
        $this->sessionContainer->razonSocial = $datos;
    }
    
    public function setEmail($email)
    {
        $this->sessionContainer->email = $email;
    }

    public function getEmail()
    {
        return $this->sessionContainer->email;
    }  
    
    public function setClave($Clave)
    {
        $this->sessionContainer->Clave = $Clave;
    }

    public function getClave()
    {
        return $this->sessionContainer->Clave;
    }
    
    public function setIdRelTTManifiesto($id_rel_tt_manifiesto)
    {
        $this->sessionContainer->id_rel_tt_manifiesto = $id_rel_tt_manifiesto;
    }
 
    public function getIdRelTTManifiesto()
    {
        return $this->sessionContainer->id_rel_tt_manifiesto;
    }
    
    public function setDescripcionConfiguracion($Descripcion){
        $this->sessionContainer->Descripcion = $Descripcion;
    }
    
    public function getDescripcionConfiguracion(){
        return $this->sessionContainer->Descripcion;
    }
    
    public function setCategoriaConfiguracion($Categoria){
        $this->sessionContainer->Categoria = $Categoria;
    }
    
    public function getCategoriaConfiguracion(){
        return $this->sessionContainer->Categoria;
    }
    
    public function setToleranciaConfiguracion($Tolerancia){
        $this->sessionContainer->Tolerancia = $Tolerancia;
    }
    
    public function getToleranciaConfiguracion(){
        return $this->sessionContainer->Tolerancia;
    }
    
    public function limpiarCategoriaConfiguracion() {
        $this->sessionContainer->Categoria = '';
    }
    
    public function limpiarToleranciaConfiguracion() {
        $this->sessionContainer->Tolerancia = '';
    }
    
    public function limpiarDescripcionConfiguracion() {
        $this->sessionContainer->Descripcion = '';
    }

    public function cerrar()
    {
        unset($this->sessionContainer->email);
        unset($this->sessionContainer->razonSocial);
        unset($this->sessionContainer->manifiestoId);
        unset($this->sessionContainer->perfilActivo);
        unset($this->sessionContainer->session);
        $this->unsetFiltros();
    }
    
    public function getDatosRespIns()
    {
        return $this->sessionContainer->razonSocial;
    }
    
    public function esInterno()
    {
        $Perfil = $this->getPerfilActivo();
        if ($Perfil != null)
        {
            return $Perfil->esInterno();
        } else
        {
            return false;
        }
    }
    
    public function setTokenCompraVep()
    {
        $token = md5(random_int(1, 1000));
        $this->sessionContainer->tokenCompraVep = $token;
        
        return $this->getTokenCompraVep();
    }
    
    public function getTokenCompraVep()
    {
        return $this->sessionContainer->tokenCompraVep;
    }
    
    public function getMontoTasa(){
        return $this->sessionContainer->MontoTasa;
    }
    
    public function setMontoTasa($monto){
        $this->sessionContainer->MontoTasa = $monto;
    }

    public function setTokenFacturaVep()
    {
        $token = md5(random_int(1, 1000));
        $this->sessionContainer->tokenCompraVep = $token;
        
        return $this->getTokenFacturaVep();
    }
    
    public function getTokenFacturaVep()
    {
        return $this->sessionContainer->tokenCompraVep;
    }
}
