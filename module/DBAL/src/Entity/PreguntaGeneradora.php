<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DBAL\Entity\Opcion;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="PreguntaGeneradora")
 */
class PreguntaGeneradora
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdPreguntaGeneradora", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pregunta")
     * @ORM\JoinColumn(name="IdPregunta", nullable=false, referencedColumnName="IdPregunta")
     */
    protected $pregunta;

    /**
     * @ORM\ManyToOne(targetEntity="Opcion")
     * @ORM\JoinColumn(name="IdOpcion", nullable=false, referencedColumnName="IdOpcion")
     */
    protected $opcion;

    /**
     * @ORM\ManyToOne(targetEntity="Pregunta")
     * @ORM\JoinColumn(name="IdPreguntaGenerada", nullable=false, referencedColumnName="IdPregunta")
     */
    protected $preguntaGenerada;

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

    /**
     * Get the value of preguntaGenerada
     */ 
    public function getPreguntaGenerada()
    {
        return $this->preguntaGenerada;
    }

    /**
     * Set the value of preguntaGenerada
     *
     * @return  self
     */ 
    public function setPreguntaGenerada($preguntaGenerada)
    {
        $this->preguntaGenerada = $preguntaGenerada;

        return $this;
    }

    public function getJSON(){
        $output = "";

        $output .= '"idPreguntaGenerada": "' . $this->getId() .'", ';
        $output .= '"opcion": ' . $this->getOpcion()->getJSON() .', ';
        $output .= '"preguntaGenerada": ' . $this->getPreguntaGenerada()->getJSON() .', ';
        
        return '{' . $output . '}';
    }
}