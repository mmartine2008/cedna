<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="InduccionXOperario")
 */
class InduccionXOperario
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdInduccionXOperario", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Operarios")
     * @ORM\JoinColumn(name="IdOperario", nullable=false, referencedColumnName="IdOperario")
     */
    protected $Operario;

    /**
     * @ORM\ManyToOne(targetEntity="Inducciones")
     * @ORM\JoinColumn(name="IdInduccion", nullable=false, referencedColumnName="IdInduccion")
     */
    protected $Induccion;

    public function setOperario($Operario)
    {
        $this->Operario = $Operario;
    }

    public function setInduccion($Induccion)
    {
        $this->Induccion = $Induccion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOperario()
    {
        return $this->Operario;
    }

    public function getInduccion()
    {
        return $this->Induccion;
    }
}