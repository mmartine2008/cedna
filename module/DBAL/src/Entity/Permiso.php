<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Permiso")
 */
class Permiso
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdPermiso", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Descripcion",  nullable=true, type="string", length=1000)
     */
    protected $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Formulario", mappedBy="Permiso")
     */
    protected $formularios;
    
    public function __construct()
    {
        $this->formularios = new ArrayCollection();
    }

    public function getFormularios()
    {
        if ($this->formularios){
            return $this->formularios->toArray();
        }else{
            return null;
        }
    }

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

    public function getJSON(){
        $output = "";

        $formularios = [];
        foreach ($this->getFormularios() as $formulario) {
            $formularios[] = $formulario->getJSON();
        }
        $formularios = implode(", ", $formularios);

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"formularios": ['.$formularios.']';
        return '{' . $output . '}';
    }
}