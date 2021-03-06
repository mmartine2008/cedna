<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="RelevamientosxSecciones")
 */
class RelevamientosxSecciones
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdRelevamientoxSeccion", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Relevamientos")
     * @ORM\JoinColumn(name="IdRelevamiento", nullable=false, referencedColumnName="IdRelevamiento")
     */
    protected $relevamiento;

    /**
     * @ORM\ManyToOne(targetEntity="Seccion")
     * @ORM\JoinColumn(name="IdSeccion", nullable=false, referencedColumnName="IdSeccion")
     */
    protected $seccion;

      /**
     * @ORM\Column(name="seccionGlobal",  nullable=true, type="integer")
     */
    protected $seccionGlobal;

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
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get the value of seccionGlobal
     */ 
    public function getSeccionGlobal()
    {
        if($this->seccionGlobal) {
            return $this->seccionGlobal;
        }

        return false;
    }

    /**
     * Set the value of seccionGlobal
     *
     * @return  self
     */ 
    public function setSeccionGlobal($seccionGlobal)
    {
        $this->seccionGlobal = $seccionGlobal;

        return $this;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"idRelevamiento": "' . $this->getRelevamiento()->getId() .'", ';
        $output .= '"seccionGlobal": "' . $this->getSeccionGlobal() .'",';
        if ($this->getSeccion()) {
            $output .= '"seccion": ' . $this->getSeccion()->getJSON() .'';
        }
        
        return '{' . $output . '}';
    }
}