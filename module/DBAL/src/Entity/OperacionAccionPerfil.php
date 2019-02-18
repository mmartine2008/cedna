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
     * @ORM\Column(name="urlDestino")
     */
    protected $urlDestino;
    
    /**
     * @ORM\Column(name="jsFunction")
     */
    protected $jsFunction;

    /**
     * @ORM\Column(name="ordenUbicacion")
     */
    protected $ordenUbicacion;

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

    public function setOrdenUbicacion($ordenUbicacion)
    {
        $this->ordenUbicacion = $ordenUbicacion;
    }

    public function setUrlDestino($urlDestino)
    {
        $this->urlDestino = $urlDestino;
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

    public function getOrdenUbicacion()
    {
        return $this->ordenUbicacion;
    }

    public function getUrlDestino()
    {
        return $this->urlDestino;
    }
    
    public function getJsFunction()
    {
        return $this->jsFunction;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"Operacion": ' . $this->getOperacion()->getJSON() .', ';
        $output .= '"Accion": ' . $this->getAccion()->getJSON() .', ';
        $output .= '"Perfil": ' . $this->getPerfil()->getJSON() .', ';
        $output .= '"jsFunction": "' . $this->getJsFunction() .'", ';
        $output .= '"ordenUbicacion": "' . $this->getOrdenUbicacion() .'", ';
        $output .= '"urlDestino": "' . $this->getUrlDestino() .'", ';
        return '{' . $output . '}';
    }
}