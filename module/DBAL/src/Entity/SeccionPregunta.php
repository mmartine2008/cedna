<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="app.SeccionPregunta")
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
     * @ORM\Column(name="Required",  nullable=false, type="integer", length=1)
     */
    protected $requerido;

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

    /**
     * Get the value of requerido
     */ 
    public function getRequerido()
    {
        return $this->requerido;
    }

    /**
     * Set the value of requerido
     *
     * @return  self
     */ 
    public function setRequerido($requerido)
    {
        $this->requerido = $requerido;

        return $this;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"requerido": "' . $this->getRequerido() .'",';
        if ($this->getPregunta()) {
            $output .= '"pregunta": ' . $this->getPregunta()->getJSON() .'';
        }
        
        return '{' . $output . '}';
    }
}