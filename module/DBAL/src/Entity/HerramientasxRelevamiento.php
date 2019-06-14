<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="HerramientasxRelevamiento")
 */
class HerramientasxRelevamiento
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Relevamientos")
     * @ORM\JoinColumn(name="IdRelevamiento", nullable=false, referencedColumnName="IdRelevamiento")
     */
    protected $relevamiento;

    /**
     * @ORM\ManyToOne(targetEntity="HerramientasDeTrabajo")
     * @ORM\JoinColumn(name="IdHerramienta", nullable=false, referencedColumnName="Id")
     */
    protected $herramienta;

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
     * Get the value of id
     */ 
    public function getRelevamiento()
    {
        return $this->relevamiento;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setRelevamiento($relevamiento)
    {
        $this->relevamiento = $relevamiento;

        return $this;
    }


    /**
     * Get the value of id
     */ 
    public function getHerramienta()
    {
        return $this->herramienta;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setHerramienta($herramienta)
    {
        $this->herramienta = $herramienta;

        return $this;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"herramienta": ' . $this->getHerramienta()->getJSON() .'';
        $output .= '"relevamiento": ' . $this->getRelevamiento()->getJSON() .'';
        // ver si no genera loop

        return '{' . $output . '}';
    }
}