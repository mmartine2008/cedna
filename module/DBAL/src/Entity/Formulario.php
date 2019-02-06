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
     * @ORM\JoinColumn(name="IdPermiso", referencedColumnName="IdPermiso")
     */
    protected $Permiso;


    /**
     * @ORM\Column(name="Descripcion")
     */
    protected $Descripcion;

    public function setPermiso($Permiso)
    {
        $this->Permiso = $Permiso;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPermiso()
    {
        return $this->Permiso;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }
}