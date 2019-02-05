<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="SeccionPregunta")
 */
class SeccionPregunta
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdSeccionPregunta", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

     /**
     * @ORM\ManyToOne(targetEntity="Seccion")
     * @ORM\JoinColumn(name="IdSeccion", nullable=false, referencedColumnName="IdSeccion")
     */
    protected $seccion;

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
     * Get the value of seccion
     */ 
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set the value of seccion
     *
     * @return  self
     */ 
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

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
}