<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Respuesta")
 */
class Respuesta
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdRespuesta", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Descripcion",  nullable=true, type="string", length=2000)
     */
    protected $descripcion;

     /**
     * @ORM\ManyToOne(targetEntity="Permiso")
     * @ORM\JoinColumn(name="IdPermiso", nullable=true, referencedColumnName="IdPermiso")
     */
    protected $permiso;

    /**
     * @ORM\ManyToOne(targetEntity="Pregunta")
     * @ORM\JoinColumn(name="IdPregunta", nullable=true, referencedColumnName="IdPregunta")
     */
    protected $pregunta;

    /**
     * @ORM\ManyToOne(targetEntity="Opcion")
     * @ORM\JoinColumn(name="IdOpcion", nullable=true, referencedColumnName="IdOpcion")
     */
    protected $opcion;

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
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        if ($this->getPermiso()) {
            $output .= '"permiso": ' . $this->getPermiso()->getJSON() .', ';
        }
        if ($this->getOpcion()) {
            $output .= '"opcion": ' . $this->getOpcion()->getJSON() .', ';
        }
        return '{' . $output . '}';
    }
}