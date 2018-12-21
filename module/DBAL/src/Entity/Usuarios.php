<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Crypt\Password\Bcrypt;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Usuarios")
 */
class Usuarios
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdUsuario", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;


    /**
     * @ORM\Column(name="NombreUsuario")
     */
    protected $NombreUsuario;


    /**
     * @ORM\Column(name="Clave")
     */
    protected $Clave;


    /**
     * @ORM\Column(name="IdEstado")
     */
    protected $IdEstado;


    /**
     * @ORM\Column(name="FechaAlta")
     */
    protected $FechaAlta;


    /**
     * @ORM\Column(name="Email")
     */
    protected $Email;


    /**
     * @ORM\Column(name="TipoUsuario")
     */
    protected $TipoUsuario;


    /**
     * @ORM\Column(name="Nombre")
     */
    protected $Nombre;


    /**
     * @ORM\Column(name="Apellido")
     */
    protected $Apellido;


    /**
     * @ORM\Column(name="AceptaTerminosUso")
     */
    protected $AceptaTerminosUso;

    public function setNombreUsuario($NombreUsuario)
    {
        $this->NombreUsuario = $NombreUsuario;
    }

    public function setClave($Clave)
    {
        $this->Clave = $Clave;
    }

    public function setIdEstado($IdEstado)
    {
        $this->IdEstado = $IdEstado;
    }

    public function setFechaAlta($FechaAlta)
    {
        $this->FechaAlta = $FechaAlta;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    public function setTipoUsuario($TipoUsuario)
    {
        $this->TipoUsuario = $TipoUsuario;
    }

    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    public function setApellido($Apellido)
    {
        $this->Apellido = $Apellido;
    }

    public function setAceptaTerminosUso($AceptaTerminosUso)
    {
        $this->AceptaTerminosUso = $AceptaTerminosUso;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombreUsuario()
    {
        return $this->NombreUsuario;
    }

    public function getClave()
    {
        return $this->Clave;
    }

    public function getIdEstado()
    {
        return $this->IdEstado;
    }

    public function getFechaAlta()
    {
        return $this->FechaAlta;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getTipoUsuario()
    {
        return $this->TipoUsuario;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }

    public function getApellido()
    {
        return $this->Apellido;
    }

    public function getAceptaTerminosUso()
    {
        return $this->AceptaTerminosUso;
    }
}