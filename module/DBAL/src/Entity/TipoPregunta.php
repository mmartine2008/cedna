<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="app.TipoPregunta")
 */
class TipoPregunta
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdTipoPregunta", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Descripcion",  nullable=false, type="string", length=1000)
     */
    protected $descripcion;

    /**
     * @ORM\Column(name="NroDestinos",  nullable=true, type="integer")
     */
    protected $cantDestinos;

    /**
     * @ORM\Column(name="Informacion",  nullable=false, type="string", length=1000)
     */
    protected $informacion;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of cantDestinos
     */ 
    public function getCantDestinos()
    {
        if($this->cantDestinos){
            return $this->cantDestinos;
        }
        return 0;
    }


    /**
     * Get the value of informacion
     */ 
    public function getInformacion()
    {
        return $this->informacion;
    }

    /**
     * Set the value of informacion
     *
     * @return  self
     */ 
    public function setInformacion($informacion)
    {
        $this->informacion = $informacion;

        return $this;
    }

    /**
     * Set the value of cantDestinos
     *
     * @return  self
     */ 
    public function setCantDestinos($cantDestinos)
    {
        $this->cantDestinos = $cantDestinos;

        return $this;
    }

    public function esPeguntaMultiple(){
        if($this->descripcion == 'multiple'){
            return true;
        } else {
            return false;
        }
    }

    public function esPeguntaArchivo(){
        if(($this->descripcion == 'file_file')||($this->descripcion == 'file_image')){
            return true;
        } else {
            return false;
        }
    }

    public function esImagen(){
        if($this->descripcion == 'file_image'){
            return true;
        } else {
            return false;
        }
    }

    public function esPdf(){
        if($this->descripcion == 'file_file'){
            return true;
        } else {
            return false;
        }
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"informacion": "' . $this->getInformacion() .'", ';
        $output .= '"destinos": "' . $this->getCantDestinos() .'"';

        return '{' . $output . '}';
    }
}