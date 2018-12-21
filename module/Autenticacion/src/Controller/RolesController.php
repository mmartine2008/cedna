<?php

/**
 *Este controlador gestiona la interacción del usuario con el sistema
 *para acceder a las funcionalidades referentes a roles.
 * 
 * @author      
 */

namespace Autenticacion\Controller;

use Application\Controller\BaseInternoController;
use Zend\View\Model\ViewModel;


class RolesController extends BaseInternoController 
{


    private $rolesManager;

    /**
     * Constructor. 
     */
    public function __construct($permisosManager, $userSessionManager, $rolesManager)
    {      
        parent::__construct($permisosManager, $userSessionManager, null, 
                null, null);
        
        $this->rolesManager = $rolesManager;
    }
      
    
    public function indexAction()
    {
        $this->prepareAction(
                                [
                                'titulo' => 'Roles',
                                'breadcrumb' => [
                                        ['href'=>'/gestion', 'name'=>'Inicio'],
                                        ['name'=>'Seguridad'],
                                        ['active'=>true, 'name'=>'Roles']
                                        ]]
                            );
        $request = $this->getRequest();
        $categ = -1;   $desc = '';
        
        $categorias = $this->rolesManager->getCategs();
        
         if ($request->isPost()) {
            $data = $this->params()->fromPost();
            
            $categ = $data['CategoriaRol'];
            $desc = $data['descrRol'];
        }
        
        $roles = $this->rolesManager->getRoles($desc,$categ);

        return new ViewModel([ 'roles' => $roles,
                                'categorias' => $categorias]
                                );
    }
   
    protected function getTituloPanel()
    {
        return "Consulta de Manifiestos";
    }
 
    public function deleteRolAction(){
        // Verifica que sea un requerimiento via Javascript:
        $xmlHttpRequst = $this->getRequest()->isXmlHttpRequest();
        if (! $xmlHttpRequst) {
            throw new \Exception('Acceso no permitido');
        } 
        
        $id = $this->params()->fromRoute('param1');
        $this->rolesManager->deleteRol($id);

    }
    
    public function getCategoriasAction(){
        
        $categ = $this->rolesManager->getCategs();
        $categJson = $this->rolesManager->categToJson($categ);
        $view = new ViewModel(
                ['mostrarJson' => $categJson]
                            );
     
        $view->setTerminal(true);
        $view->setTemplate('manifiestos/manifiestos/mostrarJson.phtml');

        return  $view;
    }
    
    public function altaAction(){
        
        $this->prepareAction(
                                [
                                'titulo' => 'Alta de Rol',
                                'breadcrumb' => [
                                        ['href'=>'/gestion', 'name'=>'Inicio'],
                                        ['name'=>'Seguridad'],
                                        ['name' => 'Roles'],
                                        ['active'=>true, 'name'=>'Alta']
                                        ]]
                            );
        $request = $this->getRequest();

         if ($request->isPost()) {
            $data = $this->params()->fromPost();
            
            $this->rolesManager->saveRoles($data);
            
            $this->userSessionManager->addMessage('Alta de rol exitosa.');
            $this->redirect()->toRoute('roles');
        }
        
        $categorias = $this->rolesManager->getCategs();
        
        return new ViewModel(['categorias' => $categorias]);
    }
    
    public function editarAction(){
        
        $this->prepareAction(
                                [
                                'titulo' => 'Modificación de Rol',
                                'breadcrumb' => [
                                        ['href'=>'/gestion', 'name'=>'Inicio'],
                                        ['name'=>'Seguridad'],
                                        ['name' => 'Roles'],
                                        ['active'=>true, 'name'=>'Editar']
                                        ]]
                            );
        $request = $this->getRequest();
        
        $params = $this->params()->fromRoute();
        $idRol = $params['id'];
        

         if ($request->isPost()) {
            $data = $this->params()->fromPost();
            
            $this->rolesManager->updateRoles($idRol,$data);
            
            $this->userSessionManager->addMessage('Modificación de rol exitosa.');
            
            $this->redirect()->toRoute('roles');
        }
        
        $view = new ViewModel();
        
        $view->setVariable('rol', $this->rolesManager->getRolById($idRol));
        $view->setVariable('categorias', $this->rolesManager->getCategs());
        $view->setTemplate('usuarios/roles/alta.phtml');
        
        return $view;
    }
}
