<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdEjecutor", referencedColumnName="IdUsuario")
     */
    protected $Ejecutor;

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
     * @ORM\ManyToOne(targetEntity="OrdenesDeCompra")
     * @ORM\JoinColumn(name="IdOrdenDeCompra", referencedColumnName="IdOrdenDeCompra")
     */
    protected $OrdenDeCompra;

    /**
     * @ORM\ManyToOne(targetEntity="Relevamientos")
     * @ORM\JoinColumn(name="IdRelevamiento", referencedColumnName="IdRelevamiento")
     */
    protected $Relevamiento;

    /**
     * @ORM\ManyToOne(targetEntity="TipoPlanificacion")
     * @ORM\JoinColumn(name="IdTipoPlanificacion", referencedColumnName="IdTipoPlanificacion")
     */
    protected $TipoPlanificacion;

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

    /**
     * @ORM\OneToMany(targetEntity="Planificaciones", mappedBy="Tarea")
     */
    protected $Planificaciones;

    public function __construct() {
        $this->Planificaciones = new ArrayCollection();
    }

    public function setSolicitante($Solicitante)
    {
        $this->Solicitante = $Solicitante;
    }

    public function setNodo($Nodo)
    {
        $this->Nodo = $Nodo;
    }

    public function setEjecutor($Ejecutor)
    {
        $this->Ejecutor = $Ejecutor;
    }

    public function setResponsable($Responsable)
    {
        $this->Responsable = $Responsable;
    }

    public function setTipoPlanificacion($TipoPlanificacion)
    {
        $this->TipoPlanificacion = $TipoPlanificacion;
    }

    public function setPlanificaTarea($PlanificaTarea)
    {
        $this->PlanificaTarea = $PlanificaTarea;
    }

    public function setEstadoTarea($EstadoTarea)
    {
        $this->EstadoTarea = $EstadoTarea;
    }

    public function setOrdenDeCompra($OrdenDeCompra)
    {
        $this->OrdenDeCompra = $OrdenDeCompra;
    }

    public function setRelevamiento($Relevamiento)
    {
        $this->Relevamiento = $Relevamiento;
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

    public function getEjecutor()
    {
        return $this->Ejecutor;
    }

    public function getResponsable()
    {
        return $this->Responsable;
    }

    public function getPlanificaTarea()
    {
        return $this->PlanificaTarea;
    }

    public function getTipoPlanificacion()
    {
        return $this->TipoPlanificacion;
    }

    public function getNodo()
    {
        return $this->Nodo;
    }

    public function getEstadoTarea()
    {
        return $this->EstadoTarea;
    }

    public function getOrdenDeCompra()
    {
        return $this->OrdenDeCompra;
    }

    public function getRelevamiento()
    {
        return $this->Relevamiento;
    }

    public function getFechaSolicitud()
    {
        if (is_string($this->FechaSolicitud)){
            $fecha = date("d-m-Y", strtotime($this->FechaSolicitud));
            return $fecha;
        }else{
            return $this->FechaSolicitud->format('d-m-Y');
        }
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function getResumen()
    {
        return $this->Resumen;
    }

    public function getPlanificaciones()
    {
        if ($this->Planificaciones){
            return $this->Planificaciones->toArray();
        }else{
            return null;
        }
    } 

    private function getJsonEjecutor(){
        if($this->getEjecutor()) {
             return $this->getEjecutor()()->getJSON();
        }
        return '" "';
    }

    private function getJsonResponsable(){
        if($this->getResponsable()) {
             return $this->getResponsable()->getJSON();
        }
        return '" "';
    }

    private function getJsonPlanificaTarea(){
        if($this->getPlanificaTarea()) {
             return $this->getPlanificaTarea()->getJSON();
        }
        return '" "';
    }

    private function getJsonNodo(){
        if($this->getNodo()) {
             return $this->getNodo()->getJSON();
        }
        return '" "';
    }

    private function getJsonEstadoTarea(){
        if($this->getEstadoTarea()) {
             return $this->getEstadoTarea()->getJSON();
        }
        return '" "';
    }

    public function getJSON(){
        $planificaciones = [];
        foreach ($this->getPlanificaciones() as $planificacion) {
            $planificaciones[] = $planificacion->getJSON();
        }
        $planificaciones = implode(", ", $planificaciones);

        $output = "";
        
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"solicitante": ' . $this->getSolicitante()->getJSON() .', ';
        $output .= '"ejecutor": ' . $this->getJsonEjecutor() .', ';
        $output .= '"responsable": ' . $this->getJsonResponsable() .', ';
        $output .= '"planificaTarea": ' . $this->getJsonPlanificaTarea() .', ';
        $output .= '"nodo": ' . $this->getJsonNodo() .', ';
        $output .= '"estadoTarea": ' . $this->getJsonEstadoTarea() .', ';
        
        if ($this->getOrdenDeCompra()){
            $output .= '"ordenDeCompra": ' . $this->getOrdenDeCompra()->getJSON() .', ';
        }else{
            $output .= '"ordenDeCompra": "", ';
        }

        if ($this->getTipoPlanificacion()){
            $output .= '"tipoPlanificacion": ' . $this->getTipoPlanificacion()->getJSON() .', ';
        }else{
            $output .= '"tipoPlanificacion": "", ';
        }
        
        if ($this->getRelevamiento()){
            $output .= '"relevamiento": ' . $this->getRelevamiento()->getJSON() .', ';
        }else{
            $output .= '"relevamiento": "", ';
        }
        
        $output .= '"fechaSolicitud": "' . $this->getFechaSolicitud() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"resumen": "' . $this->getResumen() .'", ';
        $output .= '"planificaciones": ['.$planificaciones.']';
        
        return '{' . $output . '}';
    }
}