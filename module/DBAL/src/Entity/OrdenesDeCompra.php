<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="OrdenesDeCompra")
 */
class OrdenesDeCompra
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdOrdenDeCompra", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="FechaLiberacion")
     */
    protected $FechaLiberacion;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdSolicitante", referencedColumnName="IdUsuario")
     */
    protected $Solicitante;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdEjecutor", referencedColumnName="IdUsuario")
     */
    protected $Ejecutor;

    /**
     * @ORM\ManyToOne(targetEntity="Nodos")
     * @ORM\JoinColumn(name="IdNodo", referencedColumnName="IdNodo")
     */
    protected $Nodo;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdResponsable", referencedColumnName="IdUsuario")
     */
    protected $Responsable;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdPlanificaTarea", referencedColumnName="IdUsuario")
     */
    protected $PlanificaTarea;

    /**
     * @ORM\Column(name="Descripcion")
     */
    protected $Descripcion;

    public function setFechaLiberacion($FechaLiberacion)
    {
        $this->FechaLiberacion = $FechaLiberacion;
    }

    public function setSolicitante($Solicitante)
    {
        $this->Solicitante = $Solicitante;
    }

    public function setEjecutor($Ejecutor)
    {
        $this->Ejecutor = $Ejecutor;
    }

    public function setNodo($Nodo)
    {
        $this->Nodo = $Nodo;
    }

    public function setResponsable($Responsable)
    {
        $this->Responsable = $Responsable;
    }

    public function setPlanificaTarea($PlanificaTarea)
    {
        $this->PlanificaTarea = $PlanificaTarea;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFechaLiberacion()
    {
        if (is_string($this->FechaLiberacion)){
            $fecha = date("d-m-Y", strtotime($this->FechaLiberacion));
            return $fecha;
        }else{
            return $this->FechaLiberacion->format('d-m-Y');
        }
    }

    public function getSolicitante()
    {
        return $this->Solicitante;
    }

    public function getEjecutor()
    {
        return $this->Ejecutor;
    }

    public function getNodo()
    {
        return $this->Nodo;
    }

    public function getResponsable()
    {
        return $this->Responsable;
    }

    public function getPlanificaTarea()
    {
        return $this->PlanificaTarea;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"fechaLiberacion": "' . $this->getFechaLiberacion() .'", ';
        $output .= '"solicitante": ' . $this->getSolicitante()->getJSON() .', ';
        $output .= '"ejecutor": ' . $this->getEjecutor()->getJSON() .', ';
        $output .= '"responsable": ' . $this->getResponsable()->getJSON() .', ';
        $output .= '"planificaTarea": ' . $this->getPlanificaTarea()->getJSON() .', ';
        $output .= '"nodo": ' . $this->getNodo()->getJSON();
        
        return '{' . $output . '}';
    }
}