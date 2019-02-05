<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="OperacionAccionPerfil")
 */
class OperacionAccionPerfil
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Operacion")
     * @ORM\JoinColumn(name="IdOperacion", referencedColumnName="Id")
     */
    protected $Operacion;

    /**
     * @ORM\ManyToOne(targetEntity="Accion")
     * @ORM\JoinColumn(name="IdAccion", referencedColumnName="Id")
     */
    protected $Accion;

    /**
     * @ORM\ManyToOne(targetEntity="Perfiles")
     * @ORM\JoinColumn(name="IdPerfil", referencedColumnName="IdPerfil")
     */
    protected $Perfil;

    /**
     * @ORM\Column(name="controllerName")
     */
    protected $controllerName;

    /**
     * @ORM\Column(name="controllerAction")
     */
    protected $controllerAction;
    
    /**
     * @ORM\Column(name="jsFunction")
     */
    protected $jsFunction;

    public function setOperacion($Operacion)
    {
        $this->Operacion = $Operacion;
    }

    public function setAccion($Accion)
    {
        $this->Accion = $Accion;
    }

    public function setPerfil($Perfil)
    {
        $this->Perfil = $Perfil;
    }

    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    public function setControllerAction($controllerAction)
    {
        $this->controllerAction = $controllerAction;
    }

    public function setJsFunction($jsFunction)
    {
        $this->jsFunction = $jsFunction;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOperacion()
    {
        return $this->Operacion;
    }

    public function getAccion()
    {
        return $this->Accion;
    }

    public function getPerfil()
    {
        return $this->Perfil;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getControllerAction()
    {
        return $this->controllerAction;
    }
    
    public function getJsFunction()
    {
        return $this->jsFunction;
    }
}