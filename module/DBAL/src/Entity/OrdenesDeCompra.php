<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="OrdenesDeCompra")
 */
class OrdenesDeCompra
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdOrdenDeCompra", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="FechaLiberacion")
     */
    protected $FechaLiberacion;

    /**
     * @ORM\Column(name="Descripcion")
     */
    protected $Descripcion;

    public function setFechaLiberacion($FechaLiberacion)
    {
        $this->FechaLiberacion = $FechaLiberacion;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFechaLiberacion()
    {
        if (is_string($this->FechaLiberacion)){
            $fecha = date("d-m-Y", strtotime($this->FechaLiberacion));
            return $fecha;
        }else{
            return $this->FechaLiberacion->format('d-m-Y');
        }
    }

    public function getNodo()
    {
        return $this->Nodo;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"fechaLiberacion": "' . $this->getFechaLiberacion() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion().'"';
        
        return '{' . $output . '}';
    }
}