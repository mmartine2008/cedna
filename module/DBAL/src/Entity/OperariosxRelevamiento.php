<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="OperariosxRelevamiento")
 */
class OperariosxRelevamiento
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
     * @ORM\ManyToOne(targetEntity="Operarios")
     * @ORM\JoinColumn(name="IdOperario", nullable=false, referencedColumnName="IdOperario")
     */
    protected $operario;

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
    public function getOperario()
    {
        return $this->operario;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setOperario($operario)
    {
        $this->operario = $operario;

        return $this;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"operario": ' . $this->getOperario()->getJSON() .'';
        $output .= '"relevamiento": ' . $this->getRelevamiento()->getJSON() .'';
        // ver si no genera loop
    
        return '{' . $output . '}';
    }
}