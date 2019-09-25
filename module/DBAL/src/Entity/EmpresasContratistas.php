<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="EmpresasContratistas")
 */
class EmpresasContratistas
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdEmpresaContratista", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="RazonSocial")
     */
    protected $RazonSocial;

    /**
     * @ORM\Column(name="Direccion")
     */
    protected $Direccion;

    /**
     * @ORM\Column(name="Telefono")
     */
    protected $Telefono;

    public function setRazonSocial($RazonSocial)
    {
        $this->RazonSocial = $RazonSocial;
    }

    public function setDireccion($Direccion)
    {
        $this->Direccion = $Direccion;
    }

    public function setTelefono($Telefono)
    {
        $this->Telefono = $Telefono;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRazonSocial()
    {
        return $this->RazonSocial;
    }

    public function getDireccion()
    {
        return $this->Direccion;
    }

    public function getTelefono()
    {
        return $this->Telefono;
    }

    public function getJSON(){
        $output = "";
        
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"razonSocial": "' . $this->getRazonSocial() .'", ';
        $output .= '"direccion": "' . $this->getDireccion() .'", ';
        $output .= '"telefono": "' . $this->getTelefono() .'"';
        
        return '{' . $output . '}';
    }
}