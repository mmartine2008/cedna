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

    public function __construct() {
        $this->Respuestas = new ArrayCollection();
    }

    public function setFormulario($Formulario)
    {
        $this->Formulario = $Formulario;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFormulario()
    {
        return $this->Formulario;
    }

    public function getRespuestas()
    {
        if ($this->Respuestas){
            return $this->Respuestas->toArray();
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

        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"perfiles": ['.$respuestas.'],';
        $output .= '"formulario": ' . $this->getFormulario()->getJSON();
        
        return '{' . $output . '}';
    }
}