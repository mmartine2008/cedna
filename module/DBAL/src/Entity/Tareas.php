<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Tareas")
 */
class Tareas
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdTarea", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdSolicitante", referencedColumnName="IdUsuario")
     */
    protected $Solicitante;

    /**
     * @ORM\ManyToOne(targetEntity="Nodos")
     * @ORM\JoinColumn(name="IdNodo", referencedColumnName="IdNodo")
     */
    protected $Nodo;

    /**
     * @ORM\ManyToOne(targetEntity="EstadoTarea")
     * @ORM\JoinColumn(name="IdEstadoTarea", referencedColumnName="IdEstadoTarea")
     */
    protected $EstadoTarea;

    /**
     * @ORM\ManyToOne(targetEntity="Formulario")
     * @ORM\JoinColumn(name="IdFormulario", referencedColumnName="IdFormulario")
     */
    protected $Formulario;

    /**
     * @ORM\Column(name="FechaSolicitud")
     */
    protected $FechaSolicitud;

    /**
     * @ORM\Column(name="Descripcion")
     */
    protected $Descripcion;

    /**
     * @ORM\Column(name="Resumen")
     */
    protected $Resumen;

    public function setSolicitante($Solicitante)
    {
        $this->Solicitante = $Solicitante;
    }

    public function setNodo($Nodo)
    {
        $this->Nodo = $Nodo;
    }

    public function setEstadoTarea($EstadoTarea)
    {
        $this->EstadoTarea = $EstadoTarea;
    }

    public function setFormulario($Formulario)
    {
        $this->Formulario = $Formulario;
    }

    public function setFechaSolicitud($FechaSolicitud)
    {
        $this->FechaSolicitud = $FechaSolicitud;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function setResumen($Resumen)
    {
        $this->Resumen = $Resumen;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSolicitante()
    {
        return $this->Solicitante;
    }

    public function getNodo()
    {
        return $this->Nodo;
    }

    public function getEstadoTarea()
    {
        return $this->EstadoTarea;
    }

    public function getFormulario()
    {
        return $this->Formulario;
    }

    public function getFechaSolicitud()
    {
        return $this->FechaSolicitud;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function getResumen()
    {
        return $this->Resumen;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"solicitante": ' . $this->getSolicitante()->getJSON() .', ';
        $output .= '"nodo": ' . $this->getNodo()->getJSON() .', ';
        $output .= '"estadoTarea": ' . $this->getEstadoTarea()->getJSON() .', ';
        $output .= '"formulario": ' . $this->getFormulario()->getJSON() .', ';
        $output .= '"fechaSolicitud": "' . $this->getFechaSolicitud() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"resumen": "' . $this->getResumen() .'"';
        
        return '{' . $output . '}';
    }
}