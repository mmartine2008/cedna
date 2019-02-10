<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Perfiles")
 */
class Perfiles
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdPerfil", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Descripcion")
     */
    protected $Descripcion;

    /**
     * @ORM\Column(name="Nombre")
     */
    protected $Nombre;

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        return '{' . $output . '}';
    }
}