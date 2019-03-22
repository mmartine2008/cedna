<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Operarios")
 */
class Operarios
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdOperario", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Nombre")
     */
    protected $Nombre;


    /**
     * @ORM\Column(name="Apellido")
     */
    protected $Apellido;


    /**
     * @ORM\Column(name="CUIT")
     */
    protected $CUIT;


    /**
     * @ORM\Column(name="Telefono")
     */
    protected $Telefono;


    /**
     * @ORM\Column(name="Email")
     */
    protected $Email;

    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    public function setApellido($Apellido)
    {
        $this->Apellido = $Apellido;
    }

    public function setCuit($CUIT)
    {
        $this->CUIT = $CUIT;
    }

    public function setTelefono($Telefono)
    {
        $this->Telefono = $Telefono;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }

    public function getApellido()
    {
        return $this->Apellido;
    }

    public function getCuit()
    {
        return $this->CUIT;
    }

    public function getTelefono()
    {
        return $this->Telefono;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        $output .= '"apellido": "' . $this->getApellido() .'", ';
        $output .= '"cuit": "' . $this->getCuit() .'", ';
        $output .= '"telefono": "' . $this->getTelefono() .'", ';
        $output .= '"email": "' . $this->getEmail() .'"';
        
        return '{' . $output . '}';
    }
}