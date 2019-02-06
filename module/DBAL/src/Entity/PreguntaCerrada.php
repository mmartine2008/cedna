<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="PreguntaCerrada")
 */
class PreguntaCerrada
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdPreguntaCerrada", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

     /**
     * @ORM\ManyToOne(targetEntity="Pregunta")
     * @ORM\JoinColumn(name="IdPregunta", nullable=false, referencedColumnName="IdPregunta")
     */
    protected $pregunta;

     /**
     * @ORM\ManyToOne(targetEntity="TipoPregunta")
     * @ORM\JoinColumn(name="IdTipoPregunta", nullable=true, referencedColumnName="IdTipoPregunta")
     */
    protected $tipoPregunta;

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
     * Get the value of tipoPregunta
     */ 
    public function getTipoPregunta()
    {
        return $this->tipoPregunta;
    }

    /**
     * Set the value of tipoPregunta
     *
     * @return  self
     */ 
    public function setTipoPregunta($tipoPregunta)
    {
        $this->tipoPregunta = $tipoPregunta;

        return $this;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"pregunta": "' . $this->getPregunta()->getJSON() .'", ';
        if ($this->getTipoPregunta()) {
            $output .= '"tipoPregunta": "' . $this->getTipoPregunta()->getJSON() .'", ';
        }
        return '{' . $output . '}';
    }
}