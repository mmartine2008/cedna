<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Inducciones")
 */
class Inducciones
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdInduccion", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Fecha")
     */
    protected $Fecha;

    /**
     * @ORM\Column(name="Descripcion")
     */
    protected $Descripcion;


    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        if (is_string($this->Fecha)){
            $fecha = date("d-m-Y", strtotime($this->Fecha));
            return $fecha;
        }else{
            return $this->Fecha->format('d-m-Y');
        }
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"fecha": "' . $this->getFecha() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'"';
        
        return '{' . $output . '}';
    }
}