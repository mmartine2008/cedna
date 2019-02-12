<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="UsuariosxPerfiles")
 */
class UsuariosxPerfiles
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdUsuarioxPerfil", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdUsuario", referencedColumnName="IdUsuario")
     */
    protected $Usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Perfiles")
     * @ORM\JoinColumn(name="IdPerfil", referencedColumnName="IdPerfil")
     */
    protected $Perfil;

    public function setUsuario($Usuario)
    {
        $this->Usuario = $Usuario;
    }

    public function setPerfil($Perfil)
    {
        $this->Perfil = $Perfil;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsuario()
    {
        return $this->Usuario;
    }

    public function getPerfil()
    {
        return $this->Perfil;
    }

}