<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="NodosFirmantesRelevamiento")
 */
class NodosFirmantesRelevamiento
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdNodoFirmanteRelevamiento", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Nodos")
     * @ORM\JoinColumn(name="IdNodo", referencedColumnName="IdNodo")
     */
    protected $Nodo;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdUsuarioFirmante", referencedColumnName="IdUsuario")
     */
    protected $UsuarioFirmante;

    /**
     * @ORM\ManyToOne(targetEntity="Relevamientos")
     * @ORM\JoinColumn(name="IdRelevamiento", referencedColumnName="IdRelevamiento")
     */
    protected $Relevamiento;

    /**
     * @ORM\Column(name="FechaFirma")
     */
    protected $FechaFirma;

    public function setNodo($Nodo)
    {
        $this->Nodo = $Nodo;
    }

    public function setUsuarioFirmante($UsuarioFirmante)
    {
        $this->UsuarioFirmante = $UsuarioFirmante;
    }
    
    public function setRelevamiento($Relevamiento)
    {
        $this->Relevamiento = $Relevamiento;
    }

    public function setFechaFirma($FechaFirma)
    {
        $this->FechaFirma = $FechaFirma;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNodo()
    {
        return $this->Nodo;
    }

    public function getUsuarioFirmante()
    {
        return $this->UsuarioFirmante;
    }

    public function getRelevamiento()
    {
        return $this->Relevamiento;
    }

    public function getFechaFirma()
    {
        if ($this->FechaFirma){
            if (is_string($this->FechaFirma)){
                $fecha = date("d-m-Y", strtotime($this->FechaFirma));
                return $fecha;
            }else{
                return $this->FechaFirma->format('d-m-Y');
            }
        }else{
            return null;
        }
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"fechaFirma": "' . $this->getFechaFirma() .'", ';
        $output .= '"nodo": ' . $this->getNodo()->getJSON() .', ';
        $output .= '"usuarioFirmante": ' . $this->getUsuarioFirmante()->getJSON();
        //No incluye la informacion del Relevamiento porque el relevamiento es el que pide este JSON
        
        return '{' . $output . '}';
    }
}