<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Formulario")
 */
class Formulario
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdFormulario", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

     /**
     * @ORM\ManyToOne(targetEntity="Permiso")
     * @ORM\JoinColumn(name="IdPermiso", nullable=true, referencedColumnName="IdPermiso")
     */
    protected $permiso;

    /**
     * @ORM\Column(name="Descripcion",  nullable=true, type="string", length=1000)
     */
    protected $descripcion;

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
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        if ($this->descripcion){
            return $this->descripcion;
        } else {
            return "";
        }
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of permiso
     */ 
    public function getPermiso()
    {
        return $this->permiso;
    }

    /**
     * Set the value of permiso
     *
     * @return  self
     */ 
    public function setPermiso($permiso)
    {
        $this->permiso = $permiso;

        return $this;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        if ($this->getPermiso()) {
            $output .= '"permiso": "' . $this->getPermiso()->getJSON() .'", ';
        }
        return '{' . $output . '}';
    }
 
}