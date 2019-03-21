<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="Bloqueado")
     */
    protected $Bloqueado;

    /**
     * @ORM\Column(name="FechaAlta")
     */
    protected $FechaAlta;

    /**
     * @ORM\Column(name="Email")
     */
    protected $Email;

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

    /**
     * @ORM\ManyToMany(targetEntity="Perfiles", inversedBy="Usuario", cascade={"persist"})
     * @ORM\JoinTable(name="dbo.UsuariosxPerfiles",
     *      joinColumns={@ORM\JoinColumn(name="IdUsuario", referencedColumnName="IdUsuario")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="IdPerfil", referencedColumnName="IdPerfil")}
     *      )
     */
    protected $Perfiles;

    public function __construct() {
        $this->Perfiles = new ArrayCollection();
    }

    public function setNombreUsuario($NombreUsuario)
    {
        $this->NombreUsuario = $NombreUsuario;
    }

    public function setClave($Clave)
    {
        $this->Clave = $Clave;
    }

    public function setBloqueado($Bloqueado)
    {
        $this->Bloqueado = $Bloqueado;
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

    public function getBloqueado()
    {
        return $this->Bloqueado;
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

    public function getJSON(){
        $perfiles = [];
        foreach ($this->getPerfiles() as $perfil) {
            $perfiles[] = $perfil->getJSON();
        }
        $perfiles = implode(", ", $perfiles);

        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"userName": "' . $this->getNombreUsuario() .'", ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        $output .= '"apellido": "' . $this->getApellido() .'", ';
        $output .= '"email": "' . $this->getEmail() .'", ';
        //$output .= '"clave": "' . $this->getClave() .'", ';
        $output .= '"perfiles": ['.$perfiles.']';
        return '{' . $output . '}';
    }

    /**
     * @return array
     */
    public function getPerfiles()
    {
        if ($this->Perfiles){
            return $this->Perfiles->toArray();
        }else{
            return null;
        }
    }

    /**
     * @param Perfiles|null $perfil
     */
    public function addPerfil(Perfiles $perfil = null)
    {
        if (!$this->Perfiles->contains($perfil)) {
            $this->Perfiles->add($perfil);
        }
    }

    public function removeAllPerfiles()
    {
        $this->Perfiles->clear();
    }
}