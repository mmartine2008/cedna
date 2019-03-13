<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Eventos")
 */
class Eventos
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdEvento", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="TiposEvento")
     * @ORM\JoinColumn(name="IdTipoEvento", nullable=false, referencedColumnName="IdTipoEvento")
     */
    protected $TipoEvento;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdUsuario", nullable=false, referencedColumnName="IdUsuario")
     */
    protected $Usuario;

    /**
     * @ORM\Column(name="Fecha")
     */
    protected $Fecha;

    public function setTipoEvento($TipoEvento)
    {
        $this->TipoEvento = $TipoEvento;
    }

    public function setUsuario($Usuario)
    {
        $this->Usuario = $Usuario;
    }

    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipoEvento()
    {
        return $this->TipoEvento;
    }

    public function getUsuario()
    {
        return $this->Usuario;
    }

    public function getFecha()
    {
        return $this->Fecha;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"tipoEvento": ' . $this->getTipoEvento()->getJSON() .', ';
        $output .= '"usuario": ' . $this->getUsuario()->getJSON() .', ';
        $output .= '"fecha": "' . $this->getFecha() .'"';
        
        return '{' . $output . '}';
    }
}