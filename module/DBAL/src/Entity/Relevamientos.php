<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Relevamientos")
 */
class Relevamientos
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdRelevamiento", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Formulario")
     * @ORM\JoinColumn(name="IdFormulario", referencedColumnName="IdFormulario")
     */
    protected $Formulario;

    /**
     * @ORM\OneToMany(targetEntity="Respuesta", mappedBy="relevamiento")
     */
    protected $Respuestas;

    /**
     * @ORM\ManyToOne(targetEntity="EstadosRelevamiento")
     * @ORM\JoinColumn(name="IdEstadoRelevamiento", referencedColumnName="IdEstadoRelevamiento")
     */
    protected $EstadoRelevamiento;

    /**
     * @ORM\OneToMany(targetEntity="NodosFirmantesRelevamiento", mappedBy="Relevamiento")
     */
    protected $NodosFirmantesRelevamiento;

    public function __construct() {
        $this->Respuestas = new ArrayCollection();
        $this->NodosFirmantesRelevamiento = new ArrayCollection();
    }

    public function setFormulario($Formulario)
    {
        $this->Formulario = $Formulario;
    }

    public function setEstadoRelevamiento($EstadoRelevamiento)
    {
        $this->EstadoRelevamiento = $EstadoRelevamiento;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFormulario()
    {
        return $this->Formulario;
    }

    public function getEstadoRelevamiento()
    {
        return $this->EstadoRelevamiento;
    }

    public function getRespuestas()
    {
        if ($this->Respuestas){
            return $this->Respuestas->toArray();
        }else{
            return null;
        }
    }

    public function getNodosFirmantesRelevamiento()
    {
        if ($this->NodosFirmantesRelevamiento){
            return $this->NodosFirmantesRelevamiento->toArray();
        }else{
            return null;
        }
    }

    public function getJSON(){
        $respuestas = [];
        foreach ($this->getRespuestas() as $respuesta) {
            $respuestas[] = $respuesta->getJSON();
        }
        $respuestas = implode(", ", $respuestas);

        $nodosFirmantes = [];
        foreach ($this->getNodosFirmantesRelevamiento() as $nodoFirmante) {
            $nodosFirmantes[] = $nodoFirmante->getJSON();
        }
        $nodosFirmantes = implode(", ", $nodosFirmantes);

        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"perfiles": ['.$respuestas.'],';
        $output .= '"nodosFirmantes": ['.$nodosFirmantes.'],';
        $output .= '"estadoRelevamiento": ' . $this->getEstadoRelevamiento()->getJSON() .', ';
        $output .= '"formulario": ' . $this->getFormulario()->getJSON();
        
        return '{' . $output . '}';
    }
}