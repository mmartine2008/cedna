<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="NotificacionesXPerfil")
 */
class NotificacionesXPerfil
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdNotificacionXPerfil", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="TiposEvento")
     * @ORM\JoinColumn(name="IdTipoEvento", nullable=false, referencedColumnName="IdTipoEvento")
     */
    protected $TipoEvento;

    /**
     * @ORM\ManyToOne(targetEntity="Perfiles")
     * @ORM\JoinColumn(name="IdPerfil", nullable=false, referencedColumnName="IdPerfil")
     */
    protected $Perfil;

    public function setTipoEvento($TipoEvento)
    {
        $this->TipoEvento = $TipoEvento;
    }

    public function setPerfil($Perfil)
    {
        $this->Perfil = $Perfil;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipoEvento()
    {
        return $this->TipoEvento;
    }

    public function getPerfil()
    {
        return $this->Perfil;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"tipoEvento": ' . $this->getTipoEvento()->getJSON() .', ';
        $output .= '"perfil": ' . $this->getPerfil()->getJSON() .'';
        
        return '{' . $output . '}';
    }
}