<?php

/**
 *Este controlador gestiona la interacción del usuario con el sistema
 *para acceder a las funcionalidades referentes a perfiles.
 * 
 * @author      
 */

namespace Autenticacion\Controller;

use Application\Controller\BaseInternoController;
use Zend\View\Model\ViewModel;



class PerfilesController extends BaseInternoController 
{


    private $rolesManager;

    /**
     * Constructor. 
     */
    public function __construct($permisosManager, $userSessionManager,$perfilesManager,$rolesManager)
    {      
        parent::__construct($permisosManager, $userSessionManager, null, 
                        null, $perfilesManager, null);
        $this->rolesManager = $rolesManager;
    }
           
    
    public function indexAction()
    {
        $this->prepareAction(
                                [
                                'titulo' => 'Configuración Perfiles',
                                'breadcrumb' => [
                                        ['href'=>'/gestion', 'name'=>'Inicio'],
                                        ['name'=>'Seguridad'],
                                        ['active'=>true, 'name'=>'Configuración Perfiles']
                                        ]]
                            );
        
        $request = $this->getRequest();
        $perfiles = [];
        $data = [];
        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            
        } 
        $perfiles = $this->perfilesManager->buscarPerfiles($data);

        return new ViewModel([ 'perfiles' => $perfiles]
                                );
    }
    
    protected function getTituloPanel()
    {
        return "Consulta de Manifiestos";
    }
 
    public function deletePerfilAction(){
        // Verifica que sea un requerimiento via Javascript:
        $xmlHttpRequst = $this->getRequest()->isXmlHttpRequest();
        if (! $xmlHttpRequst) {
            throw new \Exception('Acceso no permitido');
        }
        
        $id = $this->params()->fromRoute('param1');
        $this->perfilesManager->deletePerfil($id);

    }
    
    
    public function altaAction(){
        
        $this->prepareAction(
                                [
                                'titulo' => 'Alta de Perfil',
                                'breadcrumb' => [
                                        ['href'=>'/gestion', 'name'=>'Inicio'],
                                        ['name'=>'Seguridad'],
                                        ['name' => 'Configuración Perfiles'],
                                        ['active'=>true, 'name'=>'Alta']
                                        ]]
                            );
        $request = $this->getRequest();

         if ($request->isPost()) {
            $data = $this->params()->fromPost();
            
            $this->perfilesManager->savePerfiles($data);
            
            $this->userSessionManager->addMessage('Alta de perfil exitosa.');
            
            $this->redirect()->toRoute('perfiles');
        }
        
        return new ViewModel(
                [
                 'seleccionadas' => 'null',
                 'perfilesJSON' => $this->perfilesManager->getJSONOperaciones(),
                 'accionesJSON' => $this->perfilesManager->getJSONAcciones()
                ]
                );    
    }
    
    public function editarAction(){
         $this->prepareAction(
                                [
                                'titulo' => 'Modificación de Perfil',
                                'breadcrumb' => [
                                        ['href'=>'/gestion', 'name'=>'Inicio'],
                                        ['name'=>'Seguridad'],
                                        ['name' => 'Configuración Perfiles'],
                                        ['active'=>true, 'name'=>'Editar']
                                        ]]
                            );
        $request = $this->getRequest();
        
        $params = $this->params()->fromRoute();
        $idPerfil = $params['id'];

        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $this->perfilesManager->savePerfiles($data);
            $this->userSessionManager->addMessage('Modificación de perfil exitosa.');
            $this->redirect()->toRoute('perfiles');
        }

        $view = new ViewModel([
                 'perfil' => $this->perfilesManager->getPerfilById($idPerfil),
                 'seleccionadas' => $this->perfilesManager->getJSONOperacionesAcciones($idPerfil),
                 'perfilesJSON' => $this->perfilesManager->getJSONOperaciones(),
                 'accionesJSON' => $this->perfilesManager->getJSONAcciones()
                ]);
        
        $view->setTemplate('usuarios/perfiles/alta.phtml');
        
        return $view;
    }
    
}
