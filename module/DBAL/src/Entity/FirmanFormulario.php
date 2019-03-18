<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="FirmanFormulario")
 */
class FirmanFormulario
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdFirmaFormulario", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Perfiles")
     * @ORM\JoinColumn(name="IdPerfil", referencedColumnName="IdPerfil")
     */
    protected $Perfil;

    /**
     * @ORM\ManyToOne(targetEntity="Formulario")
     * @ORM\JoinColumn(name="IdFormulario", referencedColumnName="IdFormulario")
     */
    protected $Formulario;

    public function setFormulario($Formulario)
    {
        $this->Formulario = $Formulario;
    }

    public function setPerfil($Perfil)
    {
        $this->Perfil = $Perfil;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFormulario()
    {
        return $this->Formulario;
    }

    public function getPerfil()
    {
        return $this->Perfil;
    }

}