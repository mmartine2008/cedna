<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="esJefeDe")
 */
class esJefeDe
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdEsJefeDe", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Nodos")
     * @ORM\JoinColumn(name="IdNodo", referencedColumnName="IdNodo")
     */
    protected $IdNodo;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdUsuario", referencedColumnName="IdUsuario")
     */
    protected $IdUsuario;

    /**
     * @ORM\Column(name="Orden")
     */
    protected $Orden;

    public function setNodo($Nodo)
    {
        $this->Nodo = $Nodo;
    }

    public function setUsuario($Usuario)
    {
        $this->Usuario = $Usuario;
    }

    public function setOrden($Orden)
    {
        $this->Orden = $Orden;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNodo()
    {
        return $this->Nodo;
    }

    public function getUsuario()
    {
        return $this->Usuario;
    }

    public function getOrden()
    {
        return $this->Orden;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"nodo": ' . $this->getNodo()->getJSON() .', ';
        $output .= '"usuario": ' . $this->getUsuario()->getJSON() .', ';
        $output .= '"orden": "' . $this->getOrden() .'", ';
        
        return '{' . $output . '}';
    }
}