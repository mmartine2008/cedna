<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="PreguntaOpcion")
 */
class PreguntaOpcion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdPreguntaOpcion", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

     /**
     * @ORM\ManyToOne(targetEntity="Opcion")
     * @ORM\JoinColumn(name="IdOpcion", nullable=false, referencedColumnName="IdOpcion")
     */
    protected $opcion;

    /**
     * @ORM\ManyToOne(targetEntity="Pregunta")
     * @ORM\JoinColumn(name="IdPregunta", nullable=false, referencedColumnName="IdPregunta")
     */
    protected $pregunta;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of pregunta
     */ 
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set the value of pregunta
     *
     * @return  self
     */ 
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get the value of opcion
     */ 
    public function getOpcion()
    {
        return $this->opcion;
    }

    /**
     * Set the value of opcion
     *
     * @return  self
     */ 
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;

        return $this;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"pregunta": "' . $this->getPregunta()->getJSON() .'", ';
        $output .= '"opcion": "' . $this->getOpcion()->getJSON() .'", ';
        return '{' . $output . '}';
    }
}