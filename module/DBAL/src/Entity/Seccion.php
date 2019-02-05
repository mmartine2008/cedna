<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Seccion")
 */
class Seccion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdSeccion", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

     /**
     * @ORM\ManyToOne(targetEntity="Formulario")
     * @ORM\JoinColumn(name="IdFormulario", nullable=true, referencedColumnName="IdFormulario")
     */
    protected $formulario;

    /**
     * @ORM\ManyToOne(targetEntity="TipoSeccion")
     * @ORM\JoinColumn(name="IdTipoSeccion", nullable=true, referencedColumnName="IdTipoSeccion")
     */
    protected $tipoSeccion;

    

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
     * Get the value of formulario
     */ 
    public function getFormulario()
    {
        return $this->formulario;
    }

    /**
     * Set the value of formulario
     *
     * @return  self
     */ 
    public function setFormulario($formulario)
    {
        $this->formulario = $formulario;

        return $this;
    }

    /**
     * Get the value of tipoSeccion
     */ 
    public function getTipoSeccion()
    {
        return $this->tipoSeccion;
    }

    /**
     * Set the value of tipoSeccion
     *
     * @return  self
     */ 
    public function setTipoSeccion($tipoSeccion)
    {
        $this->tipoSeccion = $tipoSeccion;

        return $this;
    }
}