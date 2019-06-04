<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Planificaciones")
 */
class Planificaciones
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdPlanificacion", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tareas")
     * @ORM\JoinColumn(name="IdTarea", referencedColumnName="IdTarea")
     */
    protected $Tarea;

    /**
     * @ORM\ManyToOne(targetEntity="Relevamientos")
     * @ORM\JoinColumn(name="IdRelevamiento", referencedColumnName="IdRelevamiento")
     */
    protected $Relevamiento;

    /**
     * @ORM\Column(name="FechaInicio")
     */
    protected $FechaInicio;


    /**
     * @ORM\Column(name="FechaFin")
     */
    protected $FechaFin;


    /**
     * @ORM\Column(name="HoraInicio")
     */
    protected $HoraInicio;


    /**
     * @ORM\Column(name="HoraFin")
     */
    protected $HoraFin;


    /**
     * @ORM\Column(name="Titulo")
     */
    protected $Titulo;

    /**
     * @ORM\Column(name="Observaciones")
     */
    protected $Observaciones;

    /**
     * @ORM\Column(name="NroEtapaDia")
     */
    protected $NroEtapaDia;

    public function setTarea($Tarea)
    {
        $this->Tarea = $Tarea;
    }

    public function setRelevamiento($Relevamiento)
    {
        $this->Relevamiento = $Relevamiento;
    }

    public function setFechaInicio($FechaInicio)
    {
        $this->FechaInicio = $FechaInicio;
    }

    public function setFechaFin($FechaFin)
    {
        $this->FechaFin = $FechaFin;
    }

    public function setHoraInicio($HoraInicio)
    {
        $this->HoraInicio = $HoraInicio;
    }

    public function setHoraFin($HoraFin)
    {
        $this->HoraFin = $HoraFin;
    }

    public function setTitulo($Titulo)
    {
        $this->Titulo = $Titulo;
    }

    public function setObservaciones($Observaciones)
    {
        $this->Observaciones = $Observaciones;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTarea()
    {
        return $this->Tarea;
    }

    public function getRelevamiento()
    {
        return $this->Relevamiento;
    }

    public function getFechaInicio()
    {
        if (is_string($this->FechaInicio)){
            $fecha = date("d-m-Y", strtotime($this->FechaInicio));
            return $fecha;
        }else{
            return $this->FechaInicio->format('d-m-Y');
        }
    }

    public function getFechaFin()
    {
        if (is_string($this->FechaFin)){
            $fecha = date("d-m-Y", strtotime($this->FechaFin));
            return $fecha;
        }else{
            return $this->FechaFin->format('d-m-Y');
        }
    }

    public function getHoraInicio()
    {
        return $this->HoraInicio;
    }

    public function getHoraFin()
    {
        return $this->HoraFin;
    }

    public function getTitulo()
    {
        return $this->Titulo;
    }

    public function getObservaciones()
    {
        return $this->Observaciones;
    }

    public function setNroEtapaDia($NroEtapaDia)
    {
        $this->NroEtapaDia = $NroEtapaDia;
    }

     public function getNroEtapaDia()
    {
        return $this->NroEtapaDia;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        
        if ($this->getRelevamiento()){
            $output .= '"relevamiento": ' . $this->getRelevamiento()->getJSON() .', ';
        }else{
            $output .= '"relevamiento": "", ';
        }

        $output .= '"fechaInicio": "' . $this->getFechaInicio() .'", ';
        $output .= '"fechaFin": "' . $this->getFechaFin() .'", ';
        $output .= '"horaInicio": "' . $this->getHoraInicio() .'", ';
        $output .= '"horaFin": "' . $this->getHoraFin() .'", ';
        $output .= '"titulo": "' . $this->getTitulo() .'", ';
        $output .= '"diaEtapa": "' . $this->getNroEtapaDia() .'", ';
        $output .= '"observaciones": "' . $this->getObservaciones() .'"';
        
        return '{' . $output . '}';
    }
}