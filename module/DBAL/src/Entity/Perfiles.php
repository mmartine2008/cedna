<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="app.Perfiles")
 */
class Perfiles
{
    const ID_CONTRATISTA = 3;
    CONST ID_COMITENTE = 5;

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

    public function esComitente(){
        return ($this->id == SELF::ID_COMITENTE);
    }

    public function esContratista(){
        return ($this->id == SELF::ID_CONTRATISTA);
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        $output .= '"esComitente": "' . $this->esComitente() .'", ';
        $output .= '"esContratista": "' . $this->esContratista() .'"';
        return '{' . $output . '}';
    }
}